<?php
/**
 * 菜单页面
 * @author: Gene
 */

use yii\helpers\Html;
use yii\helpers\Url;
?>
<li class="active">
    <a href="<?= Url::toRoute('site/home') ?>" class="J_menuItem active">
        <i class="fa fa-home"></i>
        <span class="nav-label">首页</span>
    </a>
</li>


<?php foreach ($menu as $row) { ?>
    <li>
        <a href="#">
            <i class="fa fa-<?= $row['font_icon'] ? $row['font_icon'] : 'leaf' ?>"></i>
            <span class="nav-label"><?= Html::encode($row['text']) ?></span>
            <span class="fa arrow"></span>
        </a>

        <ul class="nav nav-second-level">
            <?php  foreach ($row['children'] as $r) {?>

            <?php if ($r['children']) { ?>
                <li>
                    <a href="#">
                        <span class="nav-label"><?= Html::encode($r['text']) ?></span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-third-level">
                        <?php foreach ($r['children'] as $rr) { ?>
                            <li>
                                <a class="J_menuItem" href="<?= Url::toRoute($rr['url_key']) ?>"><?= Html::encode($rr['text']) ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>

            <?php } else { ?>
                <li>
                    <a class="J_menuItem" href="<?= Url::toRoute($r['url_key']) ?>"><?= Html::encode($r['text']) ?></a>
                </li>
            <?php }} ?>
        </ul>
    </li>
<?php } ?>