<?php
namespace app\models\AdminUser;

use yii\db\ActiveRecord;

class Access extends ActiveRecord {
    public static function tableName() {
        return 'sys_access';
    }
}

