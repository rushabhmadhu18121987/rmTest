<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\UserNotificationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-notification-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'iUserNotificationId') ?>

    <?= $form->field($model, 'iUserId') ?>

    <?= $form->field($model, 'iVehicleId') ?>

    <?= $form->field($model, 'iParkingSpotId') ?>

    <?= $form->field($model, 'iParkingLotId') ?>

    <?php // echo $form->field($model, 'iUserBookingId') ?>

    <?php // echo $form->field($model, 'vNotificationTitle') ?>

    <?php // echo $form->field($model, 'vNotificationDesc') ?>

    <?php // echo $form->field($model, 'tiNotificationType') ?>

    <?php // echo $form->field($model, 'tiIsActive') ?>

    <?php // echo $form->field($model, 'tiIsRead') ?>

    <?php // echo $form->field($model, 'tiIsDeleted') ?>

    <?php // echo $form->field($model, 'iCreatedAt') ?>

    <?php // echo $form->field($model, 'iUpdatedAt') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
