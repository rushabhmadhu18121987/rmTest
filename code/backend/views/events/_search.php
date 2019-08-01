<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\EventMasterSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="event-master-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'iEventId') ?>

    <?= $form->field($model, 'iBusinessId') ?>

    <?= $form->field($model, 'iUserId') ?>

    <?= $form->field($model, 'iCategoryId') ?>

    <?= $form->field($model, 'vTitle') ?>

    <?php // echo $form->field($model, 'vSlug') ?>

    <?php // echo $form->field($model, 'dStartDt') ?>

    <?php // echo $form->field($model, 'dExpireDt') ?>

    <?php // echo $form->field($model, 'txDescription') ?>

    <?php // echo $form->field($model, 'vAddress1') ?>

    <?php // echo $form->field($model, 'vAddress2') ?>

    <?php // echo $form->field($model, 'vCity') ?>

    <?php // echo $form->field($model, 'vZipcode') ?>

    <?php // echo $form->field($model, 'dbLatitude') ?>

    <?php // echo $form->field($model, 'dbLongitude') ?>

    <?php // echo $form->field($model, 'vBannerPic') ?>

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
