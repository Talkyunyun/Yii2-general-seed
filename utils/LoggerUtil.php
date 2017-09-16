<?php
namespace app\utils;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * 日志工具类
 * Class LoggerUtil
 * @package app\utils
 * @author Gene <https://github.com/Talkyunyun>
 */
class LoggerUtil {

    /**
     * 获取monolog操作对象
     * @param string $fileName
     * @return mixed
     */
    public static function getLogger($fileName = 'app') {
        static $logers;

        $fileName = trim($fileName);
        if (empty($fileName)) {
            $fileName = 'app';
        }

        if (!isset($logers[$fileName])) {
            $loger = new Logger($fileName);
            $file  = \Yii::$app->runtimePath . '/logs/' . $fileName . '.log';
            $loger->pushHandler(new StreamHandler($file, Logger::INFO));
            $logers[$fileName] = $loger;
        }

        return $logers[$fileName];
    }
}