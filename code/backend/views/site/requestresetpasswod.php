<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model\backend\models\Passwordresetrequestform */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Forgot Password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-box">

    <div class="login-box-body">    
        <h3><?= Html::encode($this->title) ?></h3>

        <p>Please fill out your email. A link to reset password will be sent there.</p>
        <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
        <div class="form-group has-feedback">
            <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <?= Html::submitButton('Send', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?> 
    </div>
</div>
<!--</div>-->
