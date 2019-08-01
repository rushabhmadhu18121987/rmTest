<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ContactUsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contact-us-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'iContactId') ?>

    <?= $form->field($model, 'iUserId') ?>

    <?= $form->field($model, 'vEmail') ?>

    <?= $form->field($model, 'txMessage') ?>

    <?= $form->field($model, 'tiStatus') ?>

    <?php // echo $form->field($model, 'iCreatedAt') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('admin', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('admin', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
