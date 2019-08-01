<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UserMaster */

$this->title = 'Update User Master: ' . $model->iUserId;
$this->params['breadcrumbs'][] = ['label' => 'User Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->iUserId, 'url' => ['view', 'id' => $model->iUserId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-master-update">

    <!-- <h1>= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
