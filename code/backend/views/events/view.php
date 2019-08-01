<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\EventMaster */

$this->title = 'Event Details';
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'events'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$eventTickets = $model->eventTickets;
$eventPhotos = $model->eventPhotos;
$formatter = Yii::$app->formatter;
?>
<section class="content container-fluid">
    <div class="row">        
        <section class="col-md-12">
            <div class="row">
                <div class="col-md-6 pull-left">
                    <p style="text-align: left">
                        <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
                    </p>   
                </div>
                <div class="col-md-6 pull-right">
                    <p style="text-align: right">
                        <?=
                        Html::a('Delete', ['delete', 'id' => $model->iEventId], [
                            'class' => 'btn btn-danger',
                            'data' => ['confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',],
                        ]);
                        ?> 
                    </p>
                </div>
            </div>  
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= ucfirst($this->title); ?></h3>
                    <div class="box-tools pull-right">
                        <!--<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>-->                
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Event Information</h3>
                        </div>
                        <div class="col-md-12">
                            <?=
                            DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    [
                                        'attribute' => 'vTitle',
                                        'value' => function ($model) {
                                            return !empty($model->vTitle) ? (json_decode('"' . $model->vTitle . '"')) : 'N/A';
                                        }
                                    ],
                                    [
                                        'attribute' => 'vCategoryName',
                                        'value' => function ($model) {
                                            return !empty($model->iCategory->vCategoryName) ? (json_decode('"' . $model->iCategory->vCategoryName . '"')) : 'N/A';
                                        }
                                    ],
                                    [
                                        'attribute' => 'dStartDt',
                                        'format' => !empty($model->dStartDt) ? ('date') : 'raw',
                                        'value' => function ($model) {
                                            return !empty($model->dStartDt) ? ($model->dStartDt) : 'N/A';
                                        },
                                    ],
                                    [
                                        'attribute' => 'dExpireDt',
                                        'value' => function ($model) {
                                            return !empty($model->dExpireDt) ? ($model->dExpireDt) : 'N/A';
                                        },
                                    ],
                                    [
                                        'attribute' => 'txDescription',
                                        'format' => 'ntext',
                                        'value' => function ($model) {
                                            return !empty($model->txDescription) ? (json_decode('"' . $model->txDescription . '"')) : 'N/A';
                                        }
                                    ],
                                ],
                            ])
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Event Location</h3>
                        </div>
                        <div class="col-md-12">
                            <?=
                            DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    [
                                        'attribute' => 'vAddress',
                                        'value' => function ($model) {
                                            return !empty($model->vAddress1) ? (json_decode('"' . $model->vAddress1 . '"') . ', ' . json_decode('"' . $model->vAddress2 . '"')) : 'N/A';
                                        },
                                    ],
                                    [
                                        'attribute' => 'vCity',
                                        'value' => function ($model) {
                                            return !empty($model->vCity) ? (json_decode('"' . $model->vCity . '"')) : 'N/A';
                                        }
                                    ],
                                    [
                                        'attribute' => 'vZipcode',
                                        'value' => function ($model) {
                                            return $model->vZipcode ?? 'N/A';
                                        },
                                    ],
                                ],
                            ])
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Ticket Information</h3>
                        </div>
                        <div class="col-md-12">
                            <table class="kv-grid-table table table-hover table-bordered table-striped table-condensed kv-table-wrap">
                                <thead>
                                    <tr>
                                        <th class="kartik-sheet-style kv-align-center kv-align-middle kv-merged-header" rowspan="2" data-col-seq="0">#</th>
                                        <th style="width: 25%;" data-col-seq="1"> <?= Yii::t('admin', 'ticket-type') ?> </th>
                                        <th style="width: 15%;" data-col-seq="2"> <?= Yii::t('admin', 'ticket-price') ?> </th> 
                                        <th style="width: 15%;" data-col-seq="3"> <?= Yii::t('admin', 'total-ticket') ?> </th> 
                                        <th style="width: 45%;" data-col-seq="4"> <?= Yii::t('admin', 'ticket-info') ?> </th> 
                                    </tr> 
                                </thead>
                                <tbody>
                                    <?php
                                    if ($eventTickets):
                                        foreach ($eventTickets as $key => $each):
                                            if ($each->iEventTicketId):
                                                ?>
                                                <tr data-key="<?= $key ?>">
                                                    <td class="kartik-sheet-style kv-align-center kv-align-middle" style="width:5%;" data-col-seq="0"><?= $key + 1; ?></td>
                                                    <td style="width:25%;" data-col-seq="1"> <?= $each->vTicketType ?? 'N/A' ?> </td>    
                                                    <td style="width:15%;" data-col-seq="2"> <?= $formatter->asCurrency($each->fPrice ?? '0', $each->vCurrencyType ?? 'USD') ?> </td>    
                                                    <td style="width:15%;" data-col-seq="3"> <?= $each->iTotalTicket ?? 0 ?> </td>    
                                                    <td style="width:45%;" data-col-seq="4"> <?= $formatter->asNtext(!empty($each->txTicketInfo) ? (json_decode('"' . $each->txTicketInfo . '"')) : 'N/A' ?? 'N/A') ?> </td>    
                                                </tr>
                                                <?php
                                            endif;
                                        endforeach;
                                    endif;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h3><?= Yii::t('admin', 'event-photos') ?></h3>
                        </div>
                        <div class="col-md-12">
                            <?php
                            $items = [];
                            $items[] = [
                                'url' => Yii::$app->params['EVENT_URL'] . $model->iUserId . "/" . $model->vBannerPic,
                                'src' => Yii::$app->params['EVENT_URL'] . $model->iUserId . "/" . $model->vBannerPic,
                                'options' => []
                            ];
                            if (!empty($eventPhotos)) {
                                foreach ($eventPhotos as $key => $image) {
                                    $items[] = [
                                        'url' => Yii::$app->params['EVENT_URL'] . $model->iUserId . "/" . $image->vMediaPic,
                                        'src' => Yii::$app->params['EVENT_URL'] . $model->iUserId . "/" . $image->vMediaPic,
                                        'options' => [],
                                        'imageOptions' => ['max-width' => '100px', 'max-height' => '100px',]
                                    ];
                                }
                            }
                            ?>
                            <?= dosamigos\gallery\Gallery::widget(['items' => $items]); ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>
