<?php
/**
 * 命令行配置文件
 * @author: Gene
 */

$config = [
    'id'                 => 'Yii2-Seed-General-Console',
    'basePath'           => dirname(__DIR__),
    'bootstrap'          => ['log'],
    'language'           => 'zh-CN',
    'charset'            => 'UTF-8',
    'timeZone'           => 'Asia/Shanghai',
    'controllerNamespace'=> 'app\commands',


    // 公共参数
    'params' => require(__DIR__ . '/params.php'),

    // 公共组件
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class'   => 'yii\log\FileTarget',
                    'levels'  => ['error', 'warning', 'trace' ,'info'],
                    'logVars' => [],
                    'logFile' => '@app/runtime/console_logs/'.date('Y-m-d').'.log'
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

return $config;