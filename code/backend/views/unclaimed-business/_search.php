<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\UnclaimedBusinessSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="unclaimed-business-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'iBusinessId') ?>

    <?= $form->field($model, 'iUserId') ?>

    <?= $form->field($model, 'iCategoryId') ?>

    <?= $form->field($model, 'vBusinessName') ?>

    <?= $form->field($model, 'vSlug') ?>

    <?php // echo $form->field($model, 'vEmail') ?>

    <?php // echo $form->field($model, 'vISDCode') ?>

    <?php // echo $form->field($model, 'vMobileNumber') ?>

    <?php // echo $form->field($model, 'vAddress1') ?>

    <?php // echo $form->field($model, 'vAddress2') ?>

    <?php // echo $form->field($model, 'vCity') ?>

    <?php // echo $form->field($model, 'vZipcode') ?>

    <?php // echo $form->field($model, 'dbLatitude') ?>

    <?php // echo $form->field($model, 'dbLongitude') ?>

    <?php // echo $form->field($model, 'txBriefDescription') ?>

    <?php // echo $form->field($model, 'txDescription') ?>

    <?php // echo $form->field($model, 'vTagLine') ?>

    <?php // echo $form->field($model, 'vLogoPic') ?>

    <?php // echo $form->field($model, 'fAvgRating') ?>

    <?php // echo $form->field($model, 'iTotalRating') ?>

    <?php // echo $form->field($model, 'tiIsVerified') ?>

    <?php // echo $form->field($model, 'tiIsEventBusiness') ?>

    <?php // echo $form->field($model, 'tiIsAddedCustomer') ?>

    <?php // echo $form->field($model, 'tiIsActive') ?>

    <?php // echo $form->field($model, 'tiIsDeleted') ?>

    <?php // echo $form->field($model, 'iCreatedAt') ?>

    <?php // echo $form->field($model, 'iUpdatedAt') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('admin', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('admin', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
