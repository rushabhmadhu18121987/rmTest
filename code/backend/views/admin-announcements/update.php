<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AdminAnnouncements */

$this->title = 'Update Admin Announcements: ' . $model->iAnnouncementId;
$this->params['breadcrumbs'][] = ['label' => 'Admin Announcements', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->iAnnouncementId, 'url' => ['view', 'id' => $model->iAnnouncementId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="admin-announcements-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
