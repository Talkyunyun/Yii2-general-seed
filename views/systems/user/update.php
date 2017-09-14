<?php

use yii\helpers\Url;

$this->title = '修改管理员';
?>
<style>
    .layui-form-label {
        float: left;
        display: block;
        padding: 9px 15px;
        width: 120px;
        font-weight: 400;
        text-align: right;
    }
    .role_box{
        padding: 20px 12px;
    }
    .role_box h3{
        border-bottom: 1px solid #dadada;
        padding: 10px 0 5px 0;
    }
    .role_box ul{
        display: flex;
        justify-content: flex-start;
    }
    .role_box ul li{
        margin-top:12px;
    }
</style>
<div class="col-md-12 animated fadeIn node_edit">
    <div class="col-md-12" style="margin-bottom:20px;margin-top:20px;">
        <div class="bg-info" style="padding:10px;">
            <b>特别说明：</b>
            <p>1、哈哈哈哈</p>
        </div>
    </div>

    <form class="layui-form" method="post">

        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">用户名</label>
                <div class="layui-input-inline">
                    <input type="text" id="username" value="<?= $result['username'] ?>" class="form-control" placeholder="用户名" />
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">密码</label>
                <div class="layui-input-inline">
                    <input type="password" id="password" class="form-control" placeholder="密码" />
                </div>
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">邮箱</label>
                <div class="layui-input-inline">
                    <input type="email" id="email" value="<?= $result['email'] ?>" class="form-control" placeholder="邮箱" />
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">姓名</label>
                <div class="layui-input-inline">
                    <input type="text" id="person" value="<?= $result['person'] ?>" class="form-control" placeholder="姓名" />
                </div>
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">手机号码</label>
                <div class="layui-input-inline">
                    <input type="number" id="mobile" value="<?= $result['mobile'] ?>" class="form-control" placeholder="手机号码" />
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">出生日期</label>
                <div class="layui-input-inline">
                    <input type="text" id="birth_date" class="form-control" placeholder="出生日期" />
                </div>
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">Auth Key</label>
                <div class="layui-input-inline">
                    <input type="text" id="auth_key" value="<?= $result['auth_key'] ?>" class="form-control" placeholder="Auth Key" />
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">Access Token</label>
                <div class="layui-input-inline">
                    <input type="text" id="access_token" value="<?= $result['access_token'] ?>" class="form-control" placeholder="Access Token" />
                </div>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block">
                <input type="radio"
                       <?php
                        if ($result['status'] == 1) {
                            echo 'checked';
                        }
                       ?>
                       name="status" value="1" class="form-control" title="有效"  />
                <input type="radio"
                       <?php
                        if ($result['status'] == 0) {
                            echo 'checked';
                        }
                       ?>
                       name="status" value="0" class="form-control" title="无效" />
            </div>
        </div>

        <div class="role_box">
            <h3>角色分配</h3>
            <ul>
                <?php foreach ($roles as $item) { ?>
                    <li>
                        <input type="checkbox" name="role_id[]"
                                <?php
                                    if (in_array($item['id'], $userRoles)) {
                                        echo 'checked';
                                    }
                                ?>
                               class="role_id" value="<?= $item['id'] ?>"
                               lay-skin="primary" title="<?= $item['name'] ?>" />
                    </li>
                <?php } ?>
            </ul>
        </div>
    </form>
</div>
<script>
    layui.use('laydate', function(){
        var laydate = layui.laydate;
        laydate.render({
            elem: '#birth_date'
        });
    });

    function submit(index, callback) {
        var data = new Object();
        data.username = $('#username').val();
        data.mobile = $('#mobile').val();
        data.password = $('#password').val();
        data.email = $('#email').val();
        data.person = $('#person').val();
        data.status = $("[name='status']:checked").val();
        data.birth_date = $('#birth_date').val();
        data.auth_key = $('#auth_key').val();
        data.access_token = $('#access_token').val();
        data.id = "<?= $result['id'] ?>";

        var roleIds = new Array();
        $(".role_id:checkbox:checked").each(function(){
            roleIds.push($(this).val())
        })
        roleIds = roleIds.join(',');
        data.roles = roleIds;

        app.post("<?= Url::toRoute('systems/user/save') ?>", data, function(res) {
            if (res !== false) {
                app.showMsg(res, 'success');
                app.parent.layer.close(index);

                callback(true);
            }

            callback(false);
        });
    }
</script>
