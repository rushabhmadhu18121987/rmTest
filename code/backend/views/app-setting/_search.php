<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AppSettingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="app-setting-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'iAppSettingId') ?>

    <?= $form->field($model, 'vSettingLabel') ?>

    <?= $form->field($model, 'vAppSettingKey') ?>

    <?= $form->field($model, 'eAppSettingDatatype') ?>

    <?= $form->field($model, 'vAppSettingValue') ?>

    <?php // echo $form->field($model, 'vAppSettingDesc') ?>

    <?php // echo $form->field($model, 'iCreatedAt') ?>

    <?php // echo $form->field($model, 'iUpdatedAt') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
