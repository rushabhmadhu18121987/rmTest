<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = Yii::t('app', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="login-box">
    <div class="login-logo">
        <a href=""><b><img src="<?= Yii::$app->params['LOGO_MINI_URL'] ?>" width="150px" alt="" /></b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">    

        <?php $form = ActiveForm::begin(); ?>
        <div class="form-group has-feedback">
            <?= $form->field($model, 'username')->textInput(['placeholder' => $model->getAttributeLabel('username')])->label(false) ?>
           <!-- <span class="glyphicon glyphicon-envelope form-control-feedback"></span>-->
        </div>
        <div class="form-group has-feedback">
            <?= $form->field($model, 'password')->passwordInput(['placeholder' => $model->getAttributeLabel('password')])->label(false) ?>
          <!--<span class="glyphicon glyphicon-lock form-control-feedback"></span>-->
        </div>
        <div style="color:#999;margin:1em 0"> 
            <?= Html::a('Forgot Password?', ['site/requestresetpassword']) ?> 
        </div>
        <div class="row">

            <!-- /.col -->
            <div class="col-xs-12">

                <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-primary btn-block btn-flat']) ?>
            </div>

            <!-- /.col -->
        </div>

        <?php ActiveForm::end(); ?>




    </div>
    <!-- /.login-box-body -->
</div>


