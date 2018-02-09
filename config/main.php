<?php
/**
 * 项目主配置文件
 * @author Gene <https://github.com/Talkyunyun>
 */

$config = [
    'id' => 'Yii2-Seed-General',
    'basePath' => dirname(__DIR__),
    'charset' => 'utf-8',
    'language' => 'zh-CN',
    'timeZone' => 'Asia/Shanghai',
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\controllers',

    // 公共的参数
    'params' => require_once __DIR__ . '/params.php',

    // 公共组件
    'components' => [
        'request' => [
            'csrfParam' => 'token',
            'cookieValidationKey' => '5UDsdQPsSsDdfDSDDd3U2pl4oa232gOd3gq5RM'
        ],
        'redisCache' => [
            'class' => 'yii\redis\Cache',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\SysUser',
            'enableAutoLogin' => true,
        ],
        'redis' => (require_once __DIR__ . '/redis.php')[YII_ENV],
        'db' => (require_once __DIR__ . '/mysql.php')[YII_ENV],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => require_once __DIR__ . '/routes.php'
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'trace', 'info'],
                    'logVars' => [],
                    'logFile' => '@app/runtime/logs/run_' . date('Y-m-d') . '.log'
                ]
            ],
        ]
    ]
];

return $config;