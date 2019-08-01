<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\BusinessTiming;

/* @var $this yii\web\View */
/* @var $model backend\models\EventPlanner */

$this->title = $model->vName . '\'s Details';
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'event-planner'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$context = $this->context;
$businessProfile = $model->businessMasters[0] ?? new backend\models\BusinessMaster();
$businessTimings = $businessProfile->businessTimings;
$businessPhotos = $businessProfile->businessPhotos;
$businessRatings = $businessProfile->businessRatings;
?>
<div class="event-planner-view">
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
                            Html::a('Delete', ['delete', 'id' => $model->iUserId], [
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
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#personalDetails" data-toggle="tab"><?= Yii::t('admin', 'personal-details') ?> </a></li>
                            <li><a href="#businessDetails" data-toggle="tab"> <?= Yii::t('admin', 'business-details') ?> </a></li>
                            <li><a href="#businessRatingDetails" data-toggle="tab"> <?= Yii::t('admin', 'business-rating-details') ?> </a></li>
                        </ul><br>
                        <div class="tab-content">

                            <div class="active tab-pane" id="personalDetails">
                                <?=
                                DetailView::widget([
                                    'model' => $model,
                                    'attributes' => [
                                        [
                                            'attribute' => 'vProfilePic',
                                            'value' => function ($model) {
                                                if (!empty($model->vProfilePic)) {
                                                    return Yii::$app->params['USER_PIC_URL'] . $model->vProfilePic;
                                                } else {
                                                    return Yii::$app->params['DEFAULT_IMAGE_URL'];
                                                }
                                            },
                                            'format' => (['image', ['width' => '150']]),
                                        ],
                                        [
                                            'attribute' => 'vName',
                                            'format' => 'html',
                                            'value' => function ($model) {
                                                return !empty($model->vName) ? (json_decode('"' . $model->vName . '"')) : 'N/A';
                                            }
                                        ],
                                        'vEmail:email',
                                        [
                                            'attribute' => 'vMobileNumber',
                                            'value' => function ($model) {
                                                return !empty($model->vMobileNumber) ? ($model->vISDCode . ' ' . $model->vMobileNumber) : 'N/A';
                                            },
                                        ],
                                        [
                                            'attribute' => 'vLangISOCode',
                                            'value' => function ($model) {
                                                return !empty($model->vLangISOCode) ? Locale::getDisplayLanguage($model->vLangISOCode) : 'N/A';
                                            },
                                        ],
                                    ],
                                ])
                                ?>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="businessDetails">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>Business Information</h3>
                                    </div>
                                    <div class="col-md-12">
                                        <?=
                                        DetailView::widget([
                                            'model' => $businessProfile,
                                            'attributes' => [
                                                [
                                                    'attribute' => 'vBusinessName',
                                                    'value' => function ($model) {
                                                        return !empty($model->vBusinessName) ? (json_decode('"' . $model->vBusinessName . '"')) : 'N/A';
                                                    },
                                                ],
                                                'vEmail:email',
                                                [
                                                    'attribute' => 'vMobileNumber',
                                                    'value' => function ($model) {
                                                        return !empty($model->vMobileNumber) ? ($model->vISDCode . ' ' . $model->vMobileNumber) : 'N/A';
                                                    },
                                                ],
                                                [
                                                    'attribute' => 'fAvgRating',
                                                    'format' => ['decimal', 1],
                                                    'value' => function ($model) {
                                                        return $model->fAvgRating ?? '0';
                                                    },
                                                ],
                                                [
                                                    'attribute' => 'iTotalEvent',
                                                    'value' => function ($businessProfile) use ($model) {
                                                        return $model->iTotalEvent ?? '0';
                                                    },
                                                ],
                                            ],
                                        ])
                                        ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>Address Information</h3>
                                    </div>
                                    <div class="col-md-12">
                                        <?=
                                        DetailView::widget([
                                            'model' => $businessProfile,
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
                                        <h3><?= Yii::t('admin', 'business-timing-details') ?></h3>
                                    </div>
                                    <div class="col-md-12">
                                        <table class="kv-grid-table table table-hover table-bordered table-striped table-condensed kv-table-wrap">
                                            <thead>
                                                <tr>
                                                    <th class="kartik-sheet-style kv-align-center kv-align-middle kv-merged-header" rowspan="2" data-col-seq="0">#</th>
                                                    <th style="width: 11.33%;" data-col-seq="1"> <?= Yii::t('admin', 'day-name') ?> </th>
                                                    <th style="width: 16.31%;" data-col-seq="2"> <?= Yii::t('admin', 'open-time') ?> </th> 
                                                    <th style="width: 16.31%;" data-col-seq="3"> <?= Yii::t('admin', 'close-time') ?> </th> 
                                                </tr> 
                                            </thead>
                                            <tbody>
                                                <?php
                                                // $k = 0;
                                                for ($i = 1; $i <= 7; $i++) {
                                                    if (!empty($businessTimings[$i - 1])) {
                                                        ?>
                                                        <tr data-key="<?= $key ?>">
                                                            <td class="kartik-sheet-style kv-align-center kv-align-middle" style="width:5%;" data-col-seq="0"><?= $i; ?></td>
                                                            <td style="width:10%;" data-col-seq="1"> <?= BusinessTiming::DAY_LIST[$i] ?> </td>    
                                                            <td style="width:15%;" data-col-seq="2"> <?= Carbon\Carbon::createFromTimestamp(strtotime($businessTimings[$i]->tOpenTime1))->setTimezone($context->timezone)->format($context->timeFormat); ?> </td>
                                                            <td style="width:15%;" data-col-seq="3"> <?= Carbon\Carbon::createFromTimestamp(strtotime($businessTimings[$i]->tCloseTime1))->setTimezone($context->timezone)->format($context->timeFormat); ?> </td>
                                                        </tr>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <tr data-key="<?= $key ?>">
                                                            <td class="kartik-sheet-style kv-align-center kv-align-middle" style="width:5%;" data-col-seq="0"><?= $i; ?></td>
                                                            <td style="width:10%;" data-col-seq="1"> <?= BusinessTiming::DAY_LIST[$i] ?> </td>    
                                                            <td style="width:10%;" data-col-seq="2" colspan="2"> Holiday </td>    
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                foreach (BusinessTiming::DAY_LIST as $key => $day_name) {
                                                    
                                                }
                                                if ($businessTimings):
                                                    foreach ($businessTimings as $key => $each):
                                                        if ($each->iBizTimeId):
                                                            ?>
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
                                        <h3>About Business</h3>
                                    </div>
                                    <div class="col-md-12">
                                        <?=
                                        DetailView::widget([
                                            'model' => $businessProfile,
                                            'attributes' => [
                                                [
                                                    'attribute' => 'vTagLine',
                                                    'format' => 'html',
                                                    'value' => function ($model) {
                                                        return !empty($model->vTagLine) ? (json_decode('"' . $model->vTagLine . '"')) : 'N/A';
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'txBriefDescription',
                                                    'format' => 'html',
                                                    'value' => function ($model) {
                                                        return !empty($model->txBriefDescription) ? (json_decode('"' . $model->txBriefDescription . '"')) : 'N/A';
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'txDescription',
                                                    'format' => 'html',
                                                    'value' => function ($model) {
                                                        return !empty($model->txDescription) ? (json_decode('"' . $model->txDescription . '"')) : 'N/A';
                                                    }
                                                ],
                                            ],
                                        ])
                                        ?>
                                    </div>
                                </div>
                                <?php if (!empty($businessPhotos) || !empty($businessProfile->vLogoPic)) : ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3><?= Yii::t('admin', 'business-photos') ?></h3>
                                        </div>
                                        <div class="col-md-12">
                                            <?php
                                            $items = [];
                                            $items[] = [
                                                'url' => Yii::$app->params['BUSINESS_URL'] . $model->iUserId . "/" . $businessProfile->vLogoPic,
                                                'src' => Yii::$app->params['BUSINESS_URL'] . $model->iUserId . "/" . $businessProfile->vLogoPic,
                                                'options' => []
                                            ];
                                            if (!empty($businessPhotos)) {
                                                foreach ($businessPhotos as $key => $image) {
                                                    $items[] = [
                                                        'url' => Yii::$app->params['BUSINESS_URL'] . $model->iUserId . "/" . $image->vMediaPic,
                                                        'src' => Yii::$app->params['BUSINESS_URL'] . $model->iUserId . "/" . $image->vMediaPic,
                                                        'options' => [],
                                                        'imageOptions' => ['max-width' => '100px', 'max-height' => '100px',]
                                                    ];
                                                }
                                            }
                                            ?>
                                            <?= dosamigos\gallery\Gallery::widget(['items' => $items]); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="businessRatingDetails">
                                <table class="kv-grid-table table table-hover table-bordered table-striped table-condensed kv-table-wrap">
                                    <thead>
                                        <tr>
                                            <th class="kartik-sheet-style kv-align-center kv-align-middle kv-merged-header" rowspan="2" data-col-seq="0">#</th>
                                            <th style="width: 11.33%;" data-col-seq="1"> <?= Yii::t('admin', 'user-name') ?> </th>
                                            <th style="width: 16.31%;" data-col-seq="2"> <?= Yii::t('admin', 'rating') ?> </th> 
                                            <th style="width: 16.31%;" data-col-seq="3"> <?= Yii::t('admin', 'review-text') ?> </th> 
                                        </tr> 
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($businessRatings)):
                                            foreach ($businessRatings as $key => $each):
                                                if ($each->iBusinessRatingId):
                                                    ?>
                                                    <tr data-key="<?= $key ?>">
                                                        <td class="kartik-sheet-style kv-align-center kv-align-middle" style="width:5%;" data-col-seq="0"><?= $key + 1; ?></td>
                                                        <td style="width:10%;" data-col-seq="1"> <?= $each->iUser->vName ?> </td>    
                                                        <td style="width:10%;" data-col-seq="2"> <?= $each->fRating ?> </td>    
                                                        <td style="width:10%;" data-col-seq="3"> <?= str_ireplace('\n', '<br/>', $each->txReview) ?> </td>    
                                                    </tr>
                                                    <?php
                                                endif;
                                            endforeach;
                                        else:
                                            ?>
                                            <tr data-key="<?= 0 ?>">
                                                <td style="width:10%;" data-col-seq="1" colspan=""> <?= Yii::t('admin', 'rating_not_available') ?> </td> 
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>

</div>
