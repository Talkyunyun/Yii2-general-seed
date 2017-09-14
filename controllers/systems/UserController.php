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
use app\utils\ResponseUtil;
use app\utils\Util;
use yii\data\Pagination;

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
            'result' => $data,
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


    // 添加
    public function actionCreate() {
        // 获取所有角色
        $roles = Role::find()
            ->select('id, name')
            ->where(['status' => 1])
            ->asArray()
            ->all();

        return $this->render($this->action->id, [
            'roles' => $roles
        ]);
    }

    // 修改
    public function actionUpdate() {
        $request = \Yii::$app->request;

        $id     = $request->get('id', 0);
        $result = AdminUser::getDataById($id);
        if (empty($result)) {
            Util::alert('没有该用户信息');
        }

        // 获取所有角色
        $roles = Role::find()->select('id, name')
            ->where(['status' => 1])
            ->all();

        // 获取用户角色
        $userRoles = RoleUser::getUserRoleAll($id);

        return $this->render($this->action->id, [
            'result'    => $result,
            'roles'     => $roles,
            'userRoles' => $userRoles
        ]);
    }

    // 保存
    public function actionSave() {
        $request = \Yii::$app->request;

        $dbTrans = \Yii::$app->db->beginTransaction();
        try {
            $data = $request->post();
            $id   = (int)$data['id'];
            $now  = time();
            if (empty($id)) {// 添加
                $model = new AdminUser();
                $model->create_time   = $now;
                $model->password = AdminUser::getNewPassword($data['password']);
            } else {// 修改
                $model = AdminUser::findOne($id);
                if (!empty($data['password'])) {
                    $model->password = AdminUser::getNewPassword($data['password']);
                }
            }
            $model->attributes  = $data;
            $model->update_time = $now;
            if (!$model->validate()) {
                throw new \Exception(Util::alert($model->errors), 1001);
            }
            if (!$model->save()) {
                throw new \Exception('保存失败', 1002);
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
                    $authDb = \Yii::$app->db;
                    if (!$authDb->createCommand()
                        ->batchInsert(RoleUser::tableName(), ['role_id', 'user_id'], $newRole)
                        ->execute()) {
                        throw new \Exception('保存失败', 1003);
                    }
                }
            }
            $dbTrans->commit();

            return ResponseUtil::success('保存成功');
        } catch (\Exception $e) {
            $dbTrans->rollBack();
            $msg = $e->getCode() == 0 ? '保存失败' : $e->getMessage();

            return ResponseUtil::error($e->getMessage());
        }
    }



    // 修改密码
    public function actionPassword() {

        echo 3;
    }


    // 查看个人信息
    public function actionView() {

        echo 33;
    }
}