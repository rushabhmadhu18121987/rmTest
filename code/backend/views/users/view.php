<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Users */

$this->title = $model->vFirstName . ' ' . $model->vLastName . '\'s Details';
$this->params['breadcrumbs'][] = ['label' => 'user-master', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> <?= $model->vFirstName . ' ' . $model->vLastName ?>'s Details </h1>
</section>

<div class="clearfix">&nbsp;</div>

<div class="col-lg-3 col-xs-12"> 
    <!-- small box -->
    <div class="small-box bg-white">
        <div class="inner">
            <div class="row">
                <div class="col-sm-6">
                    <h3><?= number_format($model->fTotBalance, 2) . ' USD' ?></h3>
                    <p>Total Balance</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-3 col-xs-12"> 
    <!-- small box -->
    <div class="small-box bg-white">
        <div class="inner">
            <div class="row">
                <div class="col-sm-6">
                    <h3><?= $model->tipsFromCount ?></h3>
                    <p>Total Sent Tips</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-3 col-xs-12"> 
    <!-- small box -->
    <div class="small-box bg-white">
        <div class="inner">
            <div class="row">
                <div class="col-sm-6">
                    <h3><?= $model->tipsToCount ?></h3>
                    <p>Total Receive Tips</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="clearfix">&nbsp;</div>

<!-- Main content -->
<section class="content container-fluid">
    <div class="nav-tabs-custom min-height-500">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#profile" data-toggle="tab">Profile</a></li>
            <!--            <li><a href="#senttips" data-toggle="tab">Sent Tips</a></li>
                        <li><a href="#receivetips" data-toggle="tab">Receive Tips</a></li>-->
        </ul>
        <div class="tab-content">
            <div class="active tab-pane " id="profile">
                <div class="col-xs-12">
<!--                    <h1 class="font18 m0"><strong>Personal</strong></h1>-->
                    <p></p>
                    <div class="row">
                        <div class="col-md-8" style="margin-bottom:2%;">
                            <img src="<?= (!empty($model->vProfilePic)) ? (Yii::$app->params['profilePic_url'] . $model->iUserId . '/' . $model->vProfilePic) : Yii::$app->params['defaultProfPic_url'] ?>" style="max-height: 150px;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"><strong class="mr10">Recipient Id:</strong> </div>
                        <div class="col-md-8"><p><?= $model->vRecipientId ?></p></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"><strong class="mr10">Email Id:</strong> </div>
                        <div class="col-md-8"><p><?= $model->vEmail ?></p></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"><strong class="mr10">First Name:</strong> </div>
                        <div class="col-md-8"><p><?= $model->vFirstName ?></p></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"><strong class="mr10">Last Name:</strong> </div>
                        <div class="col-md-8"><p><?= $model->vLastName ?></p></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"><strong class="mr10">Language:</strong> </div>
                        <div class="col-md-8"><p><?= ($model->tiLanguage == 1) ? 'English' : 'Spanish' ?></p></div>
                    </div>

                </div>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="senttips">
                <div class="col-xs-12">
                    <h1 class="font18 m0"><strong>Vehicle Details</strong></h1>
                    <p></p>
                    <div class="row">
                        <div class="col-md-6 col-lg-4"> <img src="dist/img/photo1.png" width="100%" alt="" /> </div>
                        <div class="col-md-6 col-lg-8">
                            <div class="row">
                                <div class="col-md-4"><strong class="mr10">Vehicle Name:</strong> </div>
                                <div class="col-md-8">
                                    <p>Cargo Truck</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"><strong class="mr10">Vehicle Company:</strong> </div>
                                <div class="col-md-8">
                                    <p>TATA</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"><strong class="mr10">Vehicle Model:</strong> </div>
                                <div class="col-md-8">
                                    <p>Cargo LXi</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"><strong class="mr10">Vehicle Year:</strong> </div>
                                <div class="col-md-8">
                                    <p>2015</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"><strong class="mr10">Vehicle Plant #:</strong> </div>
                                <div class="col-md-8">
                                    <p>XZ 1525</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix">&nbsp;</div>
            </div>
            <!-- /.tab-pane -->

            <div class="tab-pane" id="receivetips">
                <div class="col-xs-12">
                    <h1 class="font18 m0"><strong>License Details</strong></h1>
                    <p></p>
                    <div class="row">
                        <div class="col-md-6 col-lg-4"> <img src="dist/img/photo2.png" width="100%" alt="" /> </div>
                        <div class="col-md-6 col-lg-8">
                            <div class="row">
                                <div class="col-md-4"><strong class="mr10">License Name:</strong> </div>
                                <div class="col-md-8">
                                    <p>John Smith</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"><strong class="mr10">License Number:</strong> </div>
                                <div class="col-md-8">
                                    <p>D5F2858004</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"><strong class="mr10">Issue Date:</strong> </div>
                                <div class="col-md-8">
                                    <p>25/12/2005</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"><strong class="mr10">Expiry Date:</strong> </div>
                                <div class="col-md-8">
                                    <p>2020</p>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
                <div class="clearfix">&nbsp;</div>							
            </div>
            <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content --> 
    </div>
    <!-- /.nav-tabs-custom --> 

</section>
<!-- /.content --> 