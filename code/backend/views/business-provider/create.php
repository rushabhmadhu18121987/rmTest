<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BusinessProvider */

$this->title = Yii::t('admin', 'Create Business Provider');
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'business-provider'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="business-provider-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
