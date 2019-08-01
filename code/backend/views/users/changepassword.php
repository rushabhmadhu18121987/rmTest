
<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \mdm\admin\models\form\ChangePassword */
$this->title = Yii::t('app', 'Change Password');
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-6 pull-left">
            <p style="text-align: left">
                <?= Html::a('Back', ['./'], ['class' => 'btn btn-primary']) ?>
            </p>    
        </div>
    </div>
    <div class="row">
        <section class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= ucfirst($this->title); ?></h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <?php $form = ActiveForm::begin(['id' => 'form-change']); ?>
                        <div class="col-md-6">
                            <?= $form->field($model, 'vPassword')->passwordInput()->label('Current Password') ?>
                            <?= $form->field($model, 'vNewPassword')->passwordInput()->label('New Password') ?>
                            <?= $form->field($model, 'vReTypePassword')->passwordInput()->label('Confirm Password') ?>
                            <div class="form-group">
                                <?= Html::submitButton(Yii::t('app', 'Change'), ['class' => 'btn btn-primary', 'name' => 'change-button']) ?>
                            </div> 
                        </div>
                        <?php ActiveForm::end(); ?> 
                    </div>
                </div>
            </div>
        </section> 
    </div>
    <!-- /.row -->
</section>
































