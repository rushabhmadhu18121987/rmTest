<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\AppSetting */

$this->title = 'Create App Setting';
$this->params['breadcrumbs'][] = ['label' => 'App Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-setting-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
