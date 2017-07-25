<?php

use yii\helpers\Url;
$this->title = '编辑角色';
?>
<style>
    body{background: #fff !important;}
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
</style>
<link href="/js/plugins/jsTree/themes/default/style.min.css" rel="stylesheet">
<div class="row">
    <form class="form-horizontal">
        <div class="col-sm-12">
            <div class="layui-tab">
                <ul class="layui-tab-title">
                    <li class="layui-this">基本信息</li>
                    <li>权限分配</li>
                </ul>
                <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>角色名称</label>
                                <input type="text" id="name"
                                       value="<?= $result['name'] ?>"
                                       class="form-control"
                                       placeholder="角色名称">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>描述</label>
                                <textarea class="form-control"
                                          id="remark"
                                          placeholder="备注或者描述"><?= $result['remark'] ?></textarea>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>状态</label>
                                <label class="radio-inline">
                                    <input type="radio" name="status" value="1"
                                        <?php if ($result['status'] == 1) {
                                            echo 'checked';
                                        } ?>
                                    > 开启
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="status" value="0"
                                        <?php if ($result['status'] == 0) {
                                            echo 'checked';
                                        } ?>
                                    > 关闭
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="layui-tab-item" id="menuBox"></div>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="/js/plugins/jsTree/jstree.min.js"></script>
<script>
    var nodes = '';
    layui.use('element', function() { });

    function submit(index, callback) {
        var data = new Object();
        data.name = $('#name').val();
        data.remark = $('#remark').val();
        data.status = $("[name='status']:checked").val();
        data.nodes = nodes;
        data.id = "<?= $result['id'] ?>";

        post("<?= Url::toRoute('systems/role/save') ?>", data, function(res) {
            if (res !== false) {
                APP.parent.APP.showMsg(res, 'success');
                APP.parent.layer.close(index);

                callback(true);
            }

            callback(false);
        });
    }

    $(function() {
        APP.post("<?= Url::toRoute('systems/node/get-data') ?>", {
            role_id : "<?= $result['id'] ?>"
        }, function(res) {
            if (res !== false) {
                $("#menuBox").jstree({
                    plugins : ['checkbox'],
                    core : {
                        'multiple' : true,
                        'data' : res,
                        'dblclick_toggle' : false, // 禁用双击展开
                    }
                }).bind('changed.jstree', function(e, data) {
                    var i, j, r = [];
                    for(i = 0, j = data.selected.length; i < j; i++) {
                        r.push(data.instance.get_node(data.selected[i]).id);
                    }

                    nodes = r.join(',');
                });
            }
        });
    });
</script>