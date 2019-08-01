<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\VendorMaster */

$this->title = 'Update Vendor Master: ' . $model->iVendorId;
$this->params['breadcrumbs'][] = ['label' => 'Vendor Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->iVendorId, 'url' => ['view', 'id' => $model->iVendorId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vendor-master-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
