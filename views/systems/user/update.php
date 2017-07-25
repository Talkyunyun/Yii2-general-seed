<?php

use yii\helpers\Url;

$this->title = '修改管理员';
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
    <div class="col-md-12">
        <fieldset class="layui-elem-field">
            <legend>基本信息</legend>
            <div class="layui-field-box">
                <form class="form-horizontal" method="post" action="">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="col-md-3 control-label">用户名</label>
                            <div class="col-md-9">
                                <input type="text" id="username"
                                       value="<?= $result['username'] ?>"
                                       <?php if ($result['username'] == 'admin') {
                                           echo 'disabled';
                                       } ?>
                                       class="form-control" placeholder="用户名">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="col-md-3 control-label">密码</label>
                            <div class="col-md-9">
                                <input type="password" id="password"
                                       class="form-control" placeholder="密码">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="col-md-3 control-label">邮箱</label>
                            <div class="col-md-9">
                                <input type="text" id="email"
                                       value="<?= $result['email'] ?>"
                                       class="form-control" placeholder="邮箱">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="col-md-3 control-label">姓名</label>
                            <div class="col-md-9">
                                <input type="text" id="person"
                                       value="<?= $result['person'] ?>"
                                       class="form-control" placeholder="姓名">
                            </div>
                        </div>
                    </div>


                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="col-md-3 control-label">手机号码</label>
                            <div class="col-md-9">
                                <input type="text" id="mobile"
                                       value="<?= $result['mobile'] ?>"
                                       class="form-control" placeholder="手机号码">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="sort_order" class="col-md-3 control-label">用户状态</label>
                            <div class="col-md-9">
                                <select id="status" class="form-control"
                                    <?php if ($result['username'] == 'admin') {
                                        echo 'disabled';
                                    } ?>
                                >
                                    <?php if ($result['username'] == 'admin') { ?>
                                        <option value="1">有效</option>
                                    <?php } else { ?>
                                    <?php foreach ($status as $key=>$row) { ?>
                                        <option value="<?= $key ?>"
                                            <?php
                                            if ($result['status'] == $key) {
                                                echo 'selected';
                                            }
                                            ?>
                                        ><?= $row ?></option>
                                    <?php }} ?>
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
                                       value="<?= $result['birth_date'] ?>"
                                       id="birth_date">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Auth Key</label>
                            <div class="col-md-9">
                                <input type="text" id="auth_key"
                                       value="<?= $result['auth_key'] ?>"
                                       class="form-control"
                                       placeholder="Auth Key">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Access Token</label>
                            <div class="col-md-9">
                                <input type="text" id="access_token"
                                       value="<?= $result['access_token'] ?>"
                                       class="form-control" placeholder="Access Token">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </fieldset>
    </div>

    <?php if ($result['username'] != 'admin') { ?>
    <div class="col-md-12" style="margin-top:20px;">
        <fieldset class="layui-elem-field">
            <legend>角色分配</legend>
            <div class="layui-field-box">
                <?php foreach ($roles as $row) { ?>
                    <label class="checkbox-inline">
                        <input type="checkbox"
                               class="role_id"
                               value="<?= $row['id'] ?>"
                            <?php
                                if (in_array($row['id'], $userRoles)) {
                                    echo 'checked';
                                }
                            ?>
                        > <?= $row['name'] ?>
                    </label>
                <?php } ?>
            </div>
        </fieldset>
    </div>
    <?php } ?>
</div>

<script>
    function submit(index, callback) {
        var data = new Object();
        data.mobile = $('#mobile').val();
        data.password = $('#password').val();
        data.email = $('#email').val();
        data.person = $('#person').val();
        data.code = $('#code').val();
        data.group_id = $('#group_id').val();
        data.birth_date = $('#birth_date').val();
        data.auth_key = $('#auth_key').val();
        data.access_token = $('#access_token').val();
        data.recom_code = $('#recom_code').val();
        data.id = "<?= $result['id'] ?>";

        <?php if ($result['username'] != 'admin') { ?>
        data.username = $('#username').val();
        data.status = $('#status').val();
        var roleIds = new Array();
        $(".role_id:checkbox:checked").each(function(){
            roleIds.push($(this).val())
        })
        roleIds = roleIds.join(',');
        data.roles = roleIds;
        <?php } ?>

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
