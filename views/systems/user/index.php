<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\utils\DateUtil;
$this->title = '管理员列表';
?>
<style>
    body{
        background: #fff !important;
    }
</style>

<div class="row animated fadeIn">
    <div class="col-md-12">
        <div class="page-header">
            <form class="form-inline">
                <div class="form-group">
                    <input type="text" value="<?= $username ?>" name="username" class="form-control"  placeholder="用户名">
                </div>
                <div class="form-group">
                    <input type="text" name="mobile" value="<?= $mobile ?>" class="form-control" placeholder="手机号码">
                </div>

                <div class="form-group">
                    <select class="form-control" name="status">
                        <option value="all">状态</option>
                        <?php foreach ($statusList as $key=>$row) { ?>
                            <option value="<?= $key ?>"
                                <?php
                                if ($status == $key && is_numeric($status)) {
                                    echo 'selected';
                                }
                                ?>
                            ><?= $row ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control custom_date" data-node="#custom_box" name="dateType" >
                        <option value="0" <?php if ($dateType == 0) {echo 'selected';} ?> >注册日期</option>
                        <option value="1" <?php if ($dateType == 1) {echo 'selected';} ?> >今日</option>
                        <option value="7" <?php if ($dateType == 7) {echo 'selected';} ?> >一周</option>
                        <option value="30" <?php if ($dateType == 30) {echo 'selected';} ?> >一个月</option>
                        <option value="90" <?php if ($dateType == 90) {echo 'selected';} ?> >三个月</option>
                        <option value="-1" <?php if ($dateType == -1) {echo 'selected';} ?> >自定义</option>
                    </select>
                </div>
                <div class="form-group" id="custom_box" <?php if ($dateType != -1) {
                    echo 'style="display:none"';
                } ?> >
                    <input type="text"
                           name="start_date"
                           value="<?= $startDate ?>"
                           onclick="laydate({elem: this});"
                           class="form-control"  placeholder="开始时间"> -
                    <input type="text"
                           name="end_date"
                           value="<?= $endDate ?>"
                           onclick="laydate({elem: this});"
                           class="form-control"  placeholder="结束时间">
                </div>

                <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> 搜索</button>
            </form>
        </div>
    </div>

    <!-- 操作类别 -->
    <div class="col-md-12" style="margin-bottom:20px;">
        <a href="#" class="btn btn-white btn-sm btn-bitbucket open_page"
           data-url="<?= Url::toRoute('systems/user/create') ?>"
           data-title="添加管理员"
        >
            <i class="fa fa-plus-circle"> 添加</i>
        </a>
    </div>

    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr class="active">
                        <th class="text-center">UID</th>
                        <th class="text-center">用户名称</th>
                        <th class="text-center">姓名</th>
                        <th class="text-center">手机号码</th>
                        <th class="text-center">邮箱地址</th>
                        <th class="text-center">角色</th>
                        <th class="text-center">状态</th>
                        <th class="text-center">创建时间</th>
                        <th class="text-center">更新时间</th>
                        <th class="text-center">操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($data)) { ?>
                    <tr>
                        <td class="text-center" colspan="20">暂无数据</td>
                    </tr>
                    <?php
                } else {
                    foreach ($data as $row) {
                        ?>
                        <tr>
                            <td class="text-center"><?= Html::encode($row['id']) ?></td>
                            <td class="text-center"><?= Html::encode($row['username']) ?></td>
                            <td class="text-center"><?= Html::encode($row['person']) ?></td>
                            <td class="text-center"><?= Html::encode($row['mobile']) ?></td>
                            <td class="text-center"><?= Html::encode($row['email']) ?></td>
                            <td class="text-center">
                                <?php foreach ($row['roles'] as $r) { ?>
                                    <p><?= $r['name'] ?></p>
                                <?php } ?>
                            </td>
                            <td class="text-center"><?= $statusList[$row['status']] ?></td>
                            <td class="text-center">
                                <?= DateUtil::showFormatDate($row['create_time']) ?>
                            </td>
                            <td class="text-center">
                                <?= DateUtil::showFormatDate($row['update_time']) ?>
                            </td>
                            <td class="text-center">
                                <a href="#"
                                   class="open_page"
                                   data-url="<?= Url::toRoute([
                                       'systems/user/update', 'id'=>$row['id']
                                   ]) ?>"
                                   data-title="编辑管理员"
                                >修改</a>

                                <?php if ($row['status'] == 1 && $row['username'] != 'admin') { ?>
                                    <a href="#"
                                       data-id="<?= $row['id'] ?>"
                                       data-type="0"
                                       class="btn btn-xs btn-danger action_btn">失效</a>
                                <?php } else if ($row['status'] == 0 && $row['username'] != 'admin') { ?>
                                    <a href="#"
                                       data-id="<?= $row['id'] ?>"
                                       data-type="1"
                                       class="btn btn-xs btn-info action_btn">生效</a>
                                <?php } ?>
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
        $('.open_page').click(function() {
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




        $('.action_btn').click(function() {
            var id = $(this).attr('data-id');
            var type = $(this).attr('data-type');

            APP.post("<?= Url::toRoute('systems/user/state') ?>", {
                id : id,
                type : type
            }, function(res) {
                if (res !== false) {
                    APP.parent.APP.showMsg(res, 'success');
                    window.location.reload();
                }
            });
        });
    });
</script>