<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\UserNotification */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-notification-form">
    <div class="row">
        <section class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $this->title ?></h3>
                    <div class="box-tools pull-right">
                        <!--<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>-->                
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'iUserId')->textInput() ?>

                    <?= $form->field($model, 'iVehicleId')->textInput() ?>

                    <?= $form->field($model, 'iParkingSpotId')->textInput() ?>

                    <?= $form->field($model, 'iParkingLotId')->textInput() ?>

                    <?= $form->field($model, 'iUserBookingId')->textInput() ?>

                    <?= $form->field($model, 'vNotificationTitle')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'vNotificationDesc')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'tiNotificationType')->textInput() ?>

                    <?= $form->field($model, 'tiIsActive')->textInput() ?>

                    <?= $form->field($model, 'tiIsRead')->textInput() ?>

                    <?= $form->field($model, 'tiIsDeleted')->textInput() ?>

                    <?= $form->field($model, 'iCreatedAt')->textInput() ?>

                    <?= $form->field($model, 'iUpdatedAt')->textInput() ?>

                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </section>
    </div>
</div>
