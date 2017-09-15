<?php
/**
 * 用户列表
 * @author: Gene
 */

use yii\helpers\Url;
use yii\helpers\Html;
use app\utils\DateUtil;
$this->title = '管理员列表';
?>

<div class="row" style="margin-top:20px;">
    <div class="col-md-12">
        <div>
            <a href="#" class="btn btn-default btn-sm open_save"
               data-title="添加系统用户"
               data-url="<?= Url::toRoute('systems/user/create') ?>">
                <i class="fa fa-plus"></i> 添加
            </a>
        </div>
        <hr>

        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                <tr class="active">
                    <th class="text-center">#UID</th>
                    <th class="text-center">登录名</th>
                    <th class="text-center">姓名</th>
                    <th class="text-center">联系号码</th>
                    <th class="text-center">联系邮箱</th>
                    <th class="text-center">生日</th>
                    <th class="text-center">角色</th>
                    <th class="text-center">状态</th>
                    <th class="text-center">添加时间</th>
                    <th class="text-center">更新时间</th>
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
                            <td class="text-center"><?= Html::encode($item['username']) ?></td>
                            <td class="text-center"><?= Html::encode($item['real_name']) ?></td>
                            <td class="text-center"><?= Html::encode($item['phone']) ?></td>
                            <td class="text-center"><?= Html::encode($item['email']) ?></td>
                            <td class="text-center"><?= Html::encode($item['birth_date']) ?></td>
                            <td class="text-center">
                                <?php if ($item['username'] == 'admin') { ?>
                                    <span>超级管理员</span>
                                <?php } else { ?>
                                    <?php foreach ($item['roles'] as $r) { ?>
                                        <p><?= $r['name'] ?></p>
                                    <?php } ?>
                                <?php } ?>
                            </td>
                            <td class="text-center"><?= $statusList[$item['status']] ?></td>
                            <td class="text-center"><?= $item['created'] ?></td>
                            <td class="text-center"><?= $item['updated'] ?></td>
                            <td class="text-center">
                                <a href="#"
                                   class="open_save"
                                   data-url="<?= Url::toRoute([
                                       'systems/user/update',
                                       'id'=>$item['id']
                                   ]) ?>"
                                   data-title="编辑管理员"
                                >修改</a>
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
            var url = $(this).attr('data-url');
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
    });
</script>