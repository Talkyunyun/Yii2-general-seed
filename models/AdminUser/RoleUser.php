<?php
namespace app\models\AdminUser;

use yii\db\ActiveRecord;

/**
 * Class RoleUser 用户角色表
 * @package app\models\AdminUser
 * @property int $role_id 角色ID
 * @property int $user_id 用户UID
 * @author Gene <https://github.com/Talkyunyun>
 */
class RoleUser extends ActiveRecord {
    public static function tableName() {
        return 'sys_role_user';
    }

    /**
     * 获取用户所有角色
     * @param int $uid
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getUserRoleAll($uid = 0) {
        try {
            $result = self::find()->select('role_id')
                ->where(['user_id' => $uid])
                ->asArray()
                ->all();
            $data = [];
            foreach ($result as $row) {
                array_push($data, $row['role_id']);
            }

            return $data;
        } catch (\Exception $e) {
            return [];
        }
    }
}

