<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ContentPages */


$this->title = 'Details';
$this->params['breadcrumbs'][] = ['label' => 'Content Management', 'url' => ['index']];
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
                <?= Html::a('Update', ['update', 'id' => $model->iPageId], ['class' => 'btn btn-primary']) ?>
                <?php
                Html::a('Delete', ['delete', 'id' => $model->iPageId], [
                    'class' => 'btn btn-danger',
                    'data' => ['confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',],
                ]);
                ?> 
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
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'vPageName',
                                'format' => 'raw',
                                'value' => !empty($model->vPageName) ? $model->vPageName : '',
                            ],
                            [
                                'attribute' => 'txContent',
                                'format' => 'Html',
                                'value' => !empty($model->txContent) ? $model->txContent : '',
                            ],
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
    <!-- /.row -->
</section>
