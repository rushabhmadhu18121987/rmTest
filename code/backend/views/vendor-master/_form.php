<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserMaster */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-master-form">
    <section class="content container-fluid">
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

                        <?= $form->field($model, 'vEmail')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'vMobileNumber')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'vProfilePic')->fileInput() ?>

                        <?= $form->field($model, 'vBusinessName')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'vWebsite')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'vCountry')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'vState')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'vCity')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'dbLatitude')->textInput() ?>

                        <?= $form->field($model, 'dbLogitude')->textInput() ?>

                        <?= $form->field($model, 'tiAcceptPush')->dropdownList([ 1 => 'Yes', 0 => 'No']) ?>

                        <?= $form->field($model, 'tiAcceptEmail')->dropdownList([ 1 => 'Yes', 0 => 'No']) ?>

                        <?= $form->field($model, 'tiAcceptSMS')->dropdownList([ 1 => 'Yes', 0 => 'No']) ?>

                        <!-- <?= $form->field($model, 'tiIsDeleted')->dropdownList([ 1 => 'Yes', 0 => 'No']) ?> -->

                        <?= $form->field($model, 'tiVerificationStatus')->dropdownList([0=>'Pending',1 => 'Verified', 2 => 'Declined']) ?>

                        <?= $form->field($model, 'tiIsActive')->dropdownList([ 1 => 'Active', 0 => 'Inactive']) ?>

                        <div class="form-group">
                            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                        </div>
                </div>
            </section>
        </div>
    </section>
</div>
