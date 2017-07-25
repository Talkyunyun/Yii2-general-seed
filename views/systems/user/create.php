<?php

use yii\helpers\Url;

$this->title = '添加管理员';
?>
<style>
    legend {
        display: inherit;
        width: inherit;
        padding: 0;
        margin-bottom: 20px;
        font-size: 21px;
        line-height: inherit;
        color: #333;
        border: 0;
    }
    body{background: #fff !important;}
</style>
<div class="row">
    <form class="form-horizontal" method="post" action="">
        <div class="col-md-5">
            <div class="form-group">
                <label class="col-md-3 control-label">用户名</label>
                <div class="col-md-9">
                    <input type="text" id="username" class="form-control" placeholder="用户名">
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label class="col-md-3 control-label">密码</label>
                <div class="col-md-9">
                    <input type="password" id="password" class="form-control" placeholder="密码">
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label class="col-md-3 control-label">邮箱</label>
                <div class="col-md-9">
                    <input type="text" id="email" class="form-control" placeholder="邮箱">
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label class="col-md-3 control-label">姓名</label>
                <div class="col-md-9">
                    <input type="text" id="person" class="form-control" placeholder="姓名">
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="form-group">
                <label class="col-md-3 control-label">手机号码</label>
                <div class="col-md-9">
                    <input type="text" id="mobile" class="form-control" placeholder="手机号码">
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label for="sort_order" class="col-md-3 control-label">用户状态</label>
                <div class="col-md-9">
                    <select id="status" class="form-control">
                        <?php foreach ($status as $key=>$row) { ?>
                            <option value="<?= $key ?>"><?= $row ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="form-group">
                <label class="col-md-3 control-label">出生日期</label>
                <div class="col-md-9">
                    <input type="text"
                           class="form-control"
                           placeholder="出生日期"
                           onclick="APP.showDate(this)"
                           id="birth_date">
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label class="col-md-3 control-label">Auth Key</label>
                <div class="col-md-9">
                    <input type="text" id="auth_key" class="form-control" placeholder="Auth Key">
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label class="col-md-3 control-label">Access Token</label>
                <div class="col-md-9">
                    <input type="text" id="access_token" class="form-control" placeholder="Access Token">
                </div>
            </div>
        </div>

        <div style="clear: both;"></div>
        <div class="hr-line-dashed"></div>

        <div class="col-md-12">
            <fieldset class="layui-elem-field">
                <legend>角色分配</legend>
                <div class="layui-field-box">
                    <?php foreach ($roles as $row) { ?>
                        <label class="checkbox-inline">
                            <input type="checkbox" class="role_id" value="<?= $row['id'] ?>"> <?= $row['name'] ?>
                        </label>
                    <?php } ?>
                </div>
            </fieldset>
        </div>
    </form>
</div>

<script>
    function submit(index, callback) {
        var data = new Object();
        data.username = $('#username').val();
        data.mobile = $('#mobile').val();
        data.password = $('#password').val();
        data.email = $('#email').val();
        data.person = $('#person').val();
        data.code = $('#code').val();
        data.status = $('#status').val();
        data.group_id = $('#group_id').val();
        data.birth_date = $('#birth_date').val();
        data.auth_key = $('#auth_key').val();
        data.access_token = $('#access_token').val();
        data.recom_code = $('#recom_code').val();

        var roleIds = new Array();
        $(".role_id:checkbox:checked").each(function(){
            roleIds.push($(this).val())
        })
        roleIds = roleIds.join(',');
        data.roles = roleIds;

        APP.post("<?= Url::toRoute('systems/user/save') ?>", data, function(res) {
            if (res !== false) {
                APP.parent.APP.showMsg(res, 'success');
                APP.parent.layer.close(index);

                callback(true);
            }

            callback(false);
        });
    }
</script>
