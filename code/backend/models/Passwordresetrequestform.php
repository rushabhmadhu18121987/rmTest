<?php

/* *     **********************************************************************
 * Original Author: Suraj Vaghela (surajv.spaceo)
 * Created By : Suraj Vaghela    
 * Created On :   September 2018
 * File Creation Date:   September 2018
 * Development Group: Space-O Technologies
 * Description:     
 * Last Modified on:
 * Modified By:
 * Modified Description:
 * Purpose :  function    
 * Modified Code:
 * ********************************************************************* */

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Password reset request form
 */
class Passwordresetrequestform extends Model {

    public $email;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'There is no user with this email address.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail() {
        /* @var $user User */
        $user = User::findOne([
                    'status' => User::STATUS_ACTIVE,
                    'email' => $this->email,
        ]);
        //echo $this->email; exit();

        if (!$user) {
            return false;
        }

        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();

            if (!$user->save()) {
                return false;
            }
        }

        return Yii::$app->mailer->compose(['html' => 'passwordResetTokenAdmin', 'text' => 'passwordResetToken-text'], ['user' => $user])
                        ->setFrom([$this->email => Yii::$app->name . 'robot'])
                        ->setTo($this->email)
                        ->setSubject('Password reset for ' . Yii::$app->name)
                        ->send();
    }

}
