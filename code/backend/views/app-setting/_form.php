<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\AppSetting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="app-setting-form">
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
                        <div class="row">
                            <div class="col-md-6">
                                <?php $form = ActiveForm::begin(); ?>
                                <?php if ($model->iAppSettingId == 10) : ?>
                                    <?= $form->field($model, 'vAppSettingValue')->widget(Select2::classname(), ['data' => array_combine(DateTimeZone::listIdentifiers(), DateTimeZone::listIdentifiers()), 'options' => ['prompt' => 'Select Timezone']])->label($model->vSettingLabel) ?>
                                <?php else : ?>
                                    <?= $form->field($model, 'vAppSettingValue')->textInput(['maxlength' => true])->label($model->vSettingLabel) ?>
                                <?php endif; ?>
                                <?php $form->field($model, 'vAppSettingDesc')->textInput(['maxlength' => true]) ?>
                                <div class="form-group">
                                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                                </div>
                                <?php ActiveForm::end(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>
</div>
