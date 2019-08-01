<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\EventPlanner */

$this->title = Yii::t('admin', 'Create Event Planner');
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Event Planners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-planner-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
