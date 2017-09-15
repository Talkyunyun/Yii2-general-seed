<?php
/**
 * 后台访问基本
 * @author: Gene
 */

namespace app\controllers;


use app\filter\AuthFilter;
use yii\web\Controller;

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