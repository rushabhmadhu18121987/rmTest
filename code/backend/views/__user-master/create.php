<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\UserMaster */

$this->title = 'Create User';
$this->params['breadcrumbs'][] = ['label' => 'User Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-master-create">

    <section class="container-fluid">
        <h3><?= Html::encode($this->title) ?></h3>
    </section>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
