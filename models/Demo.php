<?php
/**
 * 模型测试类
 * @author: Gene
 */

namespace app\models;

use yii\db\ActiveRecord;

class Demo extends ActiveRecord {

    // 表名定义
    public static function tableName() {
        return 'sys_demo'; // {{%articles}}
    }

    // 规则定义
    public function rules() {
        return [
            [['username', 'person'], 'required', 'message' => '{attribute}不能为空'],// 必填值
            ['status', 'in', 'range' => [1, 0], 'message' => '非法的状态值'], // 范围值
            ['email', 'email', 'message' => '请输入合法的邮箱地址'], // 邮箱
            ['url', 'url', 'message' => '请输入合法的url地址'], // url


            ['age', 'integer', 'message' => '请输入合法的url地址'], // 整数类型
            ['salary', 'number', 'message' => '请输入合法的url地址'], // 数字类型
            ['salary', 'double', 'message' => '请输入合法的url地址'], // double类型
            ['username', 'string', 'length' => [4, 24]], // 字符串长度限制


            ['status', 'default', 'value' => 1], // 默认值
        ];
    }

    // 别名
    public function attributeLabels() {
        return [
            'username' => '用户名',
            'person'   => '姓名'
        ];
    }


    // 场景定义 $model->setScenario('create');
    public function scenarios() {
        return [
            'create' => ['name', 'url', 'sort', 'font_icon', 'pid', 'status', 'is_menu'],
            'update' => ['name', 'url', 'sort', 'font_icon', 'status', 'is_menu']
        ];
    }
}



