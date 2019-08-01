<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\VendorMaster */

$this->title = 'Create Vendor';
$this->params['breadcrumbs'][] = ['label' => 'Vendor', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vendor-master-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
