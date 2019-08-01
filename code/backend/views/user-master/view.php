<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\UserMaster */

$this->title = $model->iUserId;
$this->params['breadcrumbs'][] = ['label' => 'User Masters', 'url' => ['index']];
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
                <?= Html::a('Update', ['update', 'id' => $model->iUserId], ['class' => 'btn btn-primary']) ?>
                <?=
                Html::a('Delete', ['delete', 'id' => $model->iUserId], [
                    'class' => 'btn btn-danger',
                    'data' => ['confirm' => 'Are you sure you want to delete this user?',
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

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'iUserId',
                            'vFirstName',
                            'vLastName',
                            'vEmail:email',
                            'vMobileNumber',
                            // 'vPassword',                            
                            [
                                'attribute' => 'vProfilePic',
                                'format' => ['image', ['width' => '150', 'height' => '150']],                                
                                'value' => function ($model) {
                                    return Yii::$app->params['BASE_URL']."/backend/uploads/users/".$model->vProfilePic;
                                }
                            ], 
                            // 'tiIsSocialLogin',
                            [
                                'attribute' => 'tiIsSocialLogin',
                                'value' => function ($model) use ($data) {
                                    return ($model->tiIsSocialLogin == 0)?'No':'Yes';
                                }
                            ], 
                            'dbLatitude',
                            'dbLogitude',
                            'vOTP',                            
                            [
                                'attribute' => 'iOTPExpireAt',
                                'value' => function ($model) use ($context) {       
                                    if(!empty($model->iOTPExpireAt)){                             
                                        return Carbon\Carbon::createFromTimestamp($model->iOTPExpireAt)->setTimezone($context->timezone)->format($context->datetimeFormat);
                                    }else{
                                        return false;
                                    }
                                }
                            ],
                            'tiIsMobileVerified',
                            'vEjabberedId',
                            // 'vPasswordResetToken',
                            // 'iNotiBadgeCount',                            
                            [
                                'attribute' => 'tiAcceptPush',
                                'value' => function ($model) use ($data) {
                                    return ($model->tiAcceptPush == 0)?'No':'Yes';
                                }
                            ],                            
                            [
                                'attribute' => 'tiAcceptEmail',
                                'value' => function ($model) use ($data) {
                                    return ($model->tiAcceptEmail == 0)?'No':'Yes';
                                }
                            ],                            
                            [
                                'attribute' => 'tiAcceptSMS',
                                'value' => function ($model) use ($data) {
                                    return ($model->tiAcceptSMS == 0)?'No':'Yes';
                                }
                            ],
                            [
                                'attribute' => 'tiIsActive',
                                'value' => function ($model) use ($data) {
                                    return ($model->tiIsActive == 0)?'No':'Yes';
                                }
                            ],
                            [
                                'attribute' => 'tiIsDeleted',
                                'value' => function ($model) use ($data) {
                                    return ($model->tiIsDeleted == 0)?'No':'Yes';
                                }
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
                    ]) ?>
                </div>
            </div>
        </section>
    </div>
</section>

