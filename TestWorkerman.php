#!/usr/bin/env php
<?php
/**
 * Workerman定时器案例
 * php TestWorkerman.php start|stop|restart|status [-d]
 * @author Gene <https://github.com/Talkyunyun>
 */

require_once __DIR__ . '/vendor/workerman/workerman/Autoloader.php';

use \Workerman\Worker;
use \Workerman\Lib\Timer;

$work = new Worker();
$work->count = 1;
$work->onWorkerStart = function($conn) {
    $conn->timerId = Timer::add(5, function() {
        // TODO 执行实际逻辑代码
        echo "我是肯定就是\n";
    });
};

// 关闭连接时清除定时器
$work->onClose = function($conn) {
    Timer::del($conn->timerId);
};

// 运行
Worker::runAll();