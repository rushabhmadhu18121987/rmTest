<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\CategoryMaster */

$this->title = 'Details';
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'category-master'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$context = $this->context;
?>
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-6 pull-left">
            <p style="text-align: left">
                <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
            </p>    

        </div>
        <div class="col-md-6 pull-right">
            <p style="text-align: right">
                <?= Html::a('Update', ['update', 'id' => $model->iCategoryId], ['class' => 'btn btn-primary']) ?>
                <?=
                Html::a('Delete', ['delete', 'id' => $model->iCategoryId], [
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
                                'vCategoryName',
                                'tiOrderNo',
                                [
                                    'attribute' => 'vCategoryIcon',
                                    'value' => function ($model) {
                                        if (!empty($model->vCategoryIcon)) {
                                            return Yii::$app->params['DEAL_PIC'] . $model->iCategoryId . "/" . $model->vCategoryIcon;
                                        } else {
                                            return Yii::$app->params['DEFAULT_DEAL_PIC'];
                                        }
                                    },
                                    'format' => ['image', ['width' => '150']],
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


