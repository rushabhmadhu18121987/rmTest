<?php

use yii\helpers\Html;
use kartik\grid\GridView;

//use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ContentPagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Content Management';
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
                </div>
                <!-- /.box-header -->
                <div class="box-body">    <?php
                    $gridColumns = [
                        [
                            'class' => 'kartik\grid\SerialColumn',
                            'width' => '10%',
                            'header' => 'No',
                            'headerOptions' => ['style' => 'color:#337ab7;', 'class' => 'kartik-sheet-style'],
                            'contentOptions' => ['class' => 'kartik-sheet-style']
                        ],
                        [
                            'attribute' => 'vPageName',
                            'vAlign' => 'middle',
                            'width' => '75%',
                        ],
                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'header' => "Action",
                            'options' => ['width' => '15%'],
                            'dropdown' => false,
                            'vAlign' => 'middle',
                            'headerOptions' => ['style' => 'color:#337ab7;', 'width' => '10%', 'class' => 'text-center'],
                            'options' => ['class' => 'text-center'],
                            'template' => '{view}{update}', //
                            'buttons' => [
                                'view' => function ($url, $model) {
                                    return Html::a('<span class="btn btn-xs btn-default" style="margin-right:5%;"><span class="glyphicon glyphicon-eye-open"></span></span>', $url, [
                                                'title' => Yii::t('app', 'view'),
                                    ]);
                                },
                                'update' => function ($url, $model) {
                                    return Html::a('<span class="btn btn-xs btn-warning" style="margin-right:5%;"><span class="glyphicon glyphicon-pencil"></span></span>', ['update?id=' . $model->iPageId], ['title' => 'Update page', 'id' => $model->iPageId,]);
                                },
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
                        'toolbar' => [
                            ['content' => Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['./content-pages'], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => 'Reset Grid'])],
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
                            'type' => GridView::TYPE_DEFAULT,
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


<!--delete-modal -->
<!--                <div class="modal fade" id="delete-page" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-danger">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title">Delete page</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="delete_iPageId" value="" />
                                <input type="hidden" id="delete_url" value="" />
                                <p style="font-size: 15px;">Are you sure you want to delete the page?</p>
                            </div>
                            <div class="modal-footer">
                                <a href="javascript:void(0)" id="delete-record" type="button" class="btn btn-danger">Yes</a>
                                <a href="" type="button" class="btn btn-info" data-dismiss="modal">No</a>
                            </div>
                        </div>
                    </div>
                </div>-->
<!--delete-modal -->

<?php
//                $js = '
//        $(document).ready(function() {
//           // $(".flash-msg").animate({opacity: 1.0}, 3000).fadeOut("slow");
//        });
//        
//        $(document).on("click", ".delete-grid-row", function() {
//            //alert("call");
//            $("#delete_iPageId").val($(this).prop("id"));
//            $("#delete_url").val($(this).attr("href"));
//            $("#delete-page").modal("show");
//            return false;
//        });
//
//        
////        $(document).on("click", "#delete-record", function() {
////            var baseUrl = $("#delete_url").val();
////            $.ajax({
////                type: "POST",
////                url: baseUrl,
////                dataType: "json",
////                data: { iArtistId:$("#delete_iPageId").val() },
////                success: function (data) {
////                    if (data.response_status == 200) {
////                        $(\'tr[data-key="\'+$("#delete_iPageId").val()+\'"]\').remove();
////                        $("#delete-page").modal("hide");
////                    } else if (data.status == 400) {
////                        
////                    }
////                }
////            });
////        });
//
//
//    ';
//                $this->registerJs($js, \yii\web\View::POS_END);
//                ?>