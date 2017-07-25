<?php

use yii\helpers\Url;

$this->title = '添加菜单';
?>
<style>
    body{background: #fff !important;}
</style>
<div class="row">
    <form class="form-horizontal" method="post" action="">
        <p style="padding:10px; 0" class="bg-info">说明:<br>1、url为域名后面访问的路径地址,如:http://www.afd56.com/role/add,则url地址为:/role/add;<br>2、是否菜单说明:选择是,则将会作为菜单来显示<br>3、字体图标,请输入Font Awesome官方提供的图标库,如:eye</p>

        <div class="col-md-5">
            <div class="form-group">
                <label for="name" class="col-md-3 control-label">名称</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="name" placeholder="名称">
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label for="url" class="col-md-3 control-label">url地址</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="url" placeholder="url地址">
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label for="sort" class="col-md-3 control-label">排序</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="sort" value="0" placeholder="排序">
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label for="sort" class="col-md-3 control-label">字体图标</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="font_icon" placeholder="字体图标">
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label for="sort_order" class="col-md-3 control-label">是否菜单</label>
                <div class="col-md-9">
                    <label class="radio-inline">
                        <input type="radio" name="is_menu" checked value="1"> 是
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="is_menu" value="0"> 否
                    </label>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label for="sort_order" class="col-md-3 control-label">状态</label>
                <div class="col-md-9">
                    <label class="radio-inline">
                        <input type="radio" name="status" checked value="1"> 开启
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="status" value="0"> 关闭
                    </label>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <button type="button" id="btn" class="btn btn-info">保存</button>
        </div>
    </form>
</div>

<script>
    $(function() {
        $('#btn').click(function() {
            var data = new Object();
            data.name = $('#name').val();
            data.url = $('#url').val();
            data.sort = $('#sort').val();
            data.is_menu = $("[name='is_menu']:checked").val();
            data.status = $("[name='status']:checked").val();
            data.font_icon = $('#font_icon').val();
            data.pid = "<?= $pid ?>";

            APP.post("<?= Url::toRoute('systems/node/save') ?>", data, function(res) {
                if (res !== false) {
                    APP.parent.APP.showMsg(res, 'success');

                    reloadParent();
                }
            });
        });
    });
</script>
