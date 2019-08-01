<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model backend\models\BannerMaster */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banners-form">
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
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'vTitle')->textInput(['maxlength' => true]) ?>
                                <?= $form->field($model, 'tiBannerType')->dropdownList(['0' => 'Default', '1' => 'Business', '2' => 'Event'], ['prompt' => 'Select Category Type']) ?>
                                <?= $form->field($model, 'tiOrderNo')->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-md-6 clsCategory">
                                <?= $form->field($model, 'vBannerPic')->fileInput(['maxlength' => true, 'class' => 'clsCategory']) ?>

                            </div>
                        </div>
                        <div class="form-group">
                            <?= Html::submitButton(Yii::t('admin', 'Save'), ['class' => 'btn btn-success']) ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </section>
        </div>
    </section>
</div>
<?php $this->registerJsFile('@web/js/pages/banner.js', ['depends' => 'backend\assets\AppAsset', 'position   ' => $this::POS_END]); ?>
