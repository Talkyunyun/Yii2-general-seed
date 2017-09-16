<?php
/**
 * WEB入口文件,不允许在该文件添加或者修改任何代码
 * @author Gene <https://github.com/Talkyunyun>
 */

// 加载初始化脚本
require_once __DIR__ . '/../config/bootstrap.php';

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
$config = require_once __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();