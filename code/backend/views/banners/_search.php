<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\BannerMasterSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banners-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'iBannerId') ?>

    <?= $form->field($model, 'vTitle') ?>

    <?= $form->field($model, 'vBannerPic') ?>

    <?= $form->field($model, 'tiBannerType') ?>

    <?= $form->field($model, 'iEntryId') ?>

    <?php // echo $form->field($model, 'tiOrderNo') ?>

    <?php // echo $form->field($model, 'tiIsActive') ?>

    <?php // echo $form->field($model, 'tiIsDeleted') ?>

    <?php // echo $form->field($model, 'iCreatedAt') ?>

    <?php // echo $form->field($model, 'iUpdatedAt') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('admin', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('admin', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
