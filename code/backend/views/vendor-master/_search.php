<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\VendorMasterSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vendor-master-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'iVendorId') ?>

    <?= $form->field($model, 'vEmail') ?>

    <?= $form->field($model, 'vMobileNumber') ?>

    <?= $form->field($model, 'vPassword') ?>

    <?= $form->field($model, 'vProfilePic') ?>

    <?php // echo $form->field($model, 'vBusinessName') ?>

    <?php // echo $form->field($model, 'vWebsite') ?>

    <?php // echo $form->field($model, 'vCountry') ?>

    <?php // echo $form->field($model, 'vState') ?>

    <?php // echo $form->field($model, 'vCity') ?>

    <?php // echo $form->field($model, 'dbLatitude') ?>

    <?php // echo $form->field($model, 'dbLogitude') ?>

    <?php // echo $form->field($model, 'vEjabberedId') ?>

    <?php // echo $form->field($model, 'vStripeCustomerId') ?>

    <?php // echo $form->field($model, 'vStripeCardId') ?>

    <?php // echo $form->field($model, 'vSubscriptionId') ?>

    <?php // echo $form->field($model, 'vPasswordResetToken') ?>

    <?php // echo $form->field($model, 'iNotiBadgeCount') ?>

    <?php // echo $form->field($model, 'tiAcceptPush') ?>

    <?php // echo $form->field($model, 'tiAcceptEmail') ?>

    <?php // echo $form->field($model, 'tiAcceptSMS') ?>

    <?php // echo $form->field($model, 'tiVerificationStatus') ?>

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
