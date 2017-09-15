<?php
/**
 * 错误处理显示
 * @author: Gene
 */

namespace app\controllers;

use yii\web\Controller;

class ErrorController extends Controller {

    public function actionShow() {

        return $this->render('404');
    }
}