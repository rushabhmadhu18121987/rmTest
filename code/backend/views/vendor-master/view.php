<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\CategoryMaster */

$this->title = 'Details';
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'vendor'), 'url' => ['index']];
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
                <?= Html::a('Update', ['update', 'id' => $model->iVendorId], ['class' => 'btn btn-primary']) ?>
                <?=
                Html::a('Delete', ['delete', 'id' => $model->iVendorId], [
                    'class' => 'btn btn-danger',
                    'data' => ['confirm' => 'Are you sure you want to delete this '.Yii::t('admin', 'vendor').'?',
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
                                'iVendorId',
                                'vEmail:email',
                                'vMobileNumber',
                                'vPassword',
                                'vProfilePic',
                                'vBusinessName',
                                'vWebsite',
                                'vCountry',
                                'vState',
                                'vCity',
                                'dbLatitude',
                                'dbLogitude',
                                'vEjabberedId',
                                'vStripeCustomerId',
                                'vStripeCardId',
                                'vSubscriptionId',
                                'vPasswordResetToken',
                                'iNotiBadgeCount',
                                [
                                    'attribute' => 'tiAcceptPush',
                                    'value' => function ($model) {
                                        if($model->tiAcceptPush == 1){
                                            return 'Yes';
                                        }
                                        else{
                                            return 'No';
                                        }
                                    }
                                ],
                                [
                                    'attribute' => 'tiAcceptEmail',
                                    'value' => function ($model) {
                                        if($model->tiAcceptEmail == 1){
                                            return 'Yes';
                                        }
                                        else{
                                            return 'No';
                                        }
                                    }
                                ],
                                [
                                    'attribute' => 'tiAcceptSMS',
                                    'value' => function ($model) {
                                        if($model->tiAcceptSMS == 1){
                                            return 'Yes';
                                        }
                                        else{
                                            return 'No';
                                        }
                                    }
                                ],
                                [
                                    'attribute' => 'tiVerificationStatus',
                                    'value' => function ($model) {
                                        if($model->tiVerificationStatus == 0){
                                            return 'Pending';
                                        }
                                        else if($model->tiVerificationStatus == 1){
                                            return 'Verified';
                                        }
                                        else{
                                            return 'Declined';
                                        }
                                    }
                                ],
                                [
                                    'attribute' => 'tiIsActive',
                                    'value' => function ($model) {
                                        if($model->tiIsActive == 1){
                                            return 'Active';
                                        }
                                        else{
                                            return 'Inactive';
                                        }
                                    }
                                ],
                                [
                                    'attribute' => 'tiIsDeleted',
                                    'value' => function ($model) {
                                        if($model->tiIsDeleted == 1){
                                            return 'Yes';
                                        }
                                        else{
                                            return 'No';
                                        }
                                    }
                                ],
                                [
                                    'attribute' => 'iCreatedAt',
                                    'value' => function ($model) {
                                        return date('Y-m-d H:i:s',$model->iCreatedAt);
                                    }
                                ],
                                [
                                    'attribute' => 'iUpdatedAt',
                                    'value' => function ($model) {
                                        return date('Y-m-d H:i:s',$model->iUpdatedAt);
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


