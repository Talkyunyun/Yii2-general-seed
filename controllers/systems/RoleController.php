<?php
/**
 * 角色管理
 * @author: Gene
 */
namespace app\controllers\systems;


use app\controllers\BaseController;
use app\models\AdminUser\Access;
use app\models\AdminUser\Role;
use app\models\AdminUser\RoleUser;
use yii\data\Pagination;
use yii\web\Response;
use app\utils\Util;

class RoleController extends BaseController {

    // 列表
    public function actionIndex() {
        $request = \Yii::$app->request;

        $name  = $request->get('name', false);
        $where = '1=1';
        $bindParam = [];
        if (!empty($name)) {
            $where .= ' AND name like :name';
            $bindParam[':name'] = "%{$name}%";
        }
        $query = Role::find()->where($where, $bindParam);

        $total = $query->count();
        $page = new Pagination([
            'pageSize'   => 20,
            'totalCount' => $total
        ]);

        $result = $query
            ->offset($page->offset)
            ->limit($page->limit)
            ->orderBy('id desc')
            ->all();

        return $this->render($this->action->id, [
            'result'    => $result,
            'page'      => $page,
            'total'     => $total,
            'name'      => $name
        ]);
    }


    // 删除
    public function actionDel() {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $request = \Yii::$app->request;

        try {
            if (!$request->isPost) {
                throw new \Exception('没有发现该页面');
            }

            $id = (int)$request->post('id', 0);
            if (empty($id)) {
                throw new \Exception('请选择需要删除的角色');
            }
            // 删除角色
            Role::deleteAll('id=:id', [':id' => $id]);

            // 删除角色权限
            Access::deleteAll('role_id=:role_id', [':role_id'=>$id]);

            // 删除用户角色
            RoleUser::deleteAll('role_id=:role_id', [':role_id'=>$id]);

            $this->msg['data'] = '删除成功';

            return $this->msg;
        } catch (\Exception $e) {
            return $this->sendError(1001, $e->getMessage());
        }
    }


    // 修改信息
    public function actionUpdate() {
        $request = \Yii::$app->request;
        $id = (int)$request->get('id', 0);

        $result = Role::find()->where([
            'id' => $id
        ])->one();
        if (empty($result)) {
            alert('没有该角色信息', null, 2, true);
        }

        return $this->render($this->action->id, [
            'result' => $result
        ]);
    }

    // 添加
    public function actionCreate() {

        return $this->render($this->action->id);
    }

    // 保存
    public function actionSave() {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $request = \Yii::$app->request;

        $dbTrans = \Yii::$app->db->beginTransaction();
        try {
            if (!$request->isPost) {
                throw new \Exception('非法访问');
            }
            $data = $request->post();
            $id = (int)$data['id'];
            if (empty($id)) {// 添加
                $model = new Role();
            } else {// 修改
                $model = Role::findOne($id);
            }
            $model->attributes = $data;
            $model->remark = $data['remark'];
            $model->status = (int)$data['status'];
            if (!$model->validate()) {
                throw new \Exception(Util::getModelError($model->errors));
            }

            if ($model->save()) {
                if (!empty($data['nodes'])) {
                    $nodes = explode(',', $data['nodes']);
                    if (!is_array($nodes) || count($nodes) < 1) {
                        throw new \Exception('保存失败');
                    }
                    $roleId = $model->getAttribute('id');
                    // 1.删除旧权限
                    Access::deleteAll('role_id=:role_id', [':role_id' => $roleId]);

                    // 2.添加新权限
                    $newNode = [];
                    foreach ($nodes as $key => $nodeId) {
                        $newNode[$key][0] = $roleId;
                        $newNode[$key][1] = $nodeId;
                    }
                    \Yii::$app->db->createCommand()
                        ->batchInsert(Access::tableName(), ['role_id', 'node_id'], $newNode)
                        ->execute();
                }
                $dbTrans->commit();

                return $this->sendRes('保存成功', '保存成功', 0);
            }

            throw new \Exception('保存失败');
        } catch (\Exception $e) {
            $dbTrans->rollBack();

            return $this->sendRes($e->getMessage());
        }
    }
}