<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\BusinessProvider */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="business-provider-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'vEmail')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cPassword')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vMobileNumber')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tiUserType')->textInput() ?>

    <?= $form->field($model, 'vLangISOCode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tiGender')->textInput() ?>

    <?= $form->field($model, 'dDOB')->textInput() ?>

    <?= $form->field($model, 'vProfilePic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tiIsMobileVerified')->textInput() ?>

    <?= $form->field($model, 'tiIsProfileCompleted')->textInput() ?>

    <?= $form->field($model, 'iOTP')->textInput() ?>

    <?= $form->field($model, 'iOTPExpireAt')->textInput() ?>

    <?= $form->field($model, 'iNotiBadgeCount')->textInput() ?>

    <?= $form->field($model, 'tiIsSocialLogin')->textInput() ?>

    <?= $form->field($model, 'tiIsAcceptPush')->textInput() ?>

    <?= $form->field($model, 'vPasswordResetToken')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tiIsActive')->textInput() ?>

    <?= $form->field($model, 'tiIsDeleted')->textInput() ?>

    <?= $form->field($model, 'iCreatedAt')->textInput() ?>

    <?= $form->field($model, 'iUpdatedAt')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('admin', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
