<?php

namespace app\models\AdminUser;

/**
 * Created by PhpStorm.
 * User: gene
 * Date: 2017/7/24
 * Time: 下午3:11
 */

use app\utils\ClientUtil;
use yii\db\ActiveRecord;

class AdminUserLoginLog extends ActiveRecord {

    public static function tableName() {
        return 'sys_admin_user_login_log';
    }

    /**
     * 记录登录日志
     * @return bool
     */
    public static function add() {
        $model = new self();

        $data = [
            'post' => \Yii::$app->request->post(),
            'get'  => \Yii::$app->request->get()
        ];

        $model->uid  = \Yii::$app->user->identity->id;
        $model->ip   = \Yii::$app->request->userIP;
        $model->data = json_encode($data);
        $model->url  = \Yii::$app->request->getScriptUrl();
        $model->create_time = time();
        $model->client_type = ClientUtil::getClientInfo()['name'];

        return $model->save();
    }

    /**
     * 获取用户最后一次登录时间
     * @return bool|mixed
     */
    public static function getLastTime() {
        try {
            return self::find()
                ->where([
                    'uid' => \Yii::$app->user->identity->id
                ])->orderBy('create_time desc')->one()->create_time;
        } catch (\Exception $e) {
            return false;
        }
    }
}