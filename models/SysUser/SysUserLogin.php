<?php
namespace app\models\SysUser;

use yii\base\Model;
use app\models\SysUser;

/**
 * Class SysUserLogin 系统用户登录模型
 * @package app\models\SysUser
 * @property string $email 登录邮箱
 * @property string $password 密码
 * @author Gene <https://github.com/Talkyunyun>
 */
class SysUserLogin extends Model {

    public $email;   // 登录邮箱
    public $password;// 登录密码

    // 用户对象
    private $sysUser;

    // 验证规则
    public function rules() {
        return [
            [['email', 'password'], 'required', 'message' => '{attribute}不能为空'],
            ['password', 'validatePassword']
        ];
    }

    // 别名
    public function attributeLabels() {
        return [
            'email'    => '登录邮箱',
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
            $sysUser = $this->getSysUser();
            if (empty($sysUser)) {
                $this->addError('email', '邮箱或者密码错误');
                return false;
            }

            if (!$sysUser->validatePassword($this->password)) {
                $this->addError('password', '邮箱或者密码错误');
                return false;
            }
        }
    }

    /**
     * 根据邮箱获取用户对象模型
     * @return static
     */
    public function getSysUser(){
        if($this->sysUser === null){
            $this->sysUser = SysUser::findNormalByEmail($this->email);
        }

        return $this->sysUser;
    }

    /**
     * 登录操作
     * @return bool
     */
    public function login() {
        if ($this->validate()) {
            return \Yii::$app->user->login($this->getSysUser(), 3600 * 24);
        } else {
            return false;
        }
    }
}