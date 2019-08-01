<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Masters';
$this->params['breadcrumbs'][] = $this->title;
$layout = <<< HTML
        <div class="pull-right">{summary}</div> 
        <div class="clearfix"></div>
        {items}
        <div class="clearfix"></div>
        <div class="text-center">{pager}</div>
HTML;
?>
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
            
                <input type="file" name="user-csv" id="user-csv" />
                <input type="button" value="Upload" class="btn btn-success" id="user-import"/>
            
            <?=
                    GridView::widget([
                        'layout' => $layout,
                        'id' => "verified_artists_grid",
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'export' => false,
                        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                        'toolbar' => [
                            ['content' => Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['type' => 'button', 'title' => Yii::t('admin', 'create'), 'class' => 'btn btn-success']),],
                            ['content' => Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['./user-master'], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => 'Reset Grid'])],
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
                                'width' => '10%',
                                'header' => 'No',
                                'headerOptions' => ['style' => 'color:#337ab7;', 'class' => 'kartik-sheet-style'],
                                'contentOptions' => ['class' => 'kartik-sheet-style']
                            ],
                            // 'iUserId',
                            [
                                'attribute' => 'vFirstName',
                                'format' => 'raw',
                                'value' => function($model) { return $model->vFirstName  . " " . $model->vLastName ;}
                            ],
                            // 'vFirstName',
                            // 'vLastName',
                            'vEmail:email',
                            'vMobileNumber',
                            //'vPassword',
                            //'vProfilePic',
                            //'tiIsSocialLogin',
                            //'dbLatitude',
                            //'dbLogitude',
                            //'vOTP',
                            //'iOTPExpireAt',
                            //'tiIsMobileVerified',
                            //'vEjabberedId',
                            //'vPasswordResetToken',
                            //'iNotiBadgeCount',
                            //'tiAcceptPush',
                            //'tiAcceptEmail:email',
                            //'tiAcceptSMS',
                            //'tiIsActive',
                            //'tiIsDeleted',
                            //'iCreatedAt',
                            //'iUpdatedAt',
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
                                                        'confirm' => Yii::t('app', 'Are you sure you want to <span class="text-danger">Inactive</span> this ' . (Yii::t('admin', 'category-master-item')) . '?'),
                                                        'method' => 'post',
                                                    //'pjax' => true
                                                    ],
                                        ]);
                                    } else {
                                        return Html::a('Inactive', ['status-change', 'id' => $model->iUserId, 'type' => 1], [
                                                    'class' => 'btn btn-xs btn-danger',
                                                    'title' => Yii::t('app', 'Active'),
                                                    'data' => [
                                                        'confirm' => Yii::t('app', 'Are you sure you want to <span class="text-danger">Active</span> this ' . (Yii::t('admin', 'category-master-item')) . '?'),
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
                                'template' => '{view} {update} {delete}',
                                'buttons' => [
                                    'view' => function ($url, $model) {
                                        return Html::a('<span class="btn btn-xs btn-default" style="margin-right:5%;"><span class="glyphicon glyphicon-eye-open"></span></span>', ['view', 'id' => $model->iUserId], [
                                                    'title' => Yii::t('app', 'view'),
                                        ]);
                                    },
                                    'update' => function ($url, $model) {
                                        return Html::a('<span class="btn btn-xs btn-warning" style="margin-right:5%;"><span class="glyphicon glyphicon-pencil"></span></span>', ['update', 'id' => $model->iUserId], [
                                                    'title' => Yii::t('app', 'update'),
                                        ]);
                                    },
                                    'delete' => function ($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->iUserId], [
                                                    'class' => 'btn btn-xs btn-danger',
                                                    'title' => Yii::t('app', 'delete'),
                                                    'data' => [
                                                        'confirm' => Yii::t('app', 'Are you sure you want to delete this ' . (Yii::t('admin', 'category-master-item')) . '?'),
                                                        'method' => 'post',
                                                    ],
                                        ]);
                                    }
                                ],
                            ],
                        ],
                    ]);
                    ?>
                <!-- = GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        'iUserId',
                        'vFirstName',
                        'vLastName',
                        'vEmail:email',
                        'vMobileNumber',
                        //'vPassword',
                        //'vProfilePic',
                        //'tiIsSocialLogin',
                        //'dbLatitude',
                        //'dbLogitude',
                        //'vOTP',
                        //'iOTPExpireAt',
                        //'tiIsMobileVerified',
                        //'vEjabberedId',
                        //'vPasswordResetToken',
                        //'iNotiBadgeCount',
                        //'tiAcceptPush',
                        //'tiAcceptEmail:email',
                        //'tiAcceptSMS',
                        //'tiIsActive',
                        //'tiIsDeleted',
                        //'iCreatedAt',
                        //'iUpdatedAt',

                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?> -->
                    <!-- /.box-body -->
                </div>
            </div>
        </section>
    </div>
    <!-- /.row --> 
</section>
<?php
    $url = Yii::$app->params['BASE_URL']."backend/user-master/import-csv";
    // print_r($url);die;
    $this->registerJs("
        $(document).ready(function(){
            $('#user-import').click(function(){
                var fd = new FormData();
                fd.append('user-csv', this.user-csv[0]);
                // console.log(fd);
                // return false;   
                $.ajax({
                    url: '$url',
                    type: 'post',
                    dataType: 'json',
                    processData: false, // important
                    contentType: false, // important
                    data: fd,
                    success: function(text) {
                        // alert(text);
                        if(text == 'success') {
                            alert('Your image was uploaded successfully');
                        }
                    }
                    // ,
                    // error: function() {
                    //     alert('An error occured, please try again.');         
                    // }
                });
            });
        });
    ",\yii\web\View::POS_END);
?>