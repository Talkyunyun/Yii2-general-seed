<?php
/**
 * Created by PhpStorm.
 * User: gene
 * Date: 2017/7/24
 * Time: 下午2:39
 */

namespace app\models;

use app\models\AdminUser\Role;
use app\models\AdminUser\RoleUser;
use yii\db\ActiveRecord;
use yii\filters\RateLimitInterface;
use yii\web\IdentityInterface;

class AdminUser extends ActiveRecord implements IdentityInterface, RateLimitInterface {

    public static function tableName() {
        return 'sys_admin_user';
    }


    public function rules() {
        return [
            [['username', 'email', 'person'], 'required', 'message' => '{attribute}不能为空'],
            ['status', 'in', 'range' => [1, 0], 'message' => '非法的状态值'],
            [['access_token', 'auth_key', 'email', 'mobile', 'person'], 'safe']
        ];
    }

    // 别名
    public function attributeLabels() {
        return [
            'username' => '用户名',
            'person'   => '姓名',
            'email'    => '电子邮箱'
        ];
    }


    // 获取用户状态值
    public static function getStatusList() {
        return [
            1 => '生效',
            0 => '失效'
        ];
    }



    /**
     * 根据用户名获取用户对象
     * @param $username
     * @return static
     */
    public static function findByUsername($username) {
        try {
            return static::findOne([
                'username' => $username,
                'status'   => 1
            ]);
        } catch (\Exception $e) {
            return false;
        }
    }


    /**
     * 根据ID获取用户信息
     * @param $id
     */
    public static function getDataById($id, $fields = false) {
        try {
            $query = self::find()
                ->where(['id' => $id]);

            if ($fields !== false) {
                $query->select($fields);
            }

            return $query->one();
        } catch (\Exception $e) {
            return false;
        }
    }



    /**
     * 生成密码
     * @param string $password
     * @return string
     */
    public static function getNewPassword($password = '123456') {
        return \Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * 验证用户密码
     * @param $password
     * @return bool
     */
    public function validatePassword($password) {
        try {
            return \Yii::$app->security->validatePassword($password, $this->password);
        } catch (\Exception $e) {
            return false;
        }
    }

    // 获取用户角色列表
    public static function getUserRolesByUid($uid = 0) {
        try {
            $data = Role::find()
                ->from(RoleUser::tableName() . ' a')
                ->leftJoin(Role::tableName() . ' b', 'a.role_id=b.id')
                ->select('b.name')
                ->where(['a.user_id' => $uid])
                ->asArray()
                ->all();

            return $data;
        } catch (\Exception $e) {
            return false;
        }
    }



    /**
     * 通过id 找到identity
     * @param int|string $id
     * @return static
     */
    public static function findIdentity($id)  {
        return static::findOne(['id' => $id, 'status' => 1]);
    }


    /**
     * 通过access_token 找到identity
     * @param mixed $token
     * @param null $type
     * @return static
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        return static::findOne(['access_token' => $token, 'status' => 1]);
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }


    /**
     * 设置访问速度,6秒内只能访问6次
     * @param \yii\web\Request $request
     * @param \yii\base\Action $action
     * @return array
     */
    public function getRateLimit($request, $action) {
        return [6000000, 6];
    }

    /**
     * 返回剩余的允许的请求和相应的UNIX时间戳数 当最后一次速率限制检查时。
     * @param \yii\web\Request $request
     * @param \yii\base\Action $action
     * @return array
     */
    public function loadAllowance($request, $action) {
        return [$this->allowance, $this->allowance_updated_at];
    }

    /**
     * allowance 对应user 表的allowance字段  int类型
     * allowance_updated_at 对应user allowance_updated_at  int类型
     * 文档标注：保存允许剩余的请求数和当前的UNIX时间戳。
     * @param \yii\web\Request $request
     * @param \yii\base\Action $action
     * @param int $allowance
     * @param int $timestamp
     */
    public function saveAllowance($request, $action, $allowance, $timestamp) {
        $this->allowance = $allowance;
        $this->allowance_updated_at = $timestamp;
        $this->save();
    }
}



