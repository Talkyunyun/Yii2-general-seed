<?php
/**
 * 正式环境
 * @author: Gene
 */

return [
    // 参数配置
    'params' => [],

    // 组件配置
    'components' => [
        'redis' => [
            'class'     => 'yii\redis\Connection',
            'hostname'  => '127.0.0.1',
            'port'      => 6379,
            'database'  => 0,
            'password'  => 'redis'
        ],
        'db' => [
            'class'       => 'yii\db\Connection',
            'dsn'         => 'mysql:host=127.0.0.1:3306;dbname=test',
            'username'    => 'root',
            'password'    => 'root',
            'charset'     => 'utf8',
            'tablePrefix' => 'a_'
        ]
    ]
];