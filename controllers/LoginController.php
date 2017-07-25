<?php
/**
 * 登录处理
 * @author: Gene
 */
namespace app\controllers;

use Yii;
use yii\web\Response;
use yii\web\Controller;
use app\utils\Util;
use app\models\AdminUser\AdminUserLogin;
use app\models\AdminUser\AdminUserLoginLog;

class LoginController extends Controller {

    // 发送相应
    private function sendRes($msg = '操作失败', $code = 1001) {
        return ['msg' => $msg, 'code' => $code];
    }

    /**
     * 登录页面
     * @return string
     */
    public function actionIndex() {
        $this->layout = false;

        // 判断是否已登录
        $isGuest = Yii::$app->user->isGuest;
        if(!$isGuest) {
            $this->redirect('/', 200);
        }

        return $this->render('index');
    }

    /**
     * 登录处理
     * @return array
     */
    public function actionDo() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;

        try {
            if (!$request->isPost) throw new \Exception('没有发现该页面', 1000);

            $isGuest = Yii::$app->user->isGuest;
            if(!$isGuest) {
                $this->sendRes('登录成功', 0);
            }
            $model = new AdminUserLogin();
            $model->username = $request->post('username', false);
            $model->password = $request->post('password', false);
            if (!$model->login()) {
                throw new \Exception(Util::getModelError($model->errors), 1001);
            }
            // 记录登录日志
            AdminUserLoginLog::add();

            return $this->sendRes('登录成功', 0);
        } catch (\Exception $e) {
            $msg = $e->getCode() == 0 ? '登录失败' : $e->getMessage();

            return $this->sendRes($msg);
        }
    }


    // 退出登录
    public function actionLogout() {
        $isGuest = Yii::$app->user->isGuest;
        if(!$isGuest){
            Yii::$app->user->logout();
        }

        $this->redirect('/login', 200);
    }
}