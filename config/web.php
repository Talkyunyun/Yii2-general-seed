<?php
/**
 * 项目主配置文件
 * @author: Gene
 */

$config = [
    'id'                 => 'Yii2-Seed-General',
    'basePath'           => dirname(__DIR__),
    'charset'            => 'utf-8',
    'language'           => 'zh-CN',
    'timeZone'           => 'Asia/Shanghai',
    'bootstrap'          => ['log'],
    'controllerNamespace'=> 'app\controllers',

    // 公共的参数
    'params' => require_once __DIR__ . '/params.php',

    // 公共组件
    'components' => [
        'request' => [
            'csrfParam' => '_csrf',
            'cookieValidationKey' => 'sa2g5UDQPsDd3ImHgXwAa3yrFP6OHovOd3gq5RM'
        ],
        'redisCache' => [
            'class' => 'yii\redis\Cache',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass'   => 'app\models\AdminUser',
            'enableAutoLogin' => true,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules' => require_once __DIR__ . '/routes.php'
        ],
        'log'     => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class'   => 'yii\log\FileTarget',
                    'levels'  => ['error', 'warning', 'trace' ,'info'],
                    'logVars' => [],
                    'logFile' => '@app/runtime/logs/run_'.date('Y-m-d').'.log'
                ]
            ],
        ]
    ]
];

// 加载对应环境配置文件
$envConfig = require_once __DIR__ . '/config-' . YII_ENV . '.php';

// 合并配置
$config['params']     = array_merge($config['params'], $envConfig['params']);
$config['components'] = array_merge($config['components'], $envConfig['components']);


// 只有正式环境才会显示友好的错误页面
if (!YII_DEBUG) {
    $config['components']['errorHandler'] = [
        'errorAction' => 'error/show'
    ];
}

return $config;