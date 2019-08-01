<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Alert;

/* @var $this yii\web\View */
/* @var $model backend\models\CategoryMaster */
/* @var $form yii\widgets\ActiveForm */
$this->title = Yii::t('admin', 'change-password');
$this->params['breadcrumbs'][] = $this->title;
?>



<?php if (!empty(\Yii::$app->session->getFlash('success'))) { ?>
    <div class="alert alert-success">
        <?= \Yii::$app->session->getFlash('success') ?>
    </div>
<?php } elseif (!empty(\Yii::$app->session->getFlash('error'))) {
    ?>
    <div class="alert alert-danger">
        <?= \Yii::$app->session->getFlash('error') ?>
    </div>
<?php }
?>

<div class="change-password-form">
    <section class="content container-fluid">
        <div class="row">
            <section class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= $this->title ?></h3>
                        <div class="box-tools pull-right"> 
                        </div>
                    </div>
                    <!-- /.box-header --> 
                    <div class="box-body">

                        <?php $form = ActiveForm::begin(); ?>
                        <div class="row">
                            <div class="col-md-6">

                                <?= $form->field($model, 'currentPassword')->passwordInput(['maxlength' => true, 'class' => 'form-control']) ?>

                                <?= $form->field($model, 'newPassword')->passwordInput(['maxlength' => true, 'class' => 'form-control']) ?>

                                <?= $form->field($model, 'confirmPassword')->passwordInput() ?>
                            </div>
                            <div class="col-md-6">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-info']) ?>
                                </div>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </section>
        </div>
    </section>
</div>
<!-- /.content -->
