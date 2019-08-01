<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ContactUs */

$this->title = 'Details';
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'contact-us'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$context = $this->context;
?>
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-6 pull-left">
            <p style="text-align: left">
                <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
            </p>  
        </div>
    </div> 
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
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'vName',
                                'value' => function ($model) {
                                    return $model->iUser->vName ?? 'N/A';
                                }
                            ],
                            [
                                'attribute' => 'vEmail',
                                'value' => function ($model) {
                                    return $model->vEmail ?? 'N/A';
                                }
                            ],
                            [
                                'attribute' => 'txMessage',
                                'format' => 'html',
                                'value' => function ($model) {
                                    return $model->txMessage ?? 'N/A';
                                }
                            ],
                            [
                                'attribute' => 'iCreatedAt',
                                'value' => function ($model) use ($context) {
                                    return Carbon\Carbon::createFromTimestamp($model->iCreatedAt)->setTimezone($context->timezone)->format($context->datetimeFormat);
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
