<?php
/**
 * 命令行配置文件
 * @author Gene <https://github.com/Talkyunyun>
 */

$config = [
    'id' => 'Yii2-Seed-General-Console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [],
    'language' => 'zh-CN',
    'charset' => 'UTF-8',
    'timeZone' => 'Asia/Shanghai',
    'controllerNamespace' => 'app\commands',

    // 公共参数
    'params' => require(__DIR__ . '/params.php'),

    // 公共组件
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'redis' => (require_once __DIR__ . '/redis.php')[YII_ENV],
        'db' => (require_once __DIR__ . '/mysql.php')[YII_ENV]
    ]
];

return $config;