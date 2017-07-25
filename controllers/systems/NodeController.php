<?php
/**
 * 节点管理
 * @author: Gene
 */
namespace app\controllers\systems;


use app\controllers\BaseController;
use app\models\AdminUser\Node;
use app\models\AdminUser\Access;
use yii\web\Response;

class NodeController extends BaseController {

    // 列表
    public function actionIndex() {

        return $this->render($this->action->id);
    }

    // 获取全部节点列表
    public function actionGetData() {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $request = \Yii::$app->request;
        try {
            $roleId = (int)$request->post('role_id', 0);
            if (!empty($roleId)) {
                $roleNode = Access::find()->where(['role_id' => $roleId])->all();
                $roleNodes = [];
                foreach ($roleNode as $row) {
                    array_push($roleNodes, $row['node_id']);
                }
            }

            return $this->sendRes('获取成功', Node::getTreeMenu(0, 1, $roleNodes), 0);
        } catch (\Exception $e) {
            return $this->sendRes($e->getMessage());
        }
    }

    // 根据ID获取信息
    public function actionGetInfo() {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $request = \Yii::$app->request;

        try {
            $id = (int)$request->post('id', 0);
            $result = Node::getDataById($id);
            $this->msg['data'] = $result;

            return $this->msg;
        } catch (\Exception $e) {
            return $this->sendError(1001, $e->getMessage());
        }
    }

    // 删除
    public function actionDel() {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $request = \Yii::$app->request;

        try {
            if (!$request->isPost) {
                throw new \Exception('非法访问');
            }

            $id = (int)$request->post('id', 0);
            if (empty($id)) {
                throw new \Exception('请选择需要删除的节点');
            }
            $model = Node::find()->where([
                'id'      => $id,
                'can_del' => 1
            ])->one();
            if (empty($model)) {
                throw new \Exception('该节点或者菜单不允许删除');
            }
            $ids = Node::getMenuAllChildById($id);
            $ids[] = $id;
            # 1. 删除当前分类对应的所有子分类
            # 2. 删除在menu_id 对应到权限中的所有menu_id
            $db = \Yii::$app->auth_db;
            $dbTrans = $db->beginTransaction();
            try {
                foreach ($ids as $id) {
                    $num = $db->createCommand()
                        ->delete(Node::tableName(), 'can_del=1 AND app=1 AND id=' . (int)$id)
                        ->execute();
                    if (empty($num)) {
                        throw new \Exception('删除失败');
                    }
                }

                $dbTrans->commit();
                $this->msg['data'] = '删除成功';

                return $this->msg;
            } catch (\Exception $e) {
                $dbTrans->rollBack();

                throw new \Exception('删除失败');
            }
        } catch (\Exception $e) {
            return $this->sendError(1001, $e->getMessage());
        }
    }

    // 添加
    public function actionCreate() {
        $request = \Yii::$app->request;
        $pid = (int)$request->get('pid', 0);

        return $this->render($this->action->id, [
            'pid' => $pid
        ]);
    }

    // 保存
    public function actionSave() {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $request = \Yii::$app->request;

        try {
            if (!$request->isPost) {
                throw new \Exception('非法访问');
            }
            $data = $request->post();
            $id = (int)$data['id'];
            if (empty($id)) {// 添加
                $model = new Node();
                $model->setScenario('create');
            } else {// 修改
                $model = Node::findOne($id);
                $model->setScenario('update');
            }

            $model->setAttributes($data);
            if (!$model->validate()) {
                throw new \Exception(getModelError($model->errors));
            }
            if (!$model->save()) {
                throw new \Exception('保存失败');
            }
            $this->msg['data'] = '保存成功';

            return $this->msg;
        } catch (\Exception $e) {
            return $this->sendError(1001, $e->getMessage());
        }
    }
}