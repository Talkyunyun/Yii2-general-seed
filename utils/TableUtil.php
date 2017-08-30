<?php
/**
 * YII2表操作
 * @author: Gene
 */
namespace app\utils;

use yii\helpers\ArrayHelper;

class TableUtil {


    /**
     * 根据表名获取所有字段
     * @param string $tableName
     * @return array
     */
    public static function getTableAllFields(string $tableName) {
        $fields = [];
        try {
            $tableSchema = \Yii::$app->db->schema->getTableSchema($tableName);
            $fields = ArrayHelper::getColumn($tableSchema->columns, 'name', false);
        } catch (\Exception $e) { }

        return $fields;
    }
}