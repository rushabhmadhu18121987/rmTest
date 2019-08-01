<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BusinessProvider */

$this->title = Yii::t('admin', 'Update Business Provider: {name}', [
    'name' => $model->iUserId,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'business-provider'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->iUserId, 'url' => ['view', 'id' => $model->iUserId]];
$this->params['breadcrumbs'][] = Yii::t('admin', 'Update');
?>
<div class="business-provider-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
