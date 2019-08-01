<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model backend\models\ContentPages */
/* @var $form yii\widgets\ActiveForm */
?>
<section class="content container-fluid">
    <p style="text-align: right">
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-info']) ?>
    </p>
    <div class="row">
        <section class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $this->title ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'vPageName')->textInput(['maxlength' => true, 'style' => "font-size: 14px;"]) ?>

                    <?=
                    $form->field($model, 'txContent')->widget(CKEditor::className(), [
                        'options' => ['rows' => 6],
                        'preset' => 'basic'
                    ])
                    ?>
                    <div class="form-group">
                        <!-- Button -->
                        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

                    </div>
                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </section> 
    </div>
    <!-- /.row --> 
</section>
<!-- /.content -->

