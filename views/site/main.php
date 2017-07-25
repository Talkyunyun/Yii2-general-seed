<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\models\AdminUser\AdminUserLoginLog;
use app\utils\DateUtil;

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
<link rel="stylesheet" href="//at.alicdn.com/t/font_4jfvk335cvaq0k9.css">
<link href="/js/plugins/toastr/toastr.min.css?v=1.1" rel="stylesheet">
<link href="/css/site.css?v=<?= Yii::$app->params['file_version'] ?>" rel="stylesheet">
</head>
<body class="full_screen">
    <div class="site_top">
        <div class="site_logo">
            <img src="/img/logo.png" alt="logo">
            <span><?= Yii::$app->params['app_name'] ?></span>
        </div>

        <div class="site_logout">
            <a href="<?= Url::toRoute('/login/logout') ?>"><i class="iconfont icon-tuichu"></i></a>
        </div>

        <div class="navbar-header hide_btn">
            <a class="navbar-minimalize" href="#">
                <i class="fa fa-arrows-h"></i>
            </a>
        </div>
    </div>

    <div id="site_container">
        <!--左侧导航开始-->
        <nav class="site_nav_container" role="navigation">
            <div class="sidebar-collapse">
                <div class="week_info">
                    <h4><?= DateUtil::getWeekByTime(time()) ?></h4>
                    <p><?= DateUtil::showFormatDate(time(), 'Y年m月d日') ?></p>
                </div>
                <ul class="nav_container" id="side-menu" style="height:calc(100% - 154px);overflow-y:auto;">
                    <?= $this->render('menu', ['menu' => $menu]) ?>
                </ul>
            </div>
        </nav>
        <!--左侧导航结束-->

        <!--右侧部分开始-->
        <div class="page_container">
            <div class="page_header">
                <button class="roll-nav roll-left J_tabLeft">
                    <i class="fa fa-backward"></i>
                </button>
                <nav class="page-tabs J_menuTabs">
                    <div class="page-tabs-content">
                        <a href="javascript:;" class="active J_menuTab" data-id="<?= Url::toRoute('site/home') ?>">首页</a>
                    </div>
                </nav>
                <button class="roll-nav roll-right J_tabRight">
                    <i class="fa fa-forward"></i>
                </button>
                <div class="btn-group roll-nav roll-right nav-dropdown">
                    <button class="dropdown J_tabClose" data-toggle="dropdown">
                        关闭操作<span class="caret"></span>
                    </button>
                    <ul role="menu" class="dropdown-menu dropdown-menu-right">
                        <li class="J_tabCloseAll"><a>关闭全部选项卡</a></li>
                        <li class="J_tabCloseOther"><a>关闭其他选项卡</a></li>
                    </ul>
                </div>
            </div>

            <div class="J_mainContent" id="content-main">
                <iframe
                    class="J_iframe"
                    name="iframe0"
                    width="100%"
                    height="100%"
                    src="<?= Url::toRoute('site/home') ?>"
                    frameborder="0"
                    data-id="<?= Url::toRoute('site/home') ?>">
                </iframe>
            </div>

            <div class="footer">
                <div class="pull-right">
                    &copy; 2016-<?= date('Y') ?>
                    <a href="<?= Yii::$app->params['app_url'] ?>" target="_blank">
                        <?= Yii::$app->params['app_name'] ?>
                    </a>
                </div>
            </div>
        </div>
        <!--右侧部分结束-->

        
        <a href="#" id="open_tab" class="J_menuItem" style="display:none;"></a>
    </div>

    <script src="https://cdn.bootcss.com/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="/js/plugins/layer/layer.min.js"></script>
    <script src="/js/contabs.min.js"></script>
    <script src="/js/plugins/toastr/toastr.min.js"></script>
    <script src="/js/main.min.js?v=1.1"></script>
    <script src="/js/parent.js?v=1111"></script>
<script>
    function reloadIframe() {
        var current_iframe = $("iframe:visible");
        current_iframe[0].contentWindow.location.reload();
        return false;
    }
    $('.J_menuItem').click(function() {
        reloadIframe()
    });

    function getWinWidth() {
        return window.innerWidth;
    }

    // 菜单选中控制
    $('ul li.nav_active a').click(function() {
        $('ul li.nav_active a').removeClass('active');
        $(this).addClass('active');
    });
</script>
</body>
</html>