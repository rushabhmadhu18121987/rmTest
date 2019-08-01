<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AppSetting */

$this->title = 'Update App Setting';
$this->params['breadcrumbs'][] = ['label' => 'App Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->vSettingLabel, 'url' => ['view', 'id' => $model->iAppSettingId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="app-setting-update">

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
