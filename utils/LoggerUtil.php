<?php
namespace app\utils;

use Monolog\Formatter\LineFormatter;
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
     * @param bool $fileName
     * @return Logger
     */
    public static function getLogger($fileName = false) {
        $fileName = trim($fileName);
        if (empty($fileName)) {
            $fileName = 'app_' . date('Y-m-d');
        }

        $loger = new Logger($fileName);
        $file  = \Yii::$app->runtimePath . '/logs/' . $fileName . '.log';

        $stream = new StreamHandler($file, Logger::INFO);
        $output = "[%datetime%]-%level_name% %message% %context% %extra%\n";
        $formatter = new LineFormatter($output);
        $stream->setFormatter($formatter);

        $loger->pushHandler($stream);

        return $loger;
    }
}