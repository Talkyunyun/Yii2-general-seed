<?php
/**
 * 首页控制
 * @author: Gene
 */
namespace app\controllers;

use app\models\AdminUser\Node;

class SiteController extends BaseController {

    // 默认首页
    public function actionWelcome() {

        return $this->render('welcome');
    }

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
}