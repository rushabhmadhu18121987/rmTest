<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<!-- Main content -->
<section class="content container-fluid">

    <div class="row">
        <section class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <!--                    <h3 class="box-title">Add New Water Station</h3>
                                        <div class="box-tools pull-right">
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                
                                        </div>-->
                </div>
                <!-- /.box-header -->
                <div class="box-body min-height-500">
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="row">
                        <div class="col-sm-6 col-xs-12">
                            <?= $form->field($model, 'vEmail')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'vPassword')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'vFirstName')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'vLastName')->textInput(['maxlength' => true]) ?>
                        </div>
                 

                    </div>
                    <div class="clearfix">&nbsp;</div>  
                    <div class="box-footer clearfix"> 
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <?= Html::submitButton('Update', ['class' => 'btn btn-md btn-primary mr10']) ?>
                                <?php //Html::button('Cancel', ['class' => 'btn btn-md btn-default']) ?>
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                    <!-- /.box-body -->

                </div>
            </div>
        </section> 


    </div>
    <!-- /.row --> 



</section>
<!-- /.content -->