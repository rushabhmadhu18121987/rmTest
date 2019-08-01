<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\UnclaimedBusiness */

$this->title = Yii::t('admin', 'Update Unclaimed Business: {name}', [
    'name' => $model->iBusinessId,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'unclaimed-business'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->iBusinessId, 'url' => ['view', 'id' => $model->iBusinessId]];
$this->params['breadcrumbs'][] = Yii::t('admin', 'Update');
?>
<div class="unclaimed-business-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
