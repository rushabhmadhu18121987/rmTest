<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'user-master');
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?= $this->title ?></h1>
</section>

<!--<div class="col-lg-3 col-xs-12">
     small box 
    <div class="small-box bg-white">
        <div class="inner">
            <div class="row">		
                <div class="col-sm-6">
                    <h3>0</h3>
                    <p>Activated</p>
                </div>	
            </div>	
        </div>        

    </div>
</div>
<div class="col-lg-3 col-xs-12">
     small box 
    <div class="small-box bg-white">
        <div class="inner">
            <div class="row">		
                <div class="col-sm-6">
                    <h3>0</h3>
                    <p>Deactivated</p>
                </div>	
            </div>	
        </div>        

    </div>
</div>-->
<?php
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
                    <!--                    <h3 class="box-title">Add New Water Station</h3>
                                        <div class="box-tools pull-right">
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                
                                        </div>-->
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <?=
                    GridView::widget([
                        'layout' => $layout,
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'pjax' => true,
                        'pjaxSettings' => [
                            'options' => [
                                'timeout' => false,
                                'enablePushState' => false,
                            ]
                        ],
                        'containerOptions' => ['style' => 'overflow: auto'],
                        'responsive' => true,
                        'responsiveWrap' => false,
                        'bordered' => true,
                        'striped' => true,
                        'condensed' => true,
                        'hover' => true,
                        'columns' => [
                            //'vProfilePic',
                            [

                                'attribute' => 'vFirstName',
                                'label' => 'Full Name',
                                'width' => '20%',
                                'enableSorting' => TRUE,
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->vFirstName . " " . $model->vLastName;
                                },
                            ],
                            [
                                'attribute' => 'vRecipientId',
                                'width' => '10%',
                            ],
                            [
                                'attribute' => 'vEmail',
                                'width' => '25%',
                            ],
                            //'vEmail:email',
                            [
                                'attribute' => 'fTotBalance',
                                'hAlign' => 'right',
                                'width' => '10%',
                                'value' => function ($model) {
                                    return number_format($model->fTotBalance, 2) . ' USD';
                                }
                            ],
                            [
                                'attribute' => 'tiIsActive',
                                'width' => '8%',
                                'hAlign' => 'center',
                                'format' => 'raw',
                                'value' => function ($model, $key, $index, $widget) {
                                    if ($model->tiIsActive == 1) {
                                        return Html::a('&nbsp;&nbsp;Active&nbsp;&nbsp;', ['status-change', 'id' => $model->iUserId, 'type' => 0], [
                                                    'class' => 'btn btn-xs btn-success',
                                                    'title' => Yii::t('app', 'Inactive'),
                                                    'data' => [
                                                        'confirm' => Yii::t('app', 'Are you sure you want to <span class="text-danger">Inactive</span> this user?'),
                                                        'method' => 'post',
                                                    //'pjax' => true
                                                    ],
                                        ]);
                                    } else {
                                        return Html::a('Inactive', ['status-change', 'id' => $model->iUserId, 'type' => 1], [
                                                    'class' => 'btn btn-xs btn-danger',
                                                    'title' => Yii::t('app', 'Active'),
                                                    'data' => [
                                                        'confirm' => Yii::t('app', 'Are you sure you want to <span class="text-danger">Active</span> this user?'),
                                                        'method' => 'post',
                                                    ],
                                        ]);
                                    }
                                },
                                        'filterType' => GridView::FILTER_SELECT2,
                                        'filter' => ['' => 'All', '1' => 'Active', '0' => 'Inactive'],
                                    ],
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'header' => 'Actions',
                                        'headerOptions' => ['style' => 'color:#337ab7;', 'width' => '10%', 'class' => 'text-center'],
                                        'options' => ['class' => 'text-center'],
                                        'template' => '{view}{delete}',
                                        'buttons' => [
                                            'view' => function ($url, $model) {
                                                return Html::a('<span class="btn btn-xs btn-default" style="margin-right:10%;">View</span>', $url, [
                                                            'title' => Yii::t('app', 'update'),
                                                ]);
                                            },
                                                    'update' => function ($url, $model) {
                                                return Html::a('<span class="btn btn-xs btn-primary" style="margin-right:10%;">Edit</span>', $url, [
                                                            'title' => Yii::t('app', 'update'),
                                                ]);
                                            },
                                                    'delete' => function ($url, $model) {

                                                return Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->iUserId], [
                                                            'class' => 'btn btn-xs btn-danger',
                                                            'title' => Yii::t('app', 'delete'),
                                                            'data' => [
                                                                'confirm' => Yii::t('app', 'Are you sure you want to delete this user?'),
                                                                'method' => 'post',
                                                            ],
                                                ]);
                                            }
                                                ],
//                                                'urlCreator' => function ($action, $model, $key, $index) {
//                                            if ($action === 'update') {
//                                                $url = 'update?id=' . $model->iUserId . '&type=customer';
//                                                return $url;
//                                            }
//                                            if ($action === 'delete') {
//                                                $url = 'delete?id=' . $model->iUserId . '&type=customer';
//                                                return $url;
//                                            }
//                                        }
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

