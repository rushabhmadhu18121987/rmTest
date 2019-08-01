<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ContactUs */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contact-us-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'iUserId')->textInput() ?>

    <?= $form->field($model, 'vEmail')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'txMessage')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tiStatus')->textInput() ?>

    <?= $form->field($model, 'iCreatedAt')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('admin', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
