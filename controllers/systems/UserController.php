<?php
/**
 * 管理员管理
 * @author: Gene
 */
namespace app\controllers\systems;

use app\controllers\BaseController;
use app\models\AdminUser;
use app\models\AdminUser\Role;
use app\models\AdminUser\RoleUser;
use yii\data\Pagination;
use yii\web\Response;

class UserController extends BaseController {


    /**
     * 管理员列表
     * @return string
     */
    public function actionIndex() {
        $request = \Yii::$app->request;

        $status     = $request->get('status', 'all');
        $userName   = $request->get('username', false);
        $mobile     = $request->get('mobile', false);
        $email      = $request->get('email', false);
        $dateType   = $request->get('dateType', false);
        $startDate  = $request->get('start_date', false);
        $endDate    = $request->get('end_date', false);

        $where = 'status<>9';
        $bindParam = [];
        if ($status != 'all') {
            $where .= ' AND status=:status';
            $bindParam[':status'] = $status;
        }
        if (!empty($userName)) {
            $where .= ' AND username like :username';
            $bindParam[':username'] = "%{$userName}%";
        }
        if (!empty($mobile)) {
            $where .= ' AND mobile=:mobile';
            $bindParam[':mobile'] = $mobile;
        }
        if (!empty($email)) {
            $where .= ' AND email like :email';
            $bindParam[':email'] = "%{$email}%";
        }

        // 处理时间筛选
        if (!empty($dateType)) {
            if ($dateType == -1) {
                $beginTime = strtotime($startDate);
                $endTime = strtotime($endDate);
            } else {
                $day = $dateType == 1 ? 0 : $dateType;
                $beginTime = mktime(0, 0, 0, date('m'), date('d') - $day, date('Y'));
                $endTime = mktime(23, 59, 59, date('m'), date('d'), date('Y'));
            }

            $where .= ' AND create_time>=:beginTime AND create_time<=:endTime';
            $bindParam[':beginTime'] = $beginTime;
            $bindParam[':endTime'] = $endTime;
        }

        $query = AdminUser::find()
        ->where($where, $bindParam);

        $total = $query->count();
        $page  = new Pagination([
            'pageSize'   => 20,
            'totalCount' =>$total
        ]);

        $data = $query
            ->offset($page->offset)
            ->limit($page->limit)
            ->orderBy('create_time desc')
            ->asArray()
            ->all();

        foreach ($data as $key=>$row) {
            $data[$key]['roles'] = AdminUser::getUserRolesByUid($row['id']);
        }

        return $this->render($this->action->id, [
            'data' => $data,
            'page' => $page,
            'total'=> $total,
            'statusList' => AdminUser::getStatusList(),
            'status'    => $status,
            'username'  => $userName,
            'code'      => $code,
            'mobile'    => $mobile,
            'email'     => $email,
            'dateType'  => $dateType,
            'startDate' => $startDate,
            'endDate'   => $endDate,
        ]);
    }

    /**
     * 控制用户失效和生效
     * @return array
     */
    public function actionState() {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $request = \Yii::$app->request;

        try {
            $id    = (int)$request->post('id', 0);
            $type  = (int)$request->post('type', 0);
            $model = AdminUser::find()
                ->where('id=:id AND username<>"admin" AND status<>10', [':id' => $id])
                ->one();
            if (empty($model)) {
                throw new \Exception('该用户不允许操作');
            }

            if ($type == 1) {// 生效
                $model->status = 1;
            } else {
                $model->status = 0;
            }
            $model->updated_at = time();
            if ($model->save()) {
                $this->msg['data'] = '更新成功';

                return $this->msg;
            }

            throw new \Exception('更新失败');
        } catch (\Exception $e) {
            return $this->sendError(1001, $e->getMessage());
        }
    }

    // 添加
    public function actionCreate() {
        // 获取所有角色
        $roles = Role::find()->select('id, name')
            ->where(['status' => 1])
            ->all();

        return $this->render($this->action->id, [
            'status' => AdminUser::getStatusList(),
            'roles' => $roles
        ]);
    }

    // 修改
    public function actionUpdate() {
        $request = \Yii::$app->request;
        $id = (int)$request->get('id', 0);
        $result = AdminUser::getDataById($id);
        if (empty($result)) {
            alert('没有该用户信息', null, 2, true);
        }

        // 获取所有角色
        $roles = Role::find()->select('id, name')
            ->where(['status' => 1])
            ->all();

        // 获取用户角色
        $userRoles = RoleUser::getUserRoleAll($id);

        return $this->render($this->action->id, [
            'result'    => $result,
            'status'    => AdminUser::getStatusList(),
            'roles'     => $roles,
            'userRoles' => $userRoles
        ]);
    }

    // 保存
    public function actionSave() {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $request = \Yii::$app->request;

        $dbTrans = \Yii::$app->db->beginTransaction();
        try {
            $data = $request->post();
            $id = (int)$data['id'];
            if (empty($id)) {// 添加
                $model = new AdminUser();
                $model->created_at = time();
                $model->created_at_datetime = date('Y-m-d H:i:s');
                $model->password_hash = AdminUser::getNewPassword($data['password']);
                $model->setScenario('create');
            } else {// 修改
                $model = AdminUser::findOne($id);
                if (!empty($data['password'])) {
                    $model->password_hash = AdminUser::getNewPassword($data['password']);
                }
                $model->setScenario('update');
            }
            $model->attributes = $data;
            $model->updated_at = time();
            $model->recom_code = $data['recom_code'];
            $model->updated_at_datetime = date('Y-m-d H:i:s');
            if (!$model->validate()) {
                throw new \Exception(getModelError($model->errors));
            }
            if (!$model->save()) {
                throw new \Exception('保存失败');
            }
            $roles = $data['roles'];
            if (!empty($roles)) {
                $roles = explode(',', $roles);
                if (is_array($roles) && count($roles) > 0) {
                    $uid = $model->getAttribute('id');
                    // 1、删除旧角色
                    RoleUser::deleteAll('user_id=:uid', [':uid' => $uid]);

                    // 2、添加新角色
                    $newRole = [];
                    foreach ($roles as $key=>$row) {
                        $newRole[$key][0] = $row;
                        $newRole[$key][1] = $uid;
                    }
                    $authDb = \Yii::$app->auth_db;
                    if (!$authDb->createCommand()
                        ->batchInsert(RoleUser::tableName(), ['role_id', 'user_id'], $newRole)
                        ->execute()) {
                        throw new \Exception('保存失败');
                    }
                }
            }
            $dbTrans->commit();
            $this->msg['data'] = '保存成功';

            return $this->msg;
        } catch (\Exception $e) {
            $dbTrans->rollBack();
            return $this->sendError(1001, $e->getMessage());
        }
    }
}