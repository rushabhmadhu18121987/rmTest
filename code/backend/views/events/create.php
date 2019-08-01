<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\EventMaster */

$this->title = Yii::t('admin', 'Create Event Master');
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'events'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-master-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
