<?php

use yii\helpers\Url;

$this->title = '菜单管理';
?>

<link href="/js/plugins/jsTree/themes/default/style.min.css" rel="stylesheet">
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-3">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="btn-group" role="group">
                        <button id="add" type="button" class="btn btn-info btn-xs">创建</button>
                        <button id="del" type="button" class="btn btn-danger btn-xs">删除</button>
                    </div>

                    <div class="hr-line-dashed"></div>

                    <div id="menuBox"></div>
                </div>
            </div>
        </div>


        <div class="col-sm-9 animated fadeInRight">
            <div class="ibox-content">
                <h3>编辑信息</h3>
                <div class="hr-line-dashed"></div>

                <form class="form-horizontal" method="post" action="">
                    <div class="row">
                        <div class="col-md-12">
                            <p style="padding:10px;margin-bottom:20px;" class="bg-info">说明:<br>1、url为域名后面访问的路径地址,如:http://www.afd56.com/role/add,则url地址为:/role/add;<br>2、是否菜单说明:选择是,则将会作为菜单来显示<br>3、字体图标,请输入Font Awesome官方提供的图标库,如:eye</p>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="name" class="col-md-3 control-label">名称</label>
                                <div class="col-md-9">
                                    <input type="text" name="name" class="form-control" id="name" placeholder="名称">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="url" class="col-md-3 control-label">url地址</label>
                                <div class="col-md-9">
                                    <input type="text" name="url" class="form-control" id="url" placeholder="url地址,如:/role/index">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="sort" class="col-md-3 control-label">排序</label>
                                <div class="col-md-9">
                                    <input type="text" value="0" name="sort" class="form-control" id="sort" placeholder="排序">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="sort" class="col-md-3 control-label">字体图标:</label>
                                <div class="col-md-9">
                                    <input type="text" name="font_icon" class="form-control" id="font_icon" placeholder="字体图标">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="role_key" class="col-md-3 control-label">是否菜单</label>
                                <div class="col-md-9">
                                    <label class="radio-inline">
                                        <input type="radio" name="is_menu" id="is_menu1" value="1"> 是
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="is_menu" id="is_menu0" value="0"> 否
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="role_key" class="col-md-3 control-label">状态</label>
                                <div class="col-md-9">
                                    <label class="radio-inline">
                                        <input type="radio" name="status" id="status1" value="1"> 开启
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="status" id="status0" value="0"> 关闭
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <button type="button" id="edit_btn" class="btn btn-info">保存</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="/js/plugins/jsTree/jstree.min.js"></script>
<script>
    var id = 0;
    $('#del').click(function() {
        layer.confirm('你确认要删除该节点或菜单吗？删除不可恢复', {
            btn: ['确认', '取消']
        }, function(i) {
            layer.close(i);
            APP.post("<?= Url::toRoute('systems/node/del') ?>", {
                id : id
            }, function(res) {
                console.log(res)
                if (res !== false) {
                    APP.parent.APP.showMsg(res, 'success');

                    initData();
                }
            });
        });
    });

    $('#edit_btn').click(function() {
        var data = new Object();
        data.name = $('#name').val();
        data.url = $('#url').val();
        data.sort = $('#sort').val();
        data.is_menu = $("[name='is_menu']:checked").val();
        data.status = $("[name='status']:checked").val();
        data.font_icon = $('#font_icon').val();
        data.id = id;

        if (id == 0) {
            APP.parent.APP.showMsg('请选择需要修改的节点', 'error');
            return false;
        }

        APP.post("<?= Url::toRoute('systems/node/save') ?>", data, function(res) {
            if (res !== false) {
                APP.parent.APP.showMsg(res, 'success');

                initData();
            }
        });
    });

    $('#add').click(function() {
        layer.open({
            type: 2,
            title: '添加节点',
            shadeClose: true,
            shade: 0.8,
            area: ['400px', '90%'],
            content: "<?= Url::toRoute('systems/node/create') ?>?pid=" + id
        });
    });

    initData();
    function initData() {
        APP.post("<?= Url::toRoute('systems/node/get-data') ?>", {}, function(res) {
            if (res !== false) {
                // 清空数据
                id = 0;
                $('#name').val('');
                $('#url').val('');
                $('#sort').val(0);
                $('#font_icon').val('');

                $('#menuBox').data('jstree', false).empty();
                $("#menuBox").jstree({
                    'core' : {
                        'multiple' : false,
                        'data' : res,
                        'dblclick_toggle' : false, // 禁用双击展开
                    }
                }).bind('click.jstree', function(e) {
                    id = $(e.toElement).parent('li').attr('id');
                    APP.post("<?= Url::toRoute('systems/node/get-info') ?>", {
                        id : id
                    }, function(res) {
                        if (res !== false || res !== null) {
                            $('#name').val(res.name);
                            $('#url').val(res.url);
                            $('#sort').val(res.sort);
                            $('#font_icon').val(res.font_icon);

                            $("[name='is_menu']").removeAttr('checked');
                            $("[name='status']").removeAttr('checked');

                            $("#is_menu" + res.is_menu).prop("checked", 'checked');
                            $("#status" + res.status).prop("checked", 'checked');
                        }
                    });
                });
            }
        });
    }
</script>
