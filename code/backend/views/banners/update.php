<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BannerMaster */

$this->title = Yii::t('admin', 'update-banner');
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'banners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->iBannerId, 'url' => ['view', 'id' => $model->iBannerId]];
$this->params['breadcrumbs'][] = Yii::t('admin', 'Update');
?>
<div class="banners-update">
    <?= $this->render('_form', $this->context->data) ?>
</div>
