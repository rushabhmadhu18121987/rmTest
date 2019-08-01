<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UserMaster */

$this->title = 'Create User Master';
$this->params['breadcrumbs'][] = ['label' => 'User Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-master-create">

    <!-- <h1>= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
