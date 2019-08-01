<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\UserMaster */

$this->title = Yii::t('app', 'Update ' . Yii::t('admin', 'user-master') . ' : {nameAttribute}', [
            'nameAttribute' => $model->vFirstName . ' ' . $model->vLastName,
        ]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'user-master'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->iUserId, 'url' => ['view', 'id' => $model->iUserId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-master-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
