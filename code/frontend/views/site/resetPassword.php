<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Reset password';
//$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container bootstrap snippet" style="margin-top: 100px;">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-2">
            <?php if ($status == 1) { ?>
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <span class="glyphicon glyphicon-th"></span>
                            Reset password  
                        </h3>
                    </div>
                    <?php
                    $form = ActiveForm::begin(['id' => 'reset-password-form',
                                'encodeErrorSummary' => false,
                    ]);
                    ?>
                    <div class="panel-body">
                        <div class="row">
                            <div style="margin-top:20px;" class="login-box">
                                <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4" style="text-align: right">New Password</div>
                                <div class="form-group col-xs-12 col-sm-12 col-md-8 col-lg-8">
                                    <?= $form->field($model, 'vPassword')->passwordInput(['placeholder' => "New Password", 'class' => "form-control", 'autocomplete' => "off", 'value' => ""])->label(false) ?>
                                </div>
                                <div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4" style="text-align: right">Confirm Password</div>
                                <div class="form-group col-xs-12 col-sm-12 col-md-8 col-lg-8">
                                    <?= $form->field($model, 'confirmPassword')->passwordInput(['placeholder' => "Confirm password", 'class' => "form-control login-txt", 'autocomplete' => "off"])->label(false) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12" style="text-align: center">
                                <button class="btn icon-btn-save btn-success" type="submit">
                                    <span class="btn-save-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>save</button>
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            <?php } else if ($status == 2) { ?>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <span class="glyphicon glyphicon-lock"></span>
                            Reset password   
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div style="padding: 20px;font-size: 15px;">
                                <?= $message ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <span class="glyphicon glyphicon-lock"></span>
                            Reset password
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div style="padding: 20px;font-size: 15px;">
                                <?= $message ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>