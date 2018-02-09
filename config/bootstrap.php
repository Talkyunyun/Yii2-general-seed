<?php
/**
 * APP启动最先执行程序
 * @author Gene <https://github.com/Talkyunyun>
 */

// 加载常量配置文件
require_once __DIR__ . '/constants.php';

// 设置运行环境,同时控制web和console
defined('YII_ENV') or define('YII_ENV', ENV_LOCAL);


// 只有正式环境debug关闭,其他都默认打开
defined('YII_DEBUG') or define('YII_DEBUG', YII_ENV == ENV_PRD ? false : true);


function dd($data = []) {
    var_dump($data);die;
};