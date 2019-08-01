<?php

/**

 * **********************************************************************
  Created By : Nakrani Sejal
  Created On : 5 April 2018
  Modified By:
  Purpose : reset password form
  Last Modified on:
  Modified Code:

 * ********************************************************************
 * */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Reset password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-box">

    <div class="login-box-body">  
        <h3><?= Html::encode($this->title) ?></h3>

        <p>Please Enter your new password:</p>

        <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
        <div class="form-group has-feedback">
            <?= $form->field($model, 'password')->passwordInput(['autofocus' => true])->label('New Password'); ?>
        </div>
        <div class="form-group has-feedback"> 
            <?= $form->field($model, 'confirm_password')->passwordInput(['autofocus' => true]) ?>
        </div>
        <div class="row">
            <div class="col-xs-12"> 
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?> 
            </div>  
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
