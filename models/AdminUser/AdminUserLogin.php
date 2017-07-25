<?php
/**
 * Created by PhpStorm.
 * User: gene
 * Date: 2017/7/24
 * Time: 下午3:18
 */

namespace app\models\AdminUser;


use yii\base\Model;
use app\models\AdminUser;

class AdminUserLogin extends Model {
    public $username;
    public $password;

    private $_admin_user;

    // 验证规则
    public function rules() {
        return [
            [['username', 'password'], 'required', 'message' => '{attribute}不能为空'],
            ['password', 'validatePassword']
        ];
    }

    // 别名
    public function attributeLabels() {
        return [
            'username' => '用户名',
            'password' => '密码'
        ];
    }

    /**
     * 验证密码是否正确
     * @param $attribute
     * @param $params
     */
    public function validatePassword($attribute, $params){
        if (!$this->hasErrors()) {
            $AdminUser = $this->getAdminUser();
            if (empty($AdminUser)) {
                $this->addError('username', '用户名或者密码错误');
                return false;
            }

            if (!$AdminUser->validatePassword($this->password)) {
                $this->addError('password', '用户名或者密码错误');
                return false;
            }
        }
    }

    /**
     * 根据用户名获取用户对象模型
     * @return static
     */
    public function getAdminUser(){
        if($this->_admin_user === null){
            $this->_admin_user = AdminUser::findByUsername($this->username);
        }

        return $this->_admin_user;
    }

    /**
     * 登录操作
     * @return bool
     */
    public function login() {
        if ($this->validate()) {
            return \Yii::$app->user->login($this->getAdminUser(), 3600 * 24);
        } else {
            return false;
        }
    }
}