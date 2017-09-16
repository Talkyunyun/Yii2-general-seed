<?php
namespace app\controllers;

use Yii;
use app\utils\Util;
use yii\web\Controller;
use app\utils\ResponseUtil;
use app\models\AdminUser\AdminUserLogin;
use app\models\AdminUser\AdminUserLoginLog;

/**
 * 登录控制器
 * Class LoginController
 * @package app\controllers
 * @author Gene <https://github.com/Talkyunyun>
 */
class LoginController extends Controller {

    /**
     * 登录页面
     * @return string
     */
    public function actionIndex() {
        $this->layout = false;

        // 判断是否已登录
        $isGuest = Yii::$app->user->isGuest;
        if(!$isGuest) {
            return $this->redirect('/', 200);
        }

        return $this->render('index');
    }

    /**
     * 登录处理
     * @return array
     */
    public function actionDo() {
        $request = Yii::$app->request;

        try {
            if (!$request->isPost) {
                throw new \Exception('没有发现该页面', 1000);
            }

            $isGuest = Yii::$app->user->isGuest;
            if(!$isGuest) {
                return ResponseUtil::success('登录成功');
            }
            $model = new AdminUserLogin();
            $model->username = $request->post('username', false);
            $model->password = $request->post('password', false);
            if (!$model->login()) {
                throw new \Exception(Util::getModelError($model->errors), 1001);
            }
            // 记录登录日志
            AdminUserLoginLog::add();

            return ResponseUtil::success('登录成功');
        } catch (\Exception $e) {
            $msg = $e->getCode() == 0 ? '登录失败' : $e->getMessage();

            return ResponseUtil::error($msg);
        }
    }


    // 退出登录
    public function actionLogout() {
        $isGuest = Yii::$app->user->isGuest;
        if(!$isGuest){
            Yii::$app->user->logout();
        }

        return $this->redirect('/login', 200);
    }
}