<?php
namespace app\controllers;

use app\filter\AuthFilter;
use yii\web\Controller;


/**
 * 后台访问基本
 * @author Gene <https://github.com/Talkyunyun>
 */
class BaseController extends Controller {

    // 定义行为
    public function behaviors() {
        return [
            'access' => [
                'class' => AuthFilter::className()
            ]
        ];
    }
}