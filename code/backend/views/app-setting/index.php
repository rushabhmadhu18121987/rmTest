<?php

use yii\helpers\Html;
use kartik\grid\GridView;

//use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ParkingOfficer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'App Settings');
$this->params['breadcrumbs'][] = $this->title;

$context = $this->context;
$layout = <<< HTML
        <div class="pull-right">{summary}</div>
        <div class="clearfix"></div>
        {items}
        <div class="clearfix"></div>
        <div class="text-center">{pager}</div>
HTML;
?>

<!-- Main content --> 
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
                    <?=
                    GridView::widget([
                        'layout' => $layout,
                        'id' => "verified_artists_grid",
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'export' => false,
                        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                        'toolbar' => [
                            /*  ['content' =>
                              Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['data-pjax' => 0, 'class' => 'btn btn-success', 'title' => 'Add Vehicle Brands'])
                              ], */
                            ['content' => Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['./app-setting'], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => 'Reset Grid'])],
                            '{export}',
                            '{toggleData}',
                        ],
                        'pjax' => true,
                        'pjaxSettings' => [
                            'options' => [
                                'timeout' => false,
                                'enablePushState' => false,
                            ],
                        ],
                        'bordered' => true,
                        'striped' => true,
                        'condensed' => true,
                        'responsive' => false,
                        'responsiveWrap' => false,
                        'hover' => true,
                        'floatHeader' => false,
                        'floatHeaderOptions' => ['scrollingTop' => "top"],
                        /* 'showPageSummary' => true, */
                        'panel' => [
                            'type' => GridView::TYPE_DEFAULT,
                        ],
                        'persistResize' => false,
                        'columns' => [
                            [
                                'class' => 'kartik\grid\SerialColumn',
                                'width' => '10%',
                                'header' => 'No',
                                'headerOptions' => ['style' => 'color:#337ab7;', 'class' => 'kartik-sheet-style'],
                                'contentOptions' => ['class' => 'kartik-sheet-style']
                            ],
                            [
                                'attribute' => 'vSettingLabel',
                                'filter' => TRUE,
                                'width' => '35%',
                                'enableSorting' => TRUE,
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'vAppSettingValue',
                                'filter' => TRUE,
                                'width' => '40%',
                                'enableSorting' => TRUE,
                                'format' => 'raw',
                            ],
                            [
                                'class' => 'kartik\grid\ActionColumn',
                                'header' => "Action",
                                'options' => ['width' => '10%'],
                                'dropdown' => false,
                                'vAlign' => 'middle',
                                'headerOptions' => ['style' => 'color:#337ab7;', 'width' => '10%', 'class' => 'text-center'],
                                'options' => ['class' => 'text-center'],
                                'template' => '{view}&nbsp;{update}&nbsp;',
                                'buttons' => [
                                    'view' => function ($url, $model) {
                                        return Html::a('<span class="btn btn-xs btn-default" style="margin-right:5%;"><span class="glyphicon glyphicon-eye-open"></span></span>', $url, [
                                                    'title' => Yii::t('app', 'view'),
                                        ]);
                                    },
                                    'update' => function ($url, $model) {
                                        return Html::a('<span class="btn btn-xs btn-warning" style="margin-right:5%;"><span class="glyphicon glyphicon-pencil"></span></span>', ['update', 'id' => $model->iAppSettingId], [
                                                    'title' => Yii::t('app', 'update'),
                                        ]);
                                    },
                                ],
                            ],
                        ],
                    ]);
                    ?>  <!-- /.box-body -->
                </div>
            </div>
        </section>
    </div>  
</section> 