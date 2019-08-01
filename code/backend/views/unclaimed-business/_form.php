<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\UnclaimedBusiness */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="unclaimed-business-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'iUserId')->textInput() ?>

    <?= $form->field($model, 'iCategoryId')->textInput() ?>

    <?= $form->field($model, 'vBusinessName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vSlug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vEmail')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vISDCode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vMobileNumber')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vAddress1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vAddress2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vCity')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vZipcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dbLatitude')->textInput() ?>

    <?= $form->field($model, 'dbLongitude')->textInput() ?>

    <?= $form->field($model, 'txBriefDescription')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'txDescription')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'vTagLine')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vLogoPic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fAvgRating')->textInput() ?>

    <?= $form->field($model, 'iTotalRating')->textInput() ?>

    <?= $form->field($model, 'tiIsVerified')->textInput() ?>

    <?= $form->field($model, 'tiIsEventBusiness')->textInput() ?>

    <?= $form->field($model, 'tiIsAddedCustomer')->textInput() ?>

    <?= $form->field($model, 'tiIsActive')->textInput() ?>

    <?= $form->field($model, 'tiIsDeleted')->textInput() ?>

    <?= $form->field($model, 'iCreatedAt')->textInput() ?>

    <?= $form->field($model, 'iUpdatedAt')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('admin', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
