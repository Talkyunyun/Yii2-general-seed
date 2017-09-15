<?php
/**
 * 登录拦截器
 * @author: Gene
 */

namespace app\filter;

use yii\base\ActionFilter;

class AuthFilter extends ActionFilter {
    public $rules = [];

    public $actions = [];


    /**
     * 判断是否登录
     * @param \yii\base\Action $action
     * @return bool|void
     */
    public function beforeAction($action) {
        $isGuest = \Yii::$app->user->isGuest;
        if($isGuest) {
            return \Yii::$app->response->redirect('/login')->send();
        }

        return true;
    }
}