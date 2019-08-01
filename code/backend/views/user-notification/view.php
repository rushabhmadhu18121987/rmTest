<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\UserNotification */

$this->title = $model->vNotificationTitle;
$this->params['breadcrumbs'][] = ['label' => 'User Notifications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$context = $this->context;
?>
<div class="user-notification-view">

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
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'iUserNotificationId',
                            'iUserId',
                            'iVehicleId',
                            'iParkingSpotId',
                            'iParkingLotId',
                            'iUserBookingId',
                            'vNotificationTitle',
                            'vNotificationDesc',
                            'tiNotificationType',
                            'tiIsRead',
                            'tiIsDeleted',
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
</div>
