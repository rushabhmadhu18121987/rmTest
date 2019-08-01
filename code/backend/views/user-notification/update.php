<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\UserNotification */

$this->title = 'Update User Notification: ' . $model->iUserNotificationId;
$this->params['breadcrumbs'][] = ['label' => 'User Notifications', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->iUserNotificationId, 'url' => ['view', 'id' => $model->iUserNotificationId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-notification-update">

    <?=
    $this->render('_form', ['model' => $model,]);
    ?>

</div>
