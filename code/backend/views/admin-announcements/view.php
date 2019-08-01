<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\AdminAnnouncements */

$this->title = 'Details';
$this->params['breadcrumbs'][] = ['label' => 'Admin Announcements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-announcements-view">
    <section class="content container-fluid"> 
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
                                'vMessage',
                                [
                                    'attribute' => 'tiNotificationReceiver',
                                    'value' => function ($model) {
                                        if ($model->tiNotificationReceiver == 1) {
                                            return "Customer";
                                        } elseif ($model->tiNotificationReceiver == 2) {
                                            return "Business Provider";
                                        } elseif ($model->tiNotificationReceiver == 3) {
                                            return "All Customer";
                                        } elseif ($model->tiNotificationReceiver == 4) {
                                            return "All Business Provider";
                                        } else {
                                            return "All Users";
                                        }
                                    },
                                ],
                                [
                                    'attribute' => 'adminAnnouncementReceivers ',
                                    'format' => 'html',
                                    'value' => function ($model) {
                                        if ($model->tiNotificationReceiver == 1 || $model->tiNotificationReceiver == 2) {
                                            return implode(', <br/>', ArrayHelper::getColumn($model->adminAnnouncementReceivers, 'iUser.vName'));
                                        } elseif ($model->tiNotificationReceiver == 3) {
                                            return "All Customer";
                                        } elseif ($model->tiNotificationReceiver == 4) {
                                            return "All Business Provider";
                                        } else {
                                            return "All Users";
                                        }
                                    },
                                ],
                                'iCreatedAt',
                            ],
                        ])
                        ?>
                    </div>
                </div>
            </section>
        </div>
    </section>


</div>
