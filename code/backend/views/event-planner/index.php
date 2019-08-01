<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\EventPlannerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('admin', 'event-planner');
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Main content -->
<section class="content container-fluid">
    <div class="row">
        <section class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $this->title ?></h3>
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
                            ['content' => Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['./event-planner'], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => 'Reset Grid'])],
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
                        'responsive' => FALSE,
                        'responsiveWrap' => false,
                        'hover' => true,
                        'floatHeader' => false,
                        'floatHeaderOptions' => ['scrollingTop' => "top"],
                        //'showPageSummary' => true,
                        'panel' => [
                            'type' => GridView::TYPE_DEFAULT
                        ],
                        'persistResize' => false,
                        'columns' => [
                            [
                                'class' => 'kartik\grid\SerialColumn',
                                'width' => '5%',
                                'header' => 'No',
                                'headerOptions' => ['style' => 'color:#337ab7;', 'class' => 'kartik-sheet-style'],
                                'contentOptions' => ['class' => 'kartik-sheet-style']
                            ],
                            [
                                'attribute' => 'vName',
                                'width' => '15%',
                                'enableSorting' => TRUE,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return !empty($model->vName) ? (json_decode('"' . $model->vName . '"')) : 'N/A';
                                }
                            ],
                            [
                                'attribute' => 'vBusinessName',
                                'width' => '15%',
                                'enableSorting' => TRUE,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return !empty($model->vBusinessName) ? (json_decode('"' . $model->vBusinessName . '"')) : 'N/A';
                                },
                            ],
                            [
                                'attribute' => 'vMobileNumber',
                                'width' => '10%',
                                'enableSorting' => TRUE,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return !empty($model->vMobileNumber) ? ($model->vISDCode . ' ' . $model->vMobileNumber) : 'N/A';
                                },
                            ],
                            [
                                'attribute' => 'vEmail',
                                'width' => '15%',
                                'enableSorting' => TRUE,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return !empty($model->vEmail) ? ($model->vEmail) : 'N/A';
                                },
                            ],
                            [
                                'attribute' => 'iTotalEvent',
                                'width' => '15%',
                                'enableSorting' => TRUE,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return (isset($model->iTotalEvent) && $model->iTotalEvent !== NULL) ? ($model->iTotalEvent) : 'N/A';
                                },
                            ],
                            [
                                'attribute' => 'tiIsActive',
                                'label' => 'Status',
                                'width' => '10%',
                                'hAlign' => 'center',
                                'format' => 'raw',
                                'value' => function ($model, $key, $index, $widget) {
                                    if ($model->tiIsActive == 1) {
                                        return Html::a('&nbsp;&nbsp;Active&nbsp;&nbsp;', ['status-change', 'id' => $model->iUserId, 'type' => 0], [
                                                    'class' => 'btn btn-xs btn-success',
                                                    'title' => Yii::t('app', 'Inactive'),
                                                    'data' => [
                                                        'confirm' => Yii::t('app', 'Are you sure you want to <span class="text-danger">Inactive</span> this ' . (Yii::t('admin', 'event-planner-item')) . '?'),
                                                        'method' => 'post',
                                                    //'pjax' => true
                                                    ],
                                        ]);
                                    } else {
                                        return Html::a('Inactive', ['status-change', 'id' => $model->iUserId, 'type' => 1], [
                                                    'class' => 'btn btn-xs btn-danger',
                                                    'title' => Yii::t('app', 'Active'),
                                                    'data' => [
                                                        'confirm' => Yii::t('app', 'Are you sure you want to <span class="text-danger">Active</span> this ' . (Yii::t('admin', 'event-planner-item')) . '?'),
                                                        'method' => 'post',
                                                    ],
                                        ]);
                                    }
                                },
                                'filterType' => GridView::FILTER_SELECT2,
                                'filter' => ['' => 'All', '1' => 'Active', '0' => 'Inactive'],
                            ],
                            [
                                'class' => 'kartik\grid\ActionColumn',
                                'urlCreator' => function() {
                                    return '#';
                                },
                                'header' => "Action",
                                'options' => ['width' => '10%'],
                                'dropdown' => false,
                                'vAlign' => 'middle',
                                'headerOptions' => ['style' => 'color:#337ab7;', 'width' => '10%', 'class' => 'text-center'],
                                'options' => ['class' => 'text-center'],
                                'template' => '{view}{delete}',
                                'buttons' => [
                                    'view' => function ($url, $model) {
                                        return Html::a('<span class="btn btn-xs btn-default" style="margin-right:5%;"><span class="glyphicon glyphicon-eye-open"></span></span>', ['view', 'id' => $model->iUserId], [
                                                    'title' => Yii::t('app', 'view'),
                                        ]);
                                    },
                                    'update' => function ($url, $model) {
                                        return Html::a('<span class="btn btn-xs btn-warning" style="margin-right:5%;">Edit</span>', ['update', 'id' => $model->iUserId], [
                                                    'title' => Yii::t('app', 'update'),
                                        ]);
                                    },
                                    'delete' => function ($url, $model) {

                                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->iUserId], [
                                                    'class' => 'btn btn-xs btn-danger',
                                                    'title' => Yii::t('app', 'delete'),
                                                    'data' => [
                                                        'confirm' => Yii::t('app', 'Are you sure you want to delete this ' . (Yii::t('admin', 'event-planner-item')) . '?'),
                                                        'method' => 'post',
                                                    ],
                                        ]);
                                    }
                                ],
                            ],
                        ],
                    ]);
                    ?>
                    <!-- /.box-body -->
                </div>
            </div>
        </section>
    </div>
    <!-- /.row --> 
</section>
<!-- /.content -->
