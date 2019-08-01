<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\UnclaimedBusiness */

$this->title = Yii::t('admin', 'Create Unclaimed Business');
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'unclaimed-business'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unclaimed-business-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
