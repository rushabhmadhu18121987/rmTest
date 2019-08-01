<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\UserMasterSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-master-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'iUserId') ?>

    <?= $form->field($model, 'vUserName') ?>

    <?= $form->field($model, 'vFirstName') ?>

    <?= $form->field($model, 'vLastName') ?>

    <?= $form->field($model, 'vEmail') ?>

    <?php // echo $form->field($model, 'vMobileNumber') ?>

    <?php // echo $form->field($model, 'vPassword') ?>

    <?php // echo $form->field($model, 'bSocialType') ?>

    <?php // echo $form->field($model, 'vPasswordResetToken') ?>

    <?php // echo $form->field($model, 'tiIsActive') ?>

    <?php // echo $form->field($model, 'iCreatedAt') ?>

    <?php // echo $form->field($model, 'iUpdatedAt') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
