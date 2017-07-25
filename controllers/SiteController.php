<?php
/**
 * 首页控制
 * @author: Gene
 */
namespace app\controllers;

use app\models\AdminUser\Node;

class SiteController extends BaseController {

    /**
     * 框架主体
     * @return string
     */
    public function actionIndex() {
        $this->layout = false;

        return $this->render('main', [
            'menu' => Node::getMenus()
        ]);
    }

    // 默认首页
    public function actionHome() {
        return $this->render('home', [
            'isMobile'=>$isMobile
        ]);
    }

    // 错误显示
    public function actionError() {

        return $this->render('error');
    }

}