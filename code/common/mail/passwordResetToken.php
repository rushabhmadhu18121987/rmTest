<?php

use yii\helpers\Html;

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['../reset-password', 'token' => $token]);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width">
            <meta name="HandheldFriendly" content="true" />
            <meta http-equiv="X-UA-Compatible" content="IE=edge" />
            <!--[if gte IE 7]><html class="ie8plus" xmlns="http://www.w3.org/1999/xhtml"><![endif]-->
            <!--[if IEMobile]><html class="ie8plus" xmlns="http://www.w3.org/1999/xhtml"><![endif]-->
            <meta name="format-detection" content="telephone=no">
                <meta name="generator" content="EDMdesigner, www.edmdesigner.com">

                    <link href="https://fonts.googleapis.com/css?family=Roboto:300" rel="stylesheet"> 

                        <style>
                            @import url('https://fonts.googleapis.com/css?family=Roboto:300');
                        </style> 

                        <style type="text/css" media="screen">
                            * {line-height: inherit;}
                            .ExternalClass * { line-height: 100%; }
                            body, p{margin:0; padding:0; margin-bottom:0; -webkit-text-size-adjust:none; -ms-text-size-adjust:none;} img{line-height:100%; outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;} a img{border: none;} #backgroundTable {margin:0; padding:0; width:100% !important; } a, a:link, .no-detect-local a, .appleLinks a{color:#5555ff !important; text-decoration: underline;} .ExternalClass {display: block !important; width:100%;} .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div { line-height: inherit; } table td {border-collapse:collapse;mso-table-lspace: 0pt; mso-table-rspace: 0pt;} sup{position: relative; top: 4px; line-height:7px !important;font-size:11px !important;} .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {text-decoration: default; color: #5555ff !important; pointer-events: auto; cursor: default;} .no-detect a{text-decoration: none; color: #5555ff; pointer-events: auto; cursor: default;}
                            .nounderline {text-decoration: none !important;}
                            h1, h2, h3 { margin:0; padding:0; }
                            p {Margin: 0px !important; }

                            table[class="email-root-wrapper"] { width: 600px !important; }

                            body {
                                background-color: #e3e3e3;
                                background: #e3e3e3;
                            }
                            body { min-width: 280px; width: 100%;}
                            td[class="pattern"] .c72p14r { width: 14.423076923076918%;}
                            td[class="pattern"] .c204p40r { width: 40.976923076923086%;}
                            td[class="pattern"] .c76p15r { width: 15.223076923076894%;}
                            td[class="pattern"] .c146p29r { width: 29.376923076923113%;}

                        </style>
                        <style>
                            @media only screen and (max-width: 599px),
                            only screen and (max-device-width: 599px),
                            only screen and (max-width: 400px),
                            only screen and (max-device-width: 400px) {
                                .email-root-wrapper { width: 100% !important; }
                                .full-width { width: 100% !important; height: auto !important; text-align:center;}
                                .fullwidthhalfleft {width:100% !important;}
                                .fullwidthhalfright {width:100% !important;}
                                .fullwidthhalfinner {width:100% !important; margin: 0 auto !important; float: none !important; margin-left: auto !important; margin-right: auto !important; clear:both !important; }
                                .hide { display:none !important; width:0px !important;height:0px !important; overflow:hidden; }
                                .desktop-hide { display:block !important; width:100% !important;height:auto !important; overflow:hidden; max-height: inherit !important; }
                                .c72p14r { width: 100% !important; float:none;}
                                .c204p40r { width: 100% !important; float:none;}
                                .c76p15r { width: 100% !important; float:none;}
                                .c146p29r { width: 100% !important; float:none;}

                            }
                        </style>
                        <style>
                            @media only screen and (min-width: 600px) {
                                td[class="pattern"] .c72p14r { width: 72px !important;}
                                td[class="pattern"] .c204p40r { width: 204px !important;}
                                td[class="pattern"] .c76p15r { width: 76px !important;}
                                td[class="pattern"] .c146p29r { width: 146px !important;}

                            }
                            @media only screen and (max-width: 599px),
                            only screen and (max-device-width: 599px),
                            only screen and (max-width: 400px),
                            only screen and (max-device-width: 400px) {
                                table[class="email-root-wrapper"] { width: 100% !important; }
                                td[class="wrap"] .full-width { width: 100% !important; height: auto !important;}

                                td[class="wrap"] .fullwidthhalfleft {width:100% !important;}
                                td[class="wrap"] .fullwidthhalfright {width:100% !important;}
                                td[class="wrap"] .fullwidthhalfinner {width:100% !important; margin: 0 auto !important; float: none !important; margin-left: auto !important; margin-right: auto !important; clear:both !important; }
                                td[class="wrap"] .hide { display:none !important; width:0px;height:0px; overflow:hidden; }

                                td[class="pattern"] .c72p14r { width: 100% !important; }
                                td[class="pattern"] .c204p40r { width: 100% !important; }
                                td[class="pattern"] .c76p15r { width: 100% !important; }
                                td[class="pattern"] .c146p29r { width: 100% !important; }

                            }

                            @media yahoo{
                                table {float: none !important;height:auto; }
                                table[align="left"] {float:left !important; }
                                td[align="left"] {float:left !important;height:auto; }
                                table[align="center"] {margin:0 auto; }
                                td[align="center"] {margin:0 auto;height:auto; }
                                table[align="right"] {float:right !important; }
                                td[align="right"] {float:right !important;height:auto; }
                            }


                        </style>

                        <!--[if (gte IE 7) & (vml)]>
                        <style type="text/css">
                        html, body {margin:0 !important; padding:0px !important;}
                        img.full-width { position: relative !important; }
                        
                        .img100x28 { width: 100px !important; height: 28px !important;}
                        .img480x333 { width: 480px !important; height: 333px !important;}
                        .img72x72 { width: 72px !important; height: 72px !important;}
                        
                        </style>
                        <![endif]-->

                        <!--[if gte mso 9]>
                        <style type="text/css">
                        .mso-font-fix-arial { font-family: Arial, sans-serif;}
                        .mso-font-fix-georgia { font-family: Georgia, sans-serif;}
                        .mso-font-fix-tahoma { font-family: Tahoma, sans-serif;}
                        .mso-font-fix-times_new_roman { font-family: 'Times New Roman', sans-serif;}
                        .mso-font-fix-trebuchet_ms { font-family: 'Trebuchet MS', sans-serif;}
                        .mso-font-fix-verdana { font-family: Verdana, sans-serif;}
                        </style>
                        <![endif]-->

                        <!--[if gte mso 9]>
                        <style type="text/css">
                        table, td {
                        border-collapse: collapse !important;
                        mso-table-lspace: 0px !important;
                        mso-table-rspace: 0px !important;
                        }
                        
                        .email-root-wrapper { width 600px !important;}
                        .imglink { font-size: 0px; }
                        .edm_button { font-size: 0px; }
                        </style>
                        <![endif]-->

                        <!--[if gte mso 15]>
                        <style type="text/css">
                        table {
                        font-size:0px;
                        mso-margin-top-alt:0px;
                        }
                        
                        .fullwidthhalfleft {
                        width: 49% !important;
                        float:left !important;
                        }
                        
                        .fullwidthhalfright {
                        width: 50% !important;
                        float:right !important;
                        }
                        </style>
                        <![endif]-->
                        <STYLE type="text/css" media="(pointer) and (min-color-index:0)">
                            html, body {background-image: none !important; background-color: transparent !important; margin:0 !important; padding:0 !important;}
                        </STYLE>

                        </head>
                        <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" background="" bgcolor="#e3e3e3" style="font-family:Arial, sans-serif; font-size:0px;margin:0;padding:0; background: #e3e3e3 !important;">
                            <span style='display:none;font-size:0px;line-height:0px;max-height:0px;max-width:0px;opacity:0;overflow:hidden'>Carco</span>
                            <!--[if t]><![endif]--><!--[if t]><![endif]--><!--[if t]><![endif]--><!--[if t]><![endif]--><!--[if t]><![endif]--><!--[if t]><![endif]-->
                            <table align="center" border="0" cellpadding="0" cellspacing="0" background=""  bgcolor="#e3e3e3" style="background: #e3e3e3 !important;" height="100%" width="100%" id="backgroundTable">
                                <tr>
                                    <td class="wrap" align="center" valign="top" width="100%">
                                        <center>
                                            <!-- content -->
                                            <div style="padding: 0px;"><table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td valign="top" style="padding: 0px;"><table cellpadding="0" cellspacing="0" width="600" align="center" style="max-width: 600px;min-width: 240px;margin: 0 auto;" class="email-root-wrapper"><tr><td valign="top" style="padding: 0px;"><table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td valign="top" style="padding: 20px;"><table cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#ffffff" style="border: 0px none;background-color: #ffffff;background-image: url('null');background-repeat: repeat;background-position: center center;"><tr><td valign="top" style="padding: 20px;"><table cellpadding="0" cellspacing="0" width="100%"><tr><td style="padding: 0px;"><table cellpadding="0" cellspacing="0" width="100%"><tr><td align="left" style="padding: 0px;"><table cellpadding="0" cellspacing="0" border="0" align="left" width="100" 
                                                                                                                                                                                                        style="border: 0px none;height: auto;"><tr><td valign="top" style="padding: 0px;"><img src="<?= Yii::$app->params['BASE_URL'] ?>images/logo.png" width="100" height="28" alt="" border="0" style="display: block;" class="img100x28" /></td>
                                                                                                                            </tr>
                                                                                                                        </table>
                                                                                                                    </td>
                                                                                                                </tr>
                                                                                                            </table>

                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </table>
                                                                                                <table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td valign="top" style="padding: 10px;"><div style="text-align: left;font-family: Roboto, Helvetica Neue, Helvetica, Arial, sans-serif;font-size: 14px;color: #272727;line-height: 20px;mso-line-height: exactly;mso-text-raise: 3px;"><h1 style="font-family: Roboto, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 48px; color: #272727; line-height: 50px; mso-line-height: exactly; mso-text-raise: 1px; padding: 0; margin: 0;text-align: center;"><span class="mso-font-fix-arial">Hello!</span></h1><h2 style="font-family: Roboto, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 18px; color: #272727; line-height: 50px; mso-line-height: exactly; mso-text-raise: 16px; padding: 0; margin: 0;text-align: center;"></h2><p style="padding: 0; margin: 0;">&nbsp;</p><p style="padding: 0; margin: 0;">&nbsp;</p><p
                                                                                                                    style="padding: 0; margin: 0;">

                                                                                                                    You're receiving this email because you requested a password reset for your user account at Carco.<br>
                                                                                                                        <br>
                                                                                                                            Please go to the following link to choose a new password.<br>
                                                                                                                                <br>
                                                                                                                                    <a style="border-radius:4px;font-size:16px;color:white;text-decoration:none;padding:14px 7px 14px 7px;width:210px;max-width:210px;font-family:'Open Sans','Helvetica Neue',Arial;margin:0;display:block;background-color:#00AFEF;text-align:center" href="<?= $resetLink; ?>">Reset password</a>
                                                                                                                                    <br>
                                                                                                                                        <br>
                                                                                                                                            If you received this email and have not requested a password reset link, feel free to ignore it. <br>
                                                                                                                                                <br>
                                                                                                                                                    If you have any questions, contact us at support@carcohub.com.<br>
                                                                                                                                                        <br>
                                                                                                                                                            Best wishes,<br>
                                                                                                                                                                Carco Team
                                                                                                                                                                <br>







                                                                                                                                                                    </p></div></td>
                                                                                                                                                                    </tr>
                                                                                                                                                                    </table>

                                                                                                                                                                    <table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td valign="top" style="padding: 10px;"><table cellpadding="0" cellspacing="0" border="0" width="100%" style="border: 0px none;background-image: url('null');background-repeat: repeat;background-position: center center;"><tr><td valign="top" style="padding: 0px;"><table cellpadding="0" cellspacing="0" width="100%"><tr><td style="padding: 0px;" class="pattern"><table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td valign="top" style="padding: 0;mso-cellspacing: 0in;"><table cellpadding="0" cellspacing="0" border="0" align="left" width="72"  style="float: left;" class="c72p14r"><tr><td valign="top" style="padding: 0px;"><table cellpadding="0" cellspacing="0" width="100%"><tr><td align="left" style="padding: 0px;"><table cellpadding="0" cellspacing="0" border="0" align="left" width="72"  style="border: 0px none;height: auto;"><tr>
                                                                                                                                                                                                        </tr>
                                                                                                                                                                                                        </table>
                                                                                                                                                                                                        </td>
                                                                                                                                                                                                        </tr>
                                                                                                                                                                                                        </table>
                                                                                                                                                                                                        </td>
                                                                                                                                                                                                        </tr>
                                                                                                                                                                                                        </table>
                                                                                                                                                                                                        <!--[if gte mso 9]></td><td valign="top" style="padding:0;"><![endif]-->

