<?php
/**
 * 公共环境参数
 * @author Gene <https://github.com/Talkyunyun>
 */

return [
    'app_name'     => 'Yii2 Seed General',// 应用名称
    'app_describe' => '我是APP应用的描述内容',
    'file_version' => 'v1.0.1', // 前端脚本版本

    'sys_user_email' => 'admin@126.com',

    // 应用地址
    'app_url' => [
        ENV_LOCAL => 'http://general.yii.com',
        ENV_DEV => '',
        ENV_PRD => ''
    ]
];