<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model backend\models\AdminAnnouncements */
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
                    <div class="row">
                        <div class="col-md-6">
                            <?php $form = ActiveForm::begin(); ?>

                            <?= $form->field($model, 'tiNotificationReceiver')->widget(Select2::classname(), ['data' => [0 => 'All Users', 1 => 'Customer', 2 => 'Business Provider', 3 => 'All Customer', 4 => 'All Business Provider'], 'options' => ['prompt' => 'Select Receiver']]) ?>

                            <?=
                            $form->field($model, 'iUsers')->widget(Select2::classname(), [
                                'options' => ['placeholder' => 'Search User', 'multiple' => 'multiple', 'class' => 'clsUserList'],
                                'pluginOptions' => [
                                    'multiple' => 'multiple',
                                    'allowClear' => true,
                                    'minimumInputLength' => 0,
                                    'language' => [
                                        'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                                    ],
                                    'ajax' => [
                                        'url' => Url::to('search-user'),
                                        'dataType' => 'json',
                                        'data' => new JsExpression('function(params) {return {searchTerm:params.term,"tiUserType":$("#adminannouncements-tinotificationreceiver").val()}; }')
                                    ],
                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                    'templateResult' => new JsExpression('function(item) { return item.text; }'),
                                    'templateSelection' => new JsExpression('function (item) { return item.text; }'),
                                ],
                            ]);
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'vMessage')->textArea(['rows' => '3']) ?>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                            </div>
                        </div>
                    </div>


                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </section> 
    </div>
    <!-- /.row --> 
</section>
<!-- /.content -->
<?php $this->registerJsFile('@web/js/pages/announcements.js', ['depends' => 'backend\assets\AppAsset', 'position   ' => $this::POS_END]); ?>