<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BannerMaster */

$this->title = Yii::t('admin', 'create-banner');
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'banners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banners-create">
    <?= $this->render('_form', $this->context->data) ?>
</div>
