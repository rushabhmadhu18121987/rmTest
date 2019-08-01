<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserMasterSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-master-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'iUserId') ?>

    <?= $form->field($model, 'vFirstName') ?>

    <?= $form->field($model, 'vLastName') ?>

    <?= $form->field($model, 'vEmail') ?>

    <?= $form->field($model, 'vMobileNumber') ?>

    <?php // echo $form->field($model, 'vPassword') ?>

    <?php // echo $form->field($model, 'vProfilePic') ?>

    <?php // echo $form->field($model, 'tiIsSocialLogin') ?>

    <?php // echo $form->field($model, 'dbLatitude') ?>

    <?php // echo $form->field($model, 'dbLogitude') ?>

    <?php // echo $form->field($model, 'vOTP') ?>

    <?php // echo $form->field($model, 'iOTPExpireAt') ?>

    <?php // echo $form->field($model, 'tiIsMobileVerified') ?>

    <?php // echo $form->field($model, 'vEjabberedId') ?>

    <?php // echo $form->field($model, 'vPasswordResetToken') ?>

    <?php // echo $form->field($model, 'iNotiBadgeCount') ?>

    <?php // echo $form->field($model, 'tiAcceptPush') ?>

    <?php // echo $form->field($model, 'tiAcceptEmail') ?>

    <?php // echo $form->field($model, 'tiAcceptSMS') ?>

    <?php // echo $form->field($model, 'tiIsActive') ?>

    <?php // echo $form->field($model, 'tiIsDeleted') ?>

    <?php // echo $form->field($model, 'iCreatedAt') ?>

    <?php // echo $form->field($model, 'iUpdatedAt') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
