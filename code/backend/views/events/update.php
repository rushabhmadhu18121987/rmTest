<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\EventMaster */

$this->title = Yii::t('admin', 'Update Event Master: {name}', [
    'name' => $model->iEventId,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'events'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->iEventId, 'url' => ['view', 'id' => $model->iEventId]];
$this->params['breadcrumbs'][] = Yii::t('admin', 'Update');
?>
<div class="event-master-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
