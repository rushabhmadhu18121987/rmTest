<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\EventMaster */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="event-master-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'iBusinessId')->textInput() ?>

    <?= $form->field($model, 'iUserId')->textInput() ?>

    <?= $form->field($model, 'iCategoryId')->textInput() ?>

    <?= $form->field($model, 'vTitle')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vSlug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dStartDt')->textInput() ?>

    <?= $form->field($model, 'dExpireDt')->textInput() ?>

    <?= $form->field($model, 'txDescription')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'vAddress1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vAddress2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vCity')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vZipcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dbLatitude')->textInput() ?>

    <?= $form->field($model, 'dbLongitude')->textInput() ?>

    <?= $form->field($model, 'vBannerPic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tiIsActive')->textInput() ?>

    <?= $form->field($model, 'tiIsDeleted')->textInput() ?>

    <?= $form->field($model, 'iCreatedAt')->textInput() ?>

    <?= $form->field($model, 'iUpdatedAt')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('admin', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
