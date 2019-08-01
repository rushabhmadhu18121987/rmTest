<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<div style="max-width:800px!important;padding:4px">
    <table style="padding:0 45px;width:100%!important;padding-top:45px;border:1px solid #f0f0f0;background-color:#ffffff" border="0" align="center" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td align="center">
                    <table border="0" width="100%" cellspacing="0">
                        <tbody>
                            <tr>
                                <td style="font-size:0px;text-align:center" valign="top"><img  style="width: 30%;" src="<?= Yii::$app->params['LOGO_URL'] ?>" alt="App Way Park"></td>
                            </tr>
                        </tbody>
                    </table>
                    <table border="0" width="100%" cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr style="font-size:16px;font-weight:300;color:#404040;font-family:'Open Sans','HelveticaNeue-Light','Helvetica Neue Light','Helvetica Neue',Helvetica,Arial,'Lucida Grande',sans-serif;line-height:26px;text-align:left">
                                <td>
                                    <br>
                                    <br>Hi <?= Html::encode(!empty($user->username) ? $user->username : 'user') ?>, 
                                    <br><br>
                                    Someone recently requested a password change for your <?= \Yii::$app->name ?> account. If this was you, you can set a new password here: 
                                    <br>

                        <br><center><a style="border-radius:4px;font-size:16px;color:white;text-decoration:none;padding:14px 7px 14px 7px;width:210px;max-width:210px;font-family:'Open Sans','Helvetica Neue',Arial;margin:0;display:block;background-color:#00c0ef;text-align:center" href="<?= $resetLink; ?>">Reset password</a></center>
                        <br>
                        If you don't want to change your password or didn't request this, just ignore and delete this message. <br><br>
                        To keep your account secure, please don't forward this email to anyone.<br><br>

                        Thank You!  <br>
                        <b><?= \Yii::$app->name ?></b> Team

            </tr>
            <tr>
                <td height="40"></td>
            </tr>
        </tbody>
    </table>
</td>
</tr>
</tbody>
</table>
</div>