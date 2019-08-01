<?php
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
Yii::$app->language = Yii::$app->params['default_language']??'en';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="author" content="<?= Yii::$app->name ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
        <meta http-equiv="cache-control" content="no-cache" />
        <meta itemprop="title" content="<?= Yii::$app->params['meta_title'] ?? Html::encode($this->title) ?>">
        <meta itemprop="name" content="<?= Yii::$app->params['meta_name'] ?? NULL ?>">
        <meta name="description" content="<?= Yii::$app->params['meta_description'] ?? NULL ?>"/>
        <link rel="apple-touch-icon" sizes="57x57" href="<?= Yii::$app->params['FAVICON_BACKEND_URL'] ?? '/' ?>apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?= Yii::$app->params['FAVICON_BACKEND_URL'] ?? '/' ?>apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?= Yii::$app->params['FAVICON_BACKEND_URL'] ?? '/' ?>apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?= Yii::$app->params['FAVICON_BACKEND_URL'] ?? '/' ?>apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?= Yii::$app->params['FAVICON_BACKEND_URL'] ?? '/' ?>apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?= Yii::$app->params['FAVICON_BACKEND_URL'] ?? '/' ?>apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?= Yii::$app->params['FAVICON_BACKEND_URL'] ?? '/' ?>apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?= Yii::$app->params['FAVICON_BACKEND_URL'] ?? '/' ?>apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?= Yii::$app->params['FAVICON_BACKEND_URL'] ?? '/' ?>apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?= Yii::$app->params['FAVICON_BACKEND_URL'] ?? '/' ?>android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?= Yii::$app->params['FAVICON_BACKEND_URL'] ?? '/' ?>favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?= Yii::$app->params['FAVICON_BACKEND_URL'] ?? '/' ?>favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?= Yii::$app->params['FAVICON_BACKEND_URL'] ?? '/' ?>favicon-16x16.png">
        <link rel="manifest" href="<?= Yii::$app->params['FAVICON_BACKEND_URL'] ?? '/' ?>manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="<?= Yii::$app->params['FAVICON_BACKEND_URL'] ?? '/' ?>ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <title><?= Html::encode($this->title); ?> | <?= Yii::$app->name ?></title>
        <?= Html::csrfMetaTags(); ?>
        <?php $this->head(); ?>
    </head>
    <body class="hold-transition skin-black-light sidebar-mini">
        <?php $this->beginBody() ?>

        <div class="wrapper">
            <!-- Main Header -->
            <?= $this->render('//layouts/top-menu.php') ?>
            <!-- Left side column. contains the logo and sidebar -->
            <?= $this->render('//layouts/sidebar-menu.php') ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper"> 
                <?=
                Breadcrumbs::widget(
                        [
                            'homeLink' => [
                                'label' => '<i class="fa fa-dashboard"></i> ' . Yii::t('app', 'Dashboard'),
                                'url' => ['/']
                            ],
                            'encodeLabels' => false,
                            'tag' => 'ol',
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []
                        ]
                )
                ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
            <!-- Main Footer -->
            <?= $this->render('//layouts/footer.php') ?>
            <!-- Add the sidebar's background. This div must be placed
             immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>
        </div>
        <!-- ./wrapper --> 
        <?= $this->blocks['modalContainer'] ?? NULL ?>

        <?php $this->endBody() ?>
        <script type="text/javascript">
            $(function () {
                var url = window.location.href;
                $("#myNavbar a").each(function () {
                    if (url == (this.href)) {
                        $(this).closest("li").addClass("active");
                    }
                });
            });
        </script>
    </body>
</html>
<?php $this->endPage() ?>
