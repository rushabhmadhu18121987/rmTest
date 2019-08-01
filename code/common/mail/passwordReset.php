<?php

use yii\helpers\Html;
?>

<div style="max-width:800px!important;padding:4px">
    <table style="padding:0 45px;width:100%!important;padding-top:45px;border:1px solid #f0f0f0;background-color:#ffffff" border="0" align="center" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td align="center">
                    <table border="0" width="100%" cellspacing="0">
                        <tbody>
                            <tr>
                                <td style="font-size:0px;text-align:center" valign="top">
                                    <img  style="width: 30%;" src="<?= Yii::$app->params['LOGO_URL'] ?>" alt="The <?= \Yii::$app->name ?> logo" width="40px">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table border="0" width="100%" cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr style="font-size:16px;font-weight:300;color:#404040;font-family:'Open Sans','HelveticaNeue-Light','Helvetica Neue Light','Helvetica Neue',Helvetica,Arial,'Lucida Grande',sans-serif;line-height:26px;text-align:left">
                                <td>
                                    <br>
                                    <br>Hello <?= Html::encode(!empty($user['vName']) ? $user['vName'] : 'User') ?>,
                                    <br/><br>
                                    Now, You can login in the <?= \Yii::$app->name ?> application using below password: <b><?= $vPassword ?></b>
                                    <br>
                                    <br>
                                    This is a temporary password and will be valid for only 30 minutes and after 30 minutes it will automatically expire, So you have to change your password after successful login.
                                    <br>
                                    <br>
                                    To keep your account secure, please don't forward this email to anyone.<br><br>

                                    Thank You!  <br>
                                    <b><?= \Yii::$app->name ?></b> Team
                                </td>
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