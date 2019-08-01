<?php

use yii\helpers\Url;
?>
<aside class="main-sidebar" id="myNavbar"> 
    <section class="sidebar"> 
        <ul class="sidebar-menu" data-widget="tree">
            <li class="">
                <a href="<?= Url::to(['/']) ?>"><i class="fa fa-th-large"></i> 
                    <span> <?php echo Yii::t('admin', 'dashboard') ?></span>
                </a>
            </li>
            <li class="<?= Yii::$app->controller->id == 'user-master' ? 'active' : ''; ?>">
                <a href="<?= Url::to(['./user-master']) ?>"><i class="fa fa-users"></i> 
                    <span> <?= Yii::t('admin', 'user-master') ?></span>
                </a>
            </li>
            <li class="<?= Yii::$app->controller->id == 'vendor-master' ? 'active' : ''; ?>">
                <a href="<?= Url::to(['./vendor-master']) ?>"><i class="fa fa-users"></i> 
                    <span> <?= Yii::t('admin', 'vendor') ?></span>
                </a>
            </li>
            <li class="<?= Yii::$app->controller->id == 'category-master' ? 'active' : ''; ?>">
                <a href="<?= Url::to(['./category-master']) ?>"><i class="fa fa-list-alt"></i> 
                    <span> <?= Yii::t('admin', 'category-master') ?></span>
                </a>
            </li>
            <li class="<?= Yii::$app->controller->id == 'banners' ? 'active' : ''; ?>">
                <a href="<?= Url::to(['./banners']) ?>"><i class="fa fa-flag"></i> 
                    <span> <?= Yii::t('admin', 'banners') ?></span>
                </a>
            </li>
            <li class="<?= Yii::$app->controller->id == 'admin-announcements' ? 'active' : ''; ?>">
                <a href="<?= Url::to(['./admin-announcements']) ?>"><i class="fa fa-bullhorn"></i>
                    <span> <?= Yii::t('admin', 'admin-announcements') ?></span>
                </a> 
            </li>
            <li class="<?= Yii::$app->controller->id == 'contact-us' ? 'active' : ''; ?>">
                <a href="<?= Url::to(['./contact-us']) ?>"><i class="fa fa-phone"></i>
                    <span> <?= Yii::t('admin', 'contact-us') ?></span>
                </a> 
            </li>
            <?php $activeSetting = ((Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'change-password') || Yii::$app->controller->id == 'booking-report-reason' || Yii::$app->controller->id == 'app-setting' || Yii::$app->controller->id == 'content-pages') ? ('active') : (''); ?>

            <li class="treeview <?= $activeSetting ?>">
                <a href="#"><i class="fa fa-cog"></i> <span> Settings </span> 
                    <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
                </a>

                <ul class="treeview-menu">
                    <li class="<?= Yii::$app->controller->id == 'app-setting' ? 'active' : ''; ?>" >
                        <a href="<?= Url::to(['./app-setting']) ?>"><i class="fa fa-building"></i> <span>
                                <?= Yii::t('admin', 'app_settings') ?></span>
                        </a>
                    </li>

                    <li class="<?= Yii::$app->controller->id == 'content-pages' ? 'active' : ''; ?>">
                        <a href="<?= Url::to(['./content-pages']) ?>"><i class="fa fa-book"></i> 
                            <span> <?= Yii::t('admin', 'cms') ?></span>
                        </a>
                    </li>

                    <li class="<?= Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'change-password' ? 'active' : ''; ?>">
                        <a href="<?= Url::to(['./site/change-password']) ?>"><i class="fa fa-key"></i>
                            <span><?= Yii::t('admin', 'change_password') ?></span>
                        </a>
                    </li>

                </ul>
            </li>
            <li class="">
                <a href="<?= Url::to(['/logout']) ?>">
                    <i class="fa fa-sign-out"></i> 
                    <span><?= Yii::t('admin', 'logout') ?></span>
                </a>
            </li>
        </ul>
    </section>
</aside> 