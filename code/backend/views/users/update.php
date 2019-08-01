<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Users */

$this->title = 'Update User';
$this->params['breadcrumbs'][] = ['label' => 'user-master', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="users-update">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><?= $this->title ?></h1>
    </section>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
