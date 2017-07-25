<?php

use yii\helpers\Url;
use yii\helpers\Html;
$this->title = '角色列表';
?>
<style>
    body{
        background: #ffffff !important;
    }
</style>
<div class="row animated fadeIn">
    <div class="col-md-12">
        <div class="page-header">
            <form class="form-inline">
                <div class="form-group">
                    <input type="text" name="name" value="<?= $name ?>" class="form-control"  placeholder="角色名称">
                </div>

                <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> 搜索</button>
            </form>
        </div>
    </div>

    <!-- 操作类别 -->
    <div class="col-md-12" style="margin-bottom:20px;">
        <a href="#" class="btn btn-white btn-sm btn-bitbucket open_save"
           data-url="<?= Url::toRoute('systems/role/create') ?>"
           data-title="添加角色"
        >
            <i class="fa fa-plus-circle"> 添加</i>
        </a>
    </div>

    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr class="active">
                        <th class="text-center">ID</th>
                        <th class="text-center">角色名称</th>
                        <th class="text-center">角色描述</th>
                        <th class="text-center">状态</th>
                        <th class="text-center">操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($result)) { ?>
                    <tr>
                        <td class="text-center" colspan="6">暂无数据</td>
                    </tr>
                    <?php
                } else {
                    foreach ($result as $row) {
                        ?>
                        <tr>
                            <td class="text-center"><?= Html::encode($row['id']) ?></td>
                            <td class="text-center"><?= Html::encode($row['name']) ?></td>
                            <td class="text-center"><?= Html::encode($row['remark']) ?></td>
                            <td class="text-center">
                                <?php if ($row['status'] == 1) { ?>
                                    <span>正常</span>
                                <?php } else { ?>
                                    <span style="color:red">关闭</span>
                                <?php } ?>
                            </td>

                            <td class="text-center">
                                <a href="#"
                                   class="open_save"
                                   data-url="<?= Url::toRoute(['systems/role/update', 'id'=>$row['id']]) ?>"
                                   data-title="编辑角色">
                                    编辑
                                </a>
                                <a href="#"
                                   class="del_btn color_del"
                                   data-id="<?= $row['id'] ?>"
                                >删除</a>
                            </td>
                        </tr>
                    <?php }} ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-md-12">
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
            ]);
            ?>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('.open_save').click(function() {
            var url = $(this).attr('data-url');
            var title = $(this).attr('data-title');
            APP.openParentWin({
                url: url,
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

        $('.del_btn').click(function() {
            var id = $(this).attr('data-id');

            APP.post("<?= Url::toRoute('systems/role/del') ?>", {
                id : id
            }, function(res) {
                if (res !== false) {
                    APP.parent.APP.showMsg(res, 'success');
                    window.location.reload();
                }
            });
        });
    });
</script>