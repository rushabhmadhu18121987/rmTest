<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ListerMaster */
/* @var $form yii\widgets\ActiveForm */
?>

<section class="content container-fluid">

    <div class="row">
        <section class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                </div>
                <div class="box-body">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'vUserName')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'vName')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'vEmail')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'vISDCode')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'vMobileNumber')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'vPassword')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'vProfilePic')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'tiUserType')->textInput() ?>

                    <?= $form->field($model, 'tiIsSocialLogin')->textInput() ?>

                    <?= $form->field($model, 'vOTP')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'iOTPExpireAt')->textInput() ?>

                    <?= $form->field($model, 'tiIsMobileVerified')->textInput() ?>

                    <?= $form->field($model, 'vPasswordResetToken')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'iNotiBadgeCount')->textInput() ?>

                    <?= $form->field($model, 'tiAcceptPush')->textInput() ?>

                    <?php // $form->field($model, 'tiIsActive')->textInput() ?>

                    <?php //$form->field($model, 'tiIsDeleted')->textInput() ?>

                    <?php //$form->field($model, 'iCreatedAt')->textInput() ?>

                    <?php //$form->field($model, 'iUpdatedAt')->textInput() ?>

                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>


                </div>
            </div>
        </section> 

    </div>
    <!-- /.row --> 
</section>