<?php

use yii\helpers\Html;
use kartik\grid\GridView;

//use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AdminAnnouncementsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('admin', 'admin-announcements');
$this->params['breadcrumbs'][] = $this->title;

$context = $this->context;
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

                    <?php
                    $gridColumns = [
                        [
                            'class' => 'kartik\grid\SerialColumn',
                            'width' => '5%',
                            'header' => 'No',
                            'headerOptions' => ['style' => 'color:#337ab7;', 'class' => 'kartik-sheet-style'],
                            'contentOptions' => ['class' => 'kartik-sheet-style']
                        ],
//                        [
//                            'attribute' => 'vSubject',
//                            'vAlign' => 'middle',
//                            'width' => '25%',
//                        ],
                        [
                            'attribute' => 'vMessage',
                            'vAlign' => 'middle',
                            'width' => '50%',
                        ],
                        [
                            'attribute' => 'tiNotificationReceiver',
                            'width' => '10%',
                            'hAlign' => 'left',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $widget) {
                                if ($model->tiNotificationReceiver == 0) {
                                    return "All Users";
                                } elseif ($model->tiNotificationReceiver == 1) {
                                    return "Customer";
                                } elseif ($model->tiNotificationReceiver == 2) {
                                    return "Business Provider";
                                } elseif ($model->tiNotificationReceiver == 3) {
                                    return "All Customer";
                                } elseif ($model->tiNotificationReceiver == 4) {
                                    return "All Business Provider";
                                }
                            },
                            'filterType' => GridView::FILTER_SELECT2,
                            'filter' => ['' => 'All',0 => 'All Users', 1 => 'Customer', 2 => 'Business Provider', 3 => 'All Customer', 4 => 'All Business Provider'],
                        ],
                        [
                            'attribute' => 'iCreatedAt',
                            'filter' => false,
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                            'width' => '10%',
                            'value' => function ($model) use ($context) {
                                return Carbon\Carbon::createFromTimestamp($model->iCreatedAt)->setTimezone($context->timezone)->format($context->datetimeFormat);
                            }
                        ],
                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'header' => "Action",
                            'options' => ['width' => '10%'],
                            'dropdown' => false,
                            'vAlign' => 'middle',
                            'headerOptions' => ['style' => 'color:#337ab7;', 'width' => '10%', 'class' => 'text-center'],
                            'options' => ['class' => 'text-center'],
                            'template' => '{view} {delete}',
                            'buttons' => [
                                'view' => function ($url, $model) {
                                    return Html::a('<span class="btn btn-xs btn-default" style="margin-right:5%;"><span class="glyphicon glyphicon-eye-open"></span></span>', $url, [
                                                'title' => Yii::t('app', 'view'),
                                    ]);
                                },
                                    'delete' => function ($url, $model) {

                                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->iAnnouncementId], [
                                                    'class' => 'btn btn-xs btn-danger',
                                                    'title' => Yii::t('app', 'delete'),
                                                    'data' => [
                                                        'confirm' => Yii::t('app', 'Are you sure you want to delete this ' . (Yii::t('admin', 'admin-announcement-item')) . '?'),
                                                        'method' => 'post',
                                                    ],
                                        ]);
                                    }
                            ],
                        ],
                    ];

                    echo GridView::widget([
                        'id' => "verified_artists_grid",
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => $gridColumns,
                        'export' => false,
                        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                        //        'beforeHeader' => [
                        //            [
                        //                'columns' => [
                        //                    ['content' => 'Header Before 1', 'options' => ['colspan' => 4, 'class' => 'text-center warning']],
                        //                    ['content' => 'Header Before 2', 'options' => ['colspan' => 4, 'class' => 'text-center warning']],
                        //                    ['content' => 'Header Before 3', 'options' => ['colspan' => 3, 'class' => 'text-center warning']],
                        //                ],
                        //                'options' => ['class' => 'skip-export'] // remove this row from export
                        //            ]
                        //        ],
                        'toolbar' => [
                            ['content' =>
                                Html::a('<i class="glyphicon glyphicon-bullhorn"></i>', ['create'], ['data-pjax' => 0, 'class' => 'btn btn-success', 'title' => 'Send Announcement']),],
                            ['content' =>
                                // Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type' => 'button', 'title' => Yii::t('kvgrid', 'Add Book'), 'class' => 'btn btn-success']) 

                                Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['./admin-announcements'], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => 'Reset Grid'])
                            ],
                            '{export}',
                            '{toggleData}',
                        ],
                        'pjax' => true,
                        'bordered' => true,
                        'striped' => true,
                        'condensed' => true,
                        'responsive' => false,
                        'responsiveWrap' => false,
                        'hover' => true,
                        'floatHeader' => false,
                        'floatHeaderOptions' => ['scrollingTop' => "top"],
                        'panel' => [
                            'type' => GridView::TYPE_DEFAULT
                        ],
                        'persistResize' => false,
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



<!--delete-modal -->
<div class="modal fade" id="delete-announcement" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Delete Announcement</h4>
            </div>
            <div class="modal-body">
                <p style="font-size: 15px;">Are you sure you want to delete the announcement?</p>
            </div>
            <div class="modal-footer">
                <a href="" id="delete-' . (Yii::t('admin', 'admin-announcement-item')) . '" data-method="post" type="button" class="btn btn-danger">Yes</a>
                <a href="" type="button" class="btn btn-info" data-dismiss="modal">No</a>
            </div>
        </div>
    </div>
</div>
<!--delete-modal -->

<?php
$js = '
            $(document).on("click", ".delete-grid-row", function() {
              
                $("#delete-' . (Yii::t('admin', 'admin-announcement-item')) . '").attr("href", $(this).attr("href"));
            });';

$this->registerJs($js, \yii\web\View::POS_END);
?>