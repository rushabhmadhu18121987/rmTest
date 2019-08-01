<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\BusinessProviderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="business-provider-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'iUserId') ?>

    <?= $form->field($model, 'vEmail') ?>

    <?= $form->field($model, 'cPassword') ?>

    <?= $form->field($model, 'vMobileNumber') ?>

    <?= $form->field($model, 'vName') ?>

    <?php // echo $form->field($model, 'tiUserType') ?>

    <?php // echo $form->field($model, 'vLangISOCode') ?>

    <?php // echo $form->field($model, 'tiGender') ?>

    <?php // echo $form->field($model, 'dDOB') ?>

    <?php // echo $form->field($model, 'vProfilePic') ?>

    <?php // echo $form->field($model, 'tiIsMobileVerified') ?>

    <?php // echo $form->field($model, 'tiIsProfileCompleted') ?>

    <?php // echo $form->field($model, 'iOTP') ?>

    <?php // echo $form->field($model, 'iOTPExpireAt') ?>

    <?php // echo $form->field($model, 'iNotiBadgeCount') ?>

    <?php // echo $form->field($model, 'tiIsSocialLogin') ?>

    <?php // echo $form->field($model, 'tiIsAcceptPush') ?>

    <?php // echo $form->field($model, 'vPasswordResetToken') ?>

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
