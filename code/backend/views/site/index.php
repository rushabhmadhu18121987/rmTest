<?php

use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use dosamigos\chartjs\ChartJs;
use kartik\date\DatePicker;

$formatter = \Yii::$app->formatter;
$this->title = 'Dashboard';
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Dashboard</h1>
</section>

<!-- Main content -->
<section class="content container-fluid">
    <div class="row clsTotalCount">
        <div class="col-lg-4 col-xl-4 col-md-6 col-sm-12 col-12">
            <div class="card card-box">
                <div class="card-body ">
                    <div class="row dashboardblock">
                        <div class="iconblock"> <i style="    background-color: #ff9900;"class="fa fa-users" aria-hidden="true"></i> </div>
                        <div class="dmain_block">
                            <div style="color: #ff9900;" class="title_blue">  <?= $userMasterCount ?? '0'; ?></div>
                            <div class="desc">
                                <p> <?= Yii::t('admin', 'user-master') ?> </p>
                            </div>
                        </div>
                    </div>
                    <a href="<?php echo Url::to(['./user-master']); ?>" style="float:right;margin: -27px 0;">
                        <span class="moreinfo">More Info </span>
                        <span><i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-xl-4 col-md-6 col-sm-12 col-12">
            <div class="card card-box">
                <div class="card-body ">
                    <div class="row dashboardblock">
                        <div class="iconblock"> <i style="    background-color: #009900;"class="fa fa-users" aria-hidden="true"></i> </div>
                        <div class="dmain_block">
                            <div style="color: #009900;" class="title_blue">  <?= $vendorMasterCount ?? '0'; ?></div>
                            <div class="desc">
                                <p> <?= Yii::t('admin', 'vendor') ?> </p>
                            </div>
                        </div>
                    </div>
                    <a href="<?php echo Url::to(['./vendor-master']); ?>" style="float:right;margin: -27px 0;">
                        <span class="moreinfo">More Info </span>
                        <span><i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>
                    </a>
                </div>
            </div>
            
        </div>
    </div>
</section>
<!-- /.content --> 