<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ContactUs */

$this->title = Yii::t('admin', 'Update Contact Us: {name}', [
    'name' => $model->iContactId,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'Contact uses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->iContactId, 'url' => ['view', 'id' => $model->iContactId]];
$this->params['breadcrumbs'][] = Yii::t('admin', 'Update');
?>
<div class="contact-us-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
