<?php
/**
 * 角色管理
 * @author: Gene
 */

use yii\helpers\Url;
use yii\helpers\Html;
$this->title = '角色列表';
?>

<div class="row" style="margin-top:20px;">
    <div class="col-md-12">
        <div>
            <a href="#" class="btn btn-default btn-sm open_save"
               data-title="添加角色"
               data-url="<?= Url::toRoute('systems/role/create') ?>">
                <i class="fa fa-plus"></i> 添加角色
            </a>
        </div>
        <hr>

        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr class="active">
                        <th class="text-center">#ID</th>
                        <th class="text-center">角色名称</th>
                        <th class="text-center">角色描述</th>
                        <th class="text-center">状态</th>
                        <th class="text-center">操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($result)) { ?>
                    <tr>
                        <td class="text-center" colspan="20">暂无数据</td>
                    </tr>
                <?php } else { ?>
                    <?php foreach ($result as $item) { ?>
                        <tr>
                            <td class="text-center"><?= Html::encode($item['id']) ?></td>
                            <td class="text-center"><?= Html::encode($item['name']) ?></td>
                            <td class="text-center"><?= Html::encode($item['remark']) ?></td>
                            <td class="text-center">
                                <form class="layui-form">
                                    <input type="checkbox"
                                           lay-skin="switch"
                                           lay-filter="statusOn"
                                            <?php
                                                if ($item['status'] == 1) {
                                                    echo 'checked';
                                                }
                                            ?>
                                           value="<?= $item['id'] ?>"
                                           lay-filter="switchTest" lay-text="正常|禁用">
                                </form>
                            </td>
                            <td class="text-center">
                                <a href="#"
                                   class="open_save"
                                   data-title="<?= $item['name'] ?> - 编辑角色"
                                   data-url="<?= Url::toRoute([
                                       'systems/role/update',
                                       'id'=>$item['id']
                                   ]) ?>"
                                >[编辑]</a>

                                <a href="#"
                                   class="delete_btn"
                                   data-id="<?= $item['id'] ?>"
                                >[删除]</a>
                            </td>
                        </tr>
                    <?php }} ?>
                </tbody>
            </table>
        </div>

        <div class="item-pagination pull-right">
            <ul class="pagination">
                <li><a>共 <?= $total ?> 条</a></li>
            </ul>
            <?= \yii\widgets\LinkPager::widget([
                'pagination'     => $page,
                'maxButtonCount' => 10,
                'nextPageLabel'  => '下一页',
                'prevPageLabel'  => '上一页',
                'firstPageLabel' => '首页',
                'lastPageLabel'  => '尾页',
            ]); ?>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('.open_save').click(function() {
            var url   = $(this).attr('data-url');
            var title = $(this).attr('data-title');
            app.openParentWin({
                url  : url,
                title: title,
                callback: function(index, dom) {
                    $(dom).find("iframe")[0].contentWindow.submit(index, function(res) {
                        if (res === true) {
                            window.location.reload();
                        }
                    });
                }
            });
        });

        $('.delete_btn').click(function() {
            var id = $(this).attr('data-id');

            app.layer.confirm('您确定要删除吗？', {
                btn: ['确认', '取消']
            }, function(){
                app.post("<?= Url::toRoute('systems/role/del') ?>", {
                    id : id
                }, function(res) {
                    if (res !== false) {
                        app.showMsg(res);
                        window.location.reload();
                    }
                });
            }, function(){});
        });

        setTimeout(function() {
            console.log(app.form)
            app.form.on('switch(statusOn)', function(data){
                app.post("<?= Url::toRoute('systems/role/on-off') ?>", {
                    id : data.value
                }, function(res) {
                    if (res == 1) {
                        app.showMsg('设置成功');
                        window.location.reload();
                    } else {
                        app.showMsg('设置失败', 'error');
                    }
                });
            });
        }, 1000);
    });
</script>