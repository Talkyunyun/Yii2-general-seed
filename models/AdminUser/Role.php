<?php
namespace app\models\AdminUser;

use yii\db\ActiveRecord;

/**
 * Class Role 角色表
 * @package app\models\AdminUser
 * @property string $name 名称
 * @property int $status 状态值
 * @property string $remark 备注
 * @author Gene <https://github.com/Talkyunyun>
 */
class Role extends ActiveRecord {
    public static function tableName() {
        return 'sys_role';
    }


    public function rules() {
        return [
            [['name'], 'required', 'message' => '{attribute}为必填字段']
        ];
    }

    public function attributeLabels() {
        return [
            'name' => '角色名称'
        ];
    }

    /**
     * 获取状态数据
     * @return array
     */
    public static function getStatusList() {
        return [
            0 => '关闭',
            1 => '正常'
        ];
    }
}

