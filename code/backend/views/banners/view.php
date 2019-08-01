<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\BannerMaster */

$this->title = 'Banner Details';
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'banners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$context = $this->context;
?>
<div class="banners-view">

    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-6 pull-left">
                <p style="text-align: left">
                    <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
                </p>    

            </div>
            <div class="col-md-6 pull-right">
                <p style="text-align: right">
                    <?= Html::a('Update', ['update', 'id' => $model->iBannerId], ['class' => 'btn btn-primary']) ?>
                    <?=
                    Html::a('Delete', ['delete', 'id' => $model->iBannerId], [
                        'class' => 'btn btn-danger',
                        'data' => ['confirm' => 'Are you sure you want to delete this category?',
                            'method' => 'post',],
                    ]);
                    ?> 
                </p>
            </div>
        </div> 
        <div class="row">
            <section class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= ucfirst($this->title); ?></h3>
                        <div class="box-tools pull-right">
                            <!--<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>-->                
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">  
                        <?=
                        DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                'vTitle',
                                'tiOrderNo',
                                [
                                    'attribute' => 'tiBannerType',
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        if ($model->tiBannerType == 1) {
                                            return 'Business';
                                        } elseif ($model->tiBannerType == 2) {
                                            return 'Event';
                                        } else {
                                            return 'Default';
                                        }
                                    }
                                ],
                                [
                                    'attribute' => 'vBannerPic',
                                    'value' => function ($model) {
                                        if (!empty($model->vBannerPic)) {
                                            return Yii::$app->params['BANNER_URL'] . $model->iBannerId . "/" . $model->vBannerPic;
                                        } else {
                                            return Yii::$app->params['DEFAULT_BANNER_URL'];
                                        }
                                    },
                                    'format' => ['image', ['height' => '150']],
                                ],
                                [
                                    'attribute' => 'iCreatedAt',
                                    'value' => function ($model) use ($context) {
                                        return Carbon\Carbon::createFromTimestamp($model->iCreatedAt)->setTimezone($context->timezone)->format($context->datetimeFormat);
                                    }
                                ],
                                [
                                    'attribute' => 'iUpdatedAt',
                                    'value' => function ($model) use ($context) {
                                        return !empty($model->iUpdatedAt) ? Carbon\Carbon::createFromTimestamp($model->iUpdatedAt)->setTimezone($context->timezone)->format($context->datetimeFormat) : '';
                                    }
                                ],
                            ],
                        ])
                        ?>
                    </div>
                </div>
            </section>
        </div>
    </section>
</div>
