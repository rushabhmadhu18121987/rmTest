<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AdminAnnouncementsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-announcements-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'iAnnouncementId') ?>

    <?= $form->field($model, 'vSubject') ?>

    <?= $form->field($model, 'vMessage') ?>

    <?= $form->field($model, 'iCreatedAt') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
