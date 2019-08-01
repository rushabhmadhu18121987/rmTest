<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CategoryMaster */

$this->title = Yii::t('admin', 'Update Category Master: {name}', [
    'name' => $model->iCategoryId,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'category-master'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('admin', 'Update');
?>
<div class="category-master-update">
    <?= $this->render('_form', $this->context->data) ?>
</div>
