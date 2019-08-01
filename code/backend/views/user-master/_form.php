<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserMaster */
/* @var $form yii\widgets\ActiveForm */
// echo "<pre>";
// print_r($model);
// die;
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

                        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                            <div class="row">
                                <div class="col-md-6">

                                    <?= $form->field($model, 'vFirstName')->textInput(['maxlength' => true]) ?>

                                    <?= $form->field($model, 'vEmail')->textInput(['maxlength' => true]) ?>

                                </div>                                
                                <div class="col-md-6">
                                
                                    <?= $form->field($model, 'vLastName')->textInput(['maxlength' => true]) ?>

                                    <?= $form->field($model, 'vMobileNumber')->textInput(['maxlength' => true]) ?>   

                                </div>                                
                                <div class="col-md-6">

                                    <!-- = $form->field($model, 'dbLogitude')->textInput() ?>                                       -->

                                    <?= $form->field($model, 'vProfilePic')->fileInput(['maxlength' => true]) ?> 
                                    
                                    <?php
                                    if(!$model->isNewRecord){
                                        if(!empty($model->vProfilePic)){
                                    ?>
                                        <img src="<?= Yii::$app->params['BASE_URL'] ?>backend/uploads/users/<?= $model->vProfilePic?>" height="150" width="150"/>
                                    <?php 
                                        }else{
                                    ?>
                                        <img src="<?= Yii::$app->params['BASE_URL'] ?>/uploads/profile_pic.png" height="150" width="150"/>
                                    <?php
                                    }}
                                    ?> 

                                </div>                                
                                <div class="col-md-6">
                                    
                                    <!-- = $form->field($model, 'dbLatitude')->textInput() ?> -->

                                    <?= $form->field($model, 'tiIsActive')->dropDownList(['1' => 'Active','0' => 'InAcitve']) ?>

                                </div>
                            </div>
                            <div class="form-group">
                                <?php
                                    if($model->isNewRecord){
                                ?>                                
                                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                                <?php
                                    } else {
                                ?>
                                <?= Html::submitButton('Update', ['class' => 'btn btn-info']) ?>
                                <?= Html::a('Back', ['view', 'id' => $model->iUserId], ['class' => 'btn btn-warning']) ?>
                                <?php        
                                    }
                                ?>
                            </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </section>
        </div>
    </section>
</div>
<?php $this->registerJs("
        $(function() {
            $.samaskHtml();
            $('#usermaster-vmobilenumber').samask('(000)000-0000');        
        });
    ",\yii\web\View::POS_END);
?>

