<?php
/**
 * Redis数据库配置
 * @author Gene <https://github.com/Talkyunyun>
 */

return [
    ENV_LOCAL => [
        'class' => 'yii\redis\Connection',
        'hostname' => '127.0.0.1',
        'port'     => 6379,
        'database' => 0,
        'password' => 'redis'
    ],
    ENV_DEV => [
        'class' => 'yii\redis\Connection',
        'hostname' => '127.0.0.1',
        'port'     => 6379,
        'database' => 0,
        'password' => 'redis'
    ],
    ENV_PRD => [
        'class' => 'yii\redis\Connection',
        'hostname' => '127.0.0.1',
        'port'     => 6379,
        'database' => 0,
        'password' => 'redis'
    ]
];