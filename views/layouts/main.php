<?php
/**
 * 基本模板框架
 * @author: Gene
 */

use yii\helpers\Html;

$this->beginPage();
?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>" />
        <title><?= Html::encode($this->title) ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="//at.alicdn.com/t/font_4jfvk335cvaq0k9.css">
        <link href="https://cdn.bootcss.com/animate.css/3.5.2/animate.min.css" rel="stylesheet">
        <link rel="stylesheet" href="/js/plugins/layui/css/layui.css?v=1.0" />
        <link href="/css/style.min.css?v=1.7" rel="stylesheet">
        <?php $this->head() ?>
        <script type="text/javascript">
            window._csrf = "<?= Yii::$app->request->csrfToken ?>";
        </script>
        <style>
            .action{
                margin-right:10px;
            }
            .all_del{
                color:red;
            }
            .all_access{
                color:green;
            }
            .download{
                color:blue;
            }
            .table td, .table th{
                white-space: nowrap!important;
            }
            .box_center{
                display: -webkit-box;
                -webkit-box-pack: center;
                -webkit-box-align: center;
                display:-moz-box;
                -moz-box-pack:center;
                -moz-box-align: center;
                display:box;
                box-pack:center;
                box-align:center;
            }







            /*加载动画*/
            #page_loading {
                width: 60px;
                height: 60px;

                position: relative;
                margin: 100px auto;
            }

            .double-bounce1, .double-bounce2 {
                width: 100%;
                height: 100%;
                border-radius: 50%;
                background-color: #67CF22;
                opacity: 0.6;
                position: absolute;
                top: 0;
                left: 0;

                -webkit-animation: bounce 2.0s infinite ease-in-out;
                animation: bounce 2.0s infinite ease-in-out;
            }

            .double-bounce2 {
                -webkit-animation-delay: -1.0s;
                animation-delay: -1.0s;
            }

            @-webkit-keyframes bounce {
                0%, 100% { -webkit-transform: scale(0.0) }
                50% { -webkit-transform: scale(1.0) }
            }

            @keyframes bounce {
                0%, 100% {
                    transform: scale(0.0);
                    -webkit-transform: scale(0.0);
                } 50% {
                      transform: scale(1.0);
                      -webkit-transform: scale(1.0);
                  }
            }
            #page_loading{display:block;}
            #page_content{display:none;}
        </style>
    </head>

    <body style="background:#FDFFFF" id="body">
    <!-- 加载动画 -->
    <div id="page_loading">
        <div class="double-bounce1"></div>
        <div class="double-bounce2"></div>
    </div>

    <?php $this->beginBody() ?>
    <script src="https://cdn.bootcss.com/jquery/2.1.4/jquery.min.js"></script>
    <script src="/js/plugins/layui/layui.js"></script>
    <script src="/js/core.js?v=1.2"></script>
    <script src="/js/app.js?v=1.43"></script>

    <div id="page_content">
        <div class="container-fluid" style="padding-top:20px;">
            <?= $content ?>
        </div>
    </div>

    <?php $this->endBody(); ?>
    </body>
    </html>
<?php $this->endPage() ?>
<script>
    $(function() {
        $('#page_loading').hide();
        $('#page_content').show();

        if (navigator.userAgent.match(/iPad|iPhone/i)) {
            var winWidth = window.top.getWinWidth();
            $('body').css('width', winWidth + 'px');
        }
    });
</script>
