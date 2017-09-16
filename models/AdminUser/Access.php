<?php
namespace app\models\AdminUser;

use yii\db\ActiveRecord;

/**
 * Class Access 权限表
 * @package app\models\AdminUser
 * @property int $role_id 角色ID
 * @property int $node_id 节点ID
 * @author Gene <https://github.com/Talkyunyun>
 */
class Access extends ActiveRecord {
    public static function tableName() {
        return 'sys_access';
    }
}

