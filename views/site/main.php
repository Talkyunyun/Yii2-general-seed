<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = Yii::$app->params['app_name'];
$user = Yii::$app->user->identity;
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>" />
<title><?= Html::encode($this->title) ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link href="https://cdn.bootcss.com/animate.css/3.5.2/animate.min.css" rel="stylesheet">
<link href="/js/plugins/toastr/toastr.min.css?v=1.1" rel="stylesheet">
<link rel="stylesheet" href="/js/plugins/layui/css/layui.css?v=<?= Yii::$app->params['file_version'] ?>" />
<link href="/js/plugins/h+/css/style.min.css?v=<?= Yii::$app->params['file_version'] ?>" rel="stylesheet">
<style>
#toast-container{
    z-index: 999999999999;
}
</style>
</head>
<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
<div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="nav-close"><i class="fa fa-times-circle"></i></div>
        <div class="sidebar-collapse">
            <ul class="nav" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                        <span><img style="width:60px;height:60px;" alt="image" class="img-circle" src="/img/face.jpg" /></span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear">
                               <span class="block m-t-xs">
                                   <strong class="font-bold"><?= Yii::$app->user->identity->person ?></strong>
                               </span>
                                <span class="text-muted text-xs block">
                                    超级管理员<b class="caret"></b>
                                </span>
                            </span>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li>
                                <a class="J_menuItem open_save"
                                   data-url="<?= Url::toRoute('systems/user/password') ?>"
                                   data-title="修改密码" href="#">修改密码</a>
                            </li>
                            <li><a class="J_menuItem open_page"
                                   data-url="<?= Url::toRoute('systems/user/view') ?>"
                                   data-title="个人信息"
                                   href="#">个人信息</a></li>
                            <li class="divider"></li>
                            <li><a href="<?= Url::toRoute('/login/logout') ?>">安全退出</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">AFD</div>
                </li>

                <?= $this->render('menu', ['menu' => $menu]) ?>
            </ul>
        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#">
                        <i class="fa fa-bars"></i>
                    </a>
                    <form role="search" class="navbar-form-custom" method="post" action="">
                        <div class="form-group">
                            <input type="text" placeholder="请输入您需要查找的内容 …" class="form-control" name="top-search" id="top-search">
                        </div>
                    </form>
                </div>
            </nav>
        </div>
        <div class="row content-tabs">
            <button class="roll-nav roll-left J_tabLeft"><i class="fa fa-backward"></i>
            </button>
            <nav class="page-tabs J_menuTabs">
                <div class="page-tabs-content">
                    <a href="javascript:;" class="active J_menuTab" data-id="<?= Url::toRoute('site/home') ?>">首页</a>
                </div>
            </nav>
            <button class="roll-nav roll-right J_tabRight"><i class="fa fa-forward"></i>
            </button>
            <div class="btn-group roll-nav roll-right">
                <button class="dropdown J_tabClose" data-toggle="dropdown">关闭操作<span class="caret"></span>

                </button>
                <ul role="menu" class="dropdown-menu dropdown-menu-right">
                    <li class="J_tabShowActive"><a>定位当前选项卡</a>
                    </li>
                    <li class="divider"></li>
                    <li class="J_tabCloseAll"><a>关闭全部选项卡</a>
                    </li>
                    <li class="J_tabCloseOther"><a>关闭其他选项卡</a>
                    </li>
                </ul>
            </div>
            <a href="<?= Url::toRoute('/login/logout') ?>" class="roll-nav roll-right J_tabExit">
                <i class="fa fa fa-sign-out"></i> 退出
            </a>
        </div>

        <!-- 内容 -->
        <div class="row J_mainContent" id="content-main">
            <iframe class="J_iframe" name="iframe0"
                    width="100%" height="100%"
                    src="<?= Url::toRoute('site/home') ?>"
                    frameborder="0" data-id="<?= Url::toRoute('site/home') ?>" seamless></iframe>
        </div>

        <!-- 尾部 -->
        <div class="footer">
            <div class="pull-right">
                &copy; 2016-<?= date('Y') ?>
                <a href="<?= Yii::$app->params['app_url'] ?>" target="_blank"><?= Yii::$app->params['app_name'] ?></a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.bootcss.com/jquery/2.1.4/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="/js/plugins/layui/layui.js?v=<?= Yii::$app->params['file_version'] ?>"></script>
<script src="/js/plugins/toastr/toastr.min.js"></script>
<script src="/js/parent/contabs.min.js"></script>
<script src="/js/parent/main.min.js?v=<?= Yii::$app->params['file_version'] ?>"></script>
<script src="/js/parent/app.js?v=<?= Yii::$app->params['file_version'] ?>"></script>
<script>
    $(function() {
        $('.open_save').click(function() {
            var url = $(this).attr('data-url');
            var title = $(this).attr('data-title');

            app.openWin({
                url  : url,
                title: title,
                callback: function(index, dom) {
                    $(dom).find('iframe')[0].contentWindow.submit(index, function(res) {
                        if (res === true) {
                            window.location.reload();
                        }
                    });
                }
            });
        });

        $('.open_page').click(function() {
            var url = $(this).attr('data-url');
            var title = $(this).attr('data-title');

            app.openWin({
                url  : url,
                title: title
            });
        });
    });
</script>
</body>
</html>