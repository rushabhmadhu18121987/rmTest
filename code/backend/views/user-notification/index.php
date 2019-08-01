<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserNotificationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$layout = <<< HTML
        <div class="pull-right">{summary}</div>
        <div class="clearfix"></div>
        {items}
        <div class="clearfix"></div>
        <div class="text-center">{pager}</div> 
HTML;


$this->title = 'User Notifications';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-notification-index">

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

                    <?php
                    $gridcolumns = [
                        [
                            'class' => 'kartik\grid\SerialColumn',
                            'width' => '5%',
                            'header' => 'No',
                            'headerOptions' => ['style' => 'color:#337ab7;', 'class' => 'kartik-sheet-style'],
                            'contentOptions' => ['class' => 'kartik-sheet-style']
                        ],
                        [
                            'attribute' => 'iUserId',
                            'filter' => TRUE,
                            'width' => '15%',
                            'enableSorting' => TRUE,
                            'format' => 'raw',
                            'value' => function ($model) {
                                return $model->iUserId;
                            },
                        ],
                        [
                            'attribute' => 'iVehicleId',
                            'filter' => TRUE,
                            'width' => '15%',
                            'enableSorting' => TRUE,
                            'format' => 'raw',
                            'value' => function ($model) {
                                return $model->iVehicleId;
                            },
                        ],
                        [
                            'attribute' => 'iParkingSpotId',
                            'filter' => TRUE,
                            'width' => '15%',
                            'enableSorting' => TRUE,
                            'format' => 'raw',
                            'value' => function ($model) {
                                return $model->iParkingSpotId;
                            },
                        ],
                        [
                            'attribute' => 'iParkingLotId',
                            'filter' => TRUE,
                            'width' => '15%',
                            'enableSorting' => TRUE,
                            'format' => 'raw',
                            'value' => function ($model) {
                                return $model->iParkingLotId;
                            },
                        ],
                        [
                            'attribute' => 'vNotificationTitle',
                            'filter' => TRUE,
                            'width' => '15%',
                            'enableSorting' => TRUE,
                            'format' => 'raw',
                            'value' => function ($model) {
                                return $model->vNotificationTitle;
                            },
                        ],
                        [
                            'attribute' => 'iCreatedAt',
                            'filter' => FALSE,
                            'width' => '12%',
                            'enableSorting' => TRUE,
                            'format' => 'raw',
                            'value' => function ($model) {
                                return date("M d,Y H:i:s", $model->iCreatedAt);
                            },
                        ],
                        //'iUserBookingId', 
                        //'tiNotificationType',
                        //'tiIsActive',
                        //'tiIsRead',                         
                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'header' => "Action",
                            'options' => ['width' => '10%'],
                            'dropdown' => false,
                            'vAlign' => 'middle',
                            'headerOptions' => ['style' => 'color:#337ab7;', 'width' => '10%', 'class' => 'text-center'],
                            'options' => ['class' => 'text-center'],
                            'template' => '{view} &nbsp;{delete} ', /* {update}&nbsp; */
                            'buttons' => [
                                'view' => function ($url, $model) {
                                    return Html::a('<span class="btn btn-xs btn-default" style="margin-right:5%;"><span class="glyphicon glyphicon-eye-open"></span></span>', $url, [
                                                'title' => Yii::t('app', 'view'),
                                    ]);
                                },
                                'delete' => function ($url, $model) {

                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->iUserNotificationId], [
                                                'class' => 'btn btn-xs btn-danger',
                                                'title' => Yii::t('app', 'delete'),
                                                'data' => [
                                                    'confirm' => Yii::t('app', 'Are you sure you want to delete this  User Notifications?'),
                                                    'method' => 'post',
                                                ],
                                    ]);
                                }
                            ],
                        ],
                    ];
                    ?>


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
                            ['content' => Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['./user-notification'], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => 'Reset Grid'])],
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
                        'columns' => $gridcolumns,
                    ]);
                    ?> 
                </div>
            </div>
        </section>
    </div>
</div>
