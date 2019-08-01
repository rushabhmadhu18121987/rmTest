<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CategoryMaster */

$this->title = Yii::t('admin', 'create-user');
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'category-master'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-master-create">
    <?= $this->render('_form', $this->context->data) ?>
</div>
