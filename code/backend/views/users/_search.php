<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\UsersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'iUserId') ?>

    <?= $form->field($model, 'vAuthKey') ?>

    <?= $form->field($model, 'vRecipientId') ?>

    <?= $form->field($model, 'vEmail') ?>

    <?= $form->field($model, 'vPassword') ?>

    <?php // echo $form->field($model, 'vFacebookId') ?>

    <?php // echo $form->field($model, 'vGoogleId') ?>

    <?php // echo $form->field($model, 'vFirstName') ?>

    <?php // echo $form->field($model, 'vLastName') ?>

    <?php // echo $form->field($model, 'vProfilePic') ?>

    <?php // echo $form->field($model, 'tiLanguage') ?>

    <?php // echo $form->field($model, 'fTotBalance') ?>

    <?php // echo $form->field($model, 'tiDeviceType') ?>

    <?php // echo $form->field($model, 'vDeviceToken') ?>

    <?php // echo $form->field($model, 'tiAcceptPush') ?>

    <?php // echo $form->field($model, 'vPasswordResetToken') ?>

    <?php // echo $form->field($model, 'iCreatedAt') ?>

    <?php // echo $form->field($model, 'tiIsActive') ?>

    <?php // echo $form->field($model, 'tiIsDelete') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
