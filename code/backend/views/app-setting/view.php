<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AppSetting */

$this->title = 'Details';
$this->params['breadcrumbs'][] = ['label' => 'App Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$context = $this->context;
?>
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-6 pull-left">
            <p style="text-align: left">
                <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
            </p>    

        </div>
        <div class="col-md-6 pull-right">
            <p style="text-align: right">
                <?= Html::a('Update', ['update', 'id' => $model->iAppSettingId], ['class' => 'btn btn-primary']) ?>
            </p>
        </div>
    </div> 
    <div class="row">
        <section class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $this->title ?></h3>
                    <div class="box-tools pull-right">
                        <h3 class="box-title"><?= ucfirst($this->title); ?></h3>              
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">  


                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'vSettingLabel',
                            'vAppSettingValue',
//                            'vAppSettingDesc',
                            [
                                'attribute' => 'iCreatedAt',
                                'value' => function ($model) use ($context) {
                                    return Carbon\Carbon::createFromTimestamp($model->iCreatedAt)->setTimezone($context->timezone)->format($context->datetimeFormat);
                                }
                            ],
                            [
                                'attribute' => 'iUpdatedAt',
                                'value' => function ($model) use ($context) {
                                    return !empty($model->iUpdatedAt) ? Carbon\Carbon::createFromTimestamp($model->iUpdatedAt)->setTimezone($context->timezone)->format($context->datetimeFormat) : '';
                                }
                            ],
                        ],
                    ])
                    ?>
                </div>
            </div>
        </section>
    </div>
</section>

