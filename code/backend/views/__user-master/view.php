<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Users */

$this->title = $model->vName . '\'s Details';
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'user-master'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$context = $this->context;
?>
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-6 pull-left">
            <p style="text-align: left">
                <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
            </p> 
        </div>
    </div>  
    <div class="row">
        <section class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= ucfirst($this->title); ?></h3>
                </div>
                <div class="box-body">
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
                                'attribute' => 'dDOB',
                                'value' => function ($model) {
                                    return $model->tiGender ?? 'N/A';
                                },
                            ],
                            [
                                'attribute' => 'tiGender',
                                'value' => function ($model) {
                                    return ($model->tiGender == 1) ? ('Male') : ( ($model->tiGender == 2) ? ('Female') : ('Other'));
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
            </div>
        </section>
    </div>
</section>