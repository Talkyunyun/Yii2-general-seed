<?php
namespace app\commands;

use app\utils\LoggerUtil;
use yii\console\Controller;

/**
 * 命令案例
 * Class TestController
 * @package app\commands
 * @author Gene <https://github.com/Talkyunyun>
 */
class TestController extends Controller {

    // 访问: php yii test/index
    public function actionIndex() {
        die("sdfsdfdsf");
    }


    // 守护进程日志生成
    public function actionLog() {
        $logger = LoggerUtil::getLogger("logs_aa");

        $logger->info("我是命令进来的:", [
            "date" => date('Y-m-d H:i:s')
        ]);

        echo "hahah\r\n";
    }
}