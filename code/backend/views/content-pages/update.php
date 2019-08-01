<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ContentPages */

$this->title = 'Update Content Management';
$this->params['breadcrumbs'][] = ['label' => 'Content Management', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->iPageId, 'url' => ['view', 'id' => $model->iPageId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pages-update">

<!--    <h1><?php //Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