<!--[if gte mso 9]></td><td valign="top" style="padding:0;"><![endif]-->

<!--[if gte mso 9]></td><td valign="top" style="padding:0;"><![endif]-->

                                                                                                                                                                                                        </td>
                                                                                                                                                                                                        </tr>
                                                                                                                                                                                                        </table>
                                                                                                                                                                                                    </td>
                                                                                                                                                                                                </tr>
                                                                                                                                                                                            </table>
                                                                                                                                                                                        </td>
                                                                                                                                                                                    </tr>
                                                                                                                                                                                </table>
                                                                                                                                                                            </td>
                                                                                                                                                                        </tr>
                                                                                                                                                                    </table>



                                                                                                                                                                    </td>
                                                                                                                                                                    </tr>
                                                                                                                                                                    </table>
                                                                                                                                                                    </td>
                                                                                                                                                                    </tr>
                                                                                                                                                                    </table>
                                                                                                                                                                    </td>
                                                                                                                                                                    </tr>
                                                                                                                                                                    </table>
                                                                                                                                                                    </td>
                                                                                                                                                                    </tr>
                                                                                                                                                                    </table>
                                                                                                                                                                    </td>
                                                                                                                                                                    </tr>
                                                                                                                                                                    </table>
                                                                                                                                                                    <table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td valign="top" style="padding: 0px;"><table cellpadding="0" cellspacing="0" width="600" align="center" style="max-width: 600px;min-width: 240px;margin: 0 auto;" class="email-root-wrapper"><tr><td valign="top" style="padding: 0px;"><table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td valign="top" style="padding: 10px;"><div style="text-align: left;font-family: Roboto, Helvetica Neue, Helvetica, Arial, sans-serif;font-size: 12px;color: #000000;line-height: 14px;mso-line-height: exactly;mso-text-raise: 1px;"><p style="padding: 0; margin: 0;text-align: center;"><span style="font-size: 14px;">
                                                                                                                                                                                                        <a href="https://www.facebook.com/carcohub" target="_blank"><img src="<?= Yii::$app->params['BASE_URL'] ?>images/facebook.png"></a>
                                                                                                                                                                                                        <a href="https://twitter.com/carcohub" target="_blank"><img src="<?= Yii::$app->params['BASE_URL'] ?>images/twitter.png"></a>
                                                                                                                                                                                                        <a href="http://carco.io/" target="_blank"><img src="<?= Yii::$app->params['BASE_URL'] ?>images/webpage.png"></a>
                                                                                                                                                                                                        <br><br>
                                                                                                                                                                                                        @Copyright <?= date('Y') ?> Carco.io. All Rights Reserved.</span></p><p style="padding: 0; margin: 0;text-align: center;">&nbsp;</p><p style="padding: 0; margin: 0;text-align: center;"><span style="font-size: 12px;">By providing us with your email, you comply with our </span><a href="http://carco.io/privacy-policy/"
                                                                                                                                                                                                        target="_blank" style="color: #0000ff !important; text-decoration: none;"><font style="color: #0000ff;"><span style="color: #00afef;">Privacy Policy</span></font></a><span style="font-size: 12px;">.</span></p></div></td>
                                                                                                                                                                                                        </tr>
                                                                                                                                                                                                        </table>
                                                                                                                                                                                                        </td>
                                                                                                                                                                                                        </tr>
                                                                                                                                                                                                        </table>
                                                                                                                                                                                                        </td>
                                                                                                                                                                                                        </tr>
                                                                                                                                                                                                        </table>
                                                                                                                                                                                                        </div>
                                                                                                                                                                                                        <!-- content end -->
                                                                                                                                                                                                        </center>
                                                                                                                                                                                                        </td>
                                                                                                                                                                                                        </tr>
                                                                                                                                                                                                        </table>
                                                                                                                                                                                                        </body>
                                                                                                                                                                                                        </html>
