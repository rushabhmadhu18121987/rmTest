<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ContactUsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('admin', 'contact-us');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-us-index">
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
                                ['content' => Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['./contact-us'], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => 'Reset Grid'])],
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
                            'panel' => [
                                'type' => GridView::TYPE_DEFAULT
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
                                    'attribute' => 'vName',
                                    'format' => 'email',
                                    'width' => '35%',
                                    'enableSorting' => TRUE,
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return !empty($model->vName) ? (json_decode('"' . $model->vName . '"')) : 'N/A';
                                    }
                                ],
                                [
                                    'attribute' => 'vEmail',
                                    'format' => 'email',
                                    'width' => '45%',
                                    'enableSorting' => TRUE,
                                    'format' => 'raw',
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
                                    'template' => '{view} {delete}',
                                    'buttons' => [
                                        'view' => function ($url, $model) {
                                            return Html::a('<span class="btn btn-xs btn-default" style="margin-right:5%;"><span class="glyphicon glyphicon-eye-open"></span></span>', ['view', 'id' => $model->iContactId], [
                                                        'title' => Yii::t('app', 'view'),
                                            ]);
                                        },
                                        'delete' => function ($url, $model) {
                                            if ($model->iContactId != 1) {
                                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->iContactId], [
                                                            'class' => 'btn btn-xs btn-danger',
                                                            'title' => Yii::t('app', 'delete'),
                                                            'data' => [
                                                                'confirm' => Yii::t('app', 'Are you sure you want to delete this ' . (Yii::t('admin', 'contact-us-item')) . '?'),
                                                                'method' => 'post',
                                                            ],
                                                ]);
                                            }
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
</div>
