<?php

// 运行环境定义
define('ENV_PRD', 'prd');// 正式环境
define('ENV_DEV', 'dev');// 开发环境
define('ENV_LOCAL', 'local');// 本地环境

// 只需要设置该值,其他值不需要设置。
defined('YII_ENV') or define('YII_ENV', ENV_LOCAL);


// 只有正式环境debug关闭,其他都是打开
defined('YII_DEBUG') or define('YII_DEBUG', YII_ENV == ENV_PRD ? false : true);

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../config/bootstrap.php');

$config = require(__DIR__ . '/../config/main.php');
(new yii\web\Application($config))->run();