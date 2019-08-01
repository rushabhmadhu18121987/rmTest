<?php


namespace api\modules\v1\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "users".
 *
 * @property integer $iUserId
 * @property integer $vRecipientId
 * @property string $vAuthKey
 * @property string $vEmail
 * @property string $vPassword
 * @property string $vFacebookId
 * @property string $vGoogleId
 * @property string $vFirstName
 * @property string $vLastName
 * @property string $vProfilePic
 * @property string $tiLanguage
 * @property integer $tiDeviceType
 * @property string $vDeviceToken
 * @property integer $tiAcceptPush
 * @property integer $iCreatedAt
 * @property integer $tiIsActive
 * @property integer $tiIsDelete
 */


class Users extends \yii\db\ActiveRecord {

    public $currentPassword;
    public $newPassword;
    public $confirmPassword;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['vEmail', 'vPassword'], 'required', 'on' => ['signup', 'signin']],
            [['vFirstName', 'vLastName'], 'required', 'on' => 'signup'],
            ['vEmail', 'unique', 'on' => 'signup'],
            [['tiDeviceType', 'vDeviceToken', 'vRecipientId'], 'safe', 'on' => ['signup', 'signin', 'fb_signin', 'google_signin']],
            ['vFacebookId', 'required', 'on' => 'fb_signin'],
            ['vGoogleId', 'required', 'on' => 'google_signin'],
            [['vEmail', 'vFirstName', 'vLastName', 'vProfilePic'], 'safe', 'on' => ['fb_signin', 'google_signin']],
            ['vEmail', 'required', 'on' => 'forgot_pwd'],
            [['currentPassword', 'newPassword'], 'required', 'on' => 'change_pwd'],
            ['confirmPassword', 'compare', 'compareAttribute' => 'newPassword', 'message' => "Confirm Password does not match.", 'on' => 'change_pwd'],
            ['tiLanguage', 'required', 'on' => 'change_lang'],
            ['vProfilePic', 'required', 'on' => 'edit_profile'],
            ['vEmail', 'email', 'message' => 'Please enter valid email address.'],
            [['tiLanguage', 'tiDeviceType', 'tiAcceptPush', 'iCreatedAt', 'tiIsActive', 'tiIsDelete'], 'integer'],
            //[['iCreatedAt'], 'required'],
            [['vPassword', 'newPassword'], 'string', 'min' => 6],
            [['vAuthKey', 'vFacebookId', 'vGoogleId', 'vDeviceToken'], 'string', 'max' => 255],
            [['vEmail', 'vPassword'], 'string', 'max' => 100],
            [['vFirstName', 'vLastName'], 'string', 'max' => 30],
            [['vFirstName', 'vLastName', 'vRecipientId'], 'default', 'value' => ""],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'iUserId' => 'User ID',
            'vRecipientId' => 'Recipient ID',
            'vAuthKey' => 'Auth Key',
            'vEmail' => 'Email ID',
            //'vEmail' => Yii::t('label', 'vEmail'),
            'vPassword' => 'Password',
            'vFacebookId' => 'Facebook ID',
            'vGoogleId' => 'Google ID',
            'vFirstName' => 'First Name',
            'vLastName' => 'Last Name',
            'vProfilePic' => 'Profile Pic',
            'tiLanguage' => 'Language',
            'tiDeviceType' => 'Device Type',
            'vDeviceToken' => 'Device Token',
            'tiAcceptPush' => 'Accept Push',
            'iCreatedAt' => 'Created At',
            'tiIsActive' => 'Active',
            'tiIsDelete' => 'Delete',
        ];
    }

    public function signin($params) {

        $modelUsers = new Users(['scenario' => 'signin']);
        $modelUsers->attributes = $params;
        if ($modelUsers->validate()) {
            $modelUsers = Users::find()->where('vEmail = :vEmail AND vPassword = :vPassword', [':vEmail' => $params['vEmail'], ':vPassword' => md5($params['vPassword'])])->one();
            if (!empty($modelUsers)) {
                if ($modelUsers->tiIsActive == 0) {
                    $response = ['response_code' => 400, 'response_message' => "Your account is deactivated by admin. Please contact to admin for more detail."];
                }
                $modelUsers->vAuthKey = md5($modelUsers->vEmail . time());
                $modelUsers->tiDeviceType = (!empty($params['tiDeviceType'])) ? $params['tiDeviceType'] : "";
                $modelUsers->vDeviceToken = (!empty($params['vDeviceToken'])) ? $params['vDeviceToken'] : "";

                //   $modelUsers->vRecipientId = Yii::$app->common->generate_recipientid($params['vFirstName']);
                $modelUsers->save();

                $response = ['response_code' => 200, 'response_data' => self::users_response($modelUsers), 'response_message' => Yii::t('response', 'login_success')];
            } else {
                $response = ['response_code' => 400, 'response_message' => "Invalid email or password"];
            }
        } else {
            $error = $modelUsers->errors;
            $response = ['response_code' => 400, 'response_message' => current($error)[0]];
        }

        return $response;
    }

    public function facebook_signin($params) {

        if (!empty($params['vFacebookId'])) {

            $vEmail = (!empty($params['vEmail'])) ? ('vEmail ="' . $params['vEmail'] . '"') : "";
            $modelUsers = Users::find()->where(['vFacebookId' => $params['vFacebookId']])->orWhere($vEmail)->one();
            $newRec = 0;
            if (empty($modelUsers)) {
                $newRec = 1;
                $modelUsers = new Users();
                $modelUsers->iCreatedAt = time();
                if (!empty($params['name'])) {
                    $modelUsers->vRecipientId = Yii::$app->common->generate_recipientid($params['name']);
                } else if (!empty($params['vEmail'])) {
                    $modelUsers->vRecipientId = Yii::$app->common->generate_recipientid($params['vEmail']);
                } else {
                    $modelUsers->vRecipientId = Yii::$app->common->generate_recipientid($params['vFacebookId']);
                }
            } else if ($modelUsers->tiIsActive == 0) {
                return ['response_code' => 400, 'response_message' => "Your account is deactivated by admin. Please contact to admin for more detail."];
            }

            $modelUsers->scenario = "fb_signin";
            $modelUsers->attributes = $params;
            $modelUsers->vAuthKey = md5($params['vFacebookId'] . time());

            if (!empty($params['vProfilePic'])) {
                $profilePicName = time() . '.' . pathinfo(parse_url($params['vProfilePic']), PATHINFO_EXTENSION);
                $modelUsers->vProfilePic = $profilePicName;
            }

            if ($modelUsers->save()) {
                if (!empty($params['vProfilePic'])) {
                    $dir = Yii::getAlias('@uploads') . '/users/' . $modelUsers->iUserId;
                    Yii::$app->common->create_dir($dir);
                    file_put_contents($dir . "/" . $profilePicName, file_get_contents($params['vProfilePic']));
                }

                if ($newRec == 1) {
                    Yii::$app->common->braintree_customer_create($modelUsers);
                }

                $response = ['response_code' => 200, 'response_data' => self::users_response($modelUsers), 'response_message' => "Login Successfully."];
            } else {
                $error = $modelUsers->errors;
                $response = ['response_code' => 400, 'response_message' => current($error)[0]];
            }
        } else {
            $response = ['response_code' => 401, 'response_message' => "Unauthorized"];
        }

        return $response;
    }

    public function google_signin($params) {

        if (!empty($params['vGoogleId'])) {

            $vEmail = (!empty($params['vEmail'])) ? ('vEmail ="' . $params['vEmail'] . '"') : "";
            $modelUsers = Users::find()->where(['vGoogleId' => $params['vGoogleId']])->orWhere($vEmail)->one();
            $newRec = 0;
            if (empty($modelUsers)) {
                $newRec = 1;
                $modelUsers = new Users();
                $modelUsers->iCreatedAt = time();
                if (!empty($params['name'])) {
                    $modelUsers->vRecipientId = Yii::$app->common->generate_recipientid($params['name']);
                } else if (!empty($params['vEmail'])) {
                    $modelUsers->vRecipientId = Yii::$app->common->generate_recipientid($params['vEmail']);
                } else {
                    $modelUsers->vRecipientId = Yii::$app->common->generate_recipientid($params['vFacebookId']);
                }
            } else if ($modelUsers->tiIsActive == 0) {
                return ['response_code' => 400, 'response_message' => "Your account is deactivated by admin. Please contact to admin for more detail."];
            }

            $modelUsers->scenario = "google_signin";
            $modelUsers->attributes = $params;
            $modelUsers->vAuthKey = md5($params['vGoogleId'] . time());

            if (!empty($params['vProfilePic'])) {
                $profilePicName = time() . '.' . pathinfo(parse_url($params['vProfilePic']), PATHINFO_EXTENSION);
                $modelUsers->vProfilePic = $profilePicName;
            }

            if ($modelUsers->save()) {
                if (!empty($params['vProfilePic'])) {
                    $dir = Yii::getAlias('@uploads') . '/users/' . $modelUsers->iUserId;
                    Yii::$app->common->create_dir($dir);
                    file_put_contents($dir . "/" . $profilePicName, file_get_contents($params['vProfilePic']));
                }
                if ($newRec == 1) {
                    Yii::$app->common->braintree_customer_create($modelUsers);
                }

                $response = ['response_code' => 200, 'response_data' => self::users_response($modelUsers), 'response_message' => "Login Successfully."];
            } else {
                $error = $modelUsers->errors;
                $response = ['response_code' => 400, 'response_message' => current($error)[0]];
            }
        } else {
            $response = ['response_code' => 401, 'response_message' => "Unauthorized"];
        }

        return $response;
    }

    public function signup($params) {

        $modelUsers = new Users(['scenario' => 'signup']);
        $modelUsers->attributes = $params;
        if ($modelUsers->validate()) {
            $modelUsers->iCreatedAt = time();
            $modelUsers->vPassword = md5($params['vPassword']);
            $modelUsers->vAuthKey = md5($modelUsers->vEmail . time());
            $modelUsers->tiDeviceType = (!empty($params['tiDeviceType'])) ? $params['tiDeviceType'] : "";
            $modelUsers->vDeviceToken = (!empty($params['vDeviceToken'])) ? $params['vDeviceToken'] : "";
            if (!empty($params['vFirstName'])) {
                $modelUsers->vRecipientId = Yii::$app->common->generate_recipientid($params['vFirstName']);
            }

            if ($modelUsers->save()) {
                Yii::$app->common->braintree_customer_create($modelUsers);
                return ['response_code' => 200, 'response_message' => "Signup successfully.", 'response_data' => self::users_response($modelUsers)];
            }
        }
        $error = $modelUsers->errors;
        return ['response_code' => 400, 'response_message' => current($error)[0]];
    }

    public function forgot_password($params) {

        $modelUser = new Users(['scenario' => 'forgot_pwd']);
        $modelUser->attributes = $params;
        if (!$modelUser->validate()) {
            $error = $modelUser->errors;
            return ['response_code' => 400, 'response_message' => current($error)[0]];
        }

        $modelUsers = Users::find()->where(['vEmail' => $params['vEmail']])->one();

        if (empty($modelUsers)) {
            return ['response_code' => 400, 'response_message' => "Email address does not registered with us."];
        } else if ($modelUsers->tiIsActive == 0) {
            return ['response_code' => 400, 'response_message' => "Your account is deactivated by admin. Please contact to admin for more detail."];
        } else {

            $modelUsers->vPasswordResetToken = Yii::$app->security->generateRandomKey() . '_' . time();

            if ($modelUsers->save()) {

                $mailSend = \Yii::$app->mailer->compose('passwordResetToken', ['user' => $modelUsers])
                        ->setFrom([\Yii::$app->params['adminEmail'] => \Yii::$app->name])
                        ->setTo($params['vEmail'])
                        ->setSubject(' Reset your ' . \Yii::$app->name . ' password')
                        ->send();

                if ($mailSend == 1) {
                    $response = ['response_code' => 200, 'response_message' => "Reset link has been sent to your email."];
                } else {
                    $response = ['response_code' => 400, 'response_message' => "Error while processing your request."];
                }
            } else {
                $error = $modelUsers->errors;
                $response = ['response_code' => 400, 'response_message' => current($error)[0]];
            }
            return $response;
        }
    }

    public function change_password($params, $iUserId) {

        $model = Users::findOne(['iUserId' => $iUserId]);
        $model->scenario = "change_pwd";
        $model->attributes = $params;
        if ($model->validate()) {
            if ($model->vPassword !== md5($params['currentPassword'])) {
                return ['response_code' => 400, 'response_message' => "Current password is incorrect."];
            }
            $model->vPassword = md5($params['newPassword']);
            if ($model->save()) {
                return ['response_code' => 200, 'response_message' => "Password changed successfully."];
            }
        }
        $error = $model->errors;
        return ['response_code' => 400, 'response_message' => current($error)[0]];
    }

    public function change_language($params, $iUserId) {

        $model = Users::findOne(['iUserId' => $iUserId]);
        $model->scenario = "change_lang";
        $model->attributes = $params;
        if ($model->save()) {
            $response = ['response_code' => 200, 'response_message' => "Language changed successfully."];
        } else {
            $error = $model->errors;
            $response = ['response_code' => 400, 'response_message' => current($error)[0]];
        }
        return $response;
    }

    public function edit_profile($vProfilePic, $iUserId) {
        if (empty($vProfilePic)) {
            return ['response_code' => 400, 'response_message' => 'Profile picture cannot be blank.'];
        }
        $model = Users::findOne(['iUserId' => $iUserId]);
        $model->scenario = "edit_profile";
        if (!empty($vProfilePic)) {
            $profilePicName = time() . '.' . $vProfilePic->extension;
            $model->vProfilePic = $profilePicName;
        }
        if ($model->save()) {
            if (!empty($vProfilePic)) {
                $dir = Yii::getAlias('@uploads') . '/users/' . $model->iUserId;
                if (!is_dir($dir)) {
                    $oldmask = umask(0);
                    mkdir($dir, 0777, true);
                    umask($oldmask);
                } else {
                    array_map('unlink', glob($dir . '/*'));
                }
                $vProfilePic->saveAs($dir . '/' . $profilePicName);
            }
            $response = ['response_code' => 200, 'response_message' => "Edit profile successfully."];
        } else {
            $error = $model->errors;
            $response = ['response_code' => 400, 'response_message' => current($error)[0]];
        }
        return $response;
    }

    public function verify_recipient($params, $iUserId) {
        if (empty($params['vRecipientId'])) {
            return ['response_code' => 400, 'response_message' => 'Unauthorized'];
        }

        $modelUsers = Users::findOne(['vRecipientId' => $params['vRecipientId']]);
        if (!empty($modelUsers)) {
            if ($modelUsers->iUserId == $iUserId) {
                $response = ['response_code' => 400, 'response_message' => 'You cannot use own recipient Id.'];
            } else {
                $returnData = [
                    'vRecipientId' => $modelUsers->vRecipientId,
                    'vProfilePic' => (!empty($modelUsers->vProfilePic)) ? (Yii::$app->params['profilePic_url'] . $modelUsers->iUserId . '/' . $modelUsers->vProfilePic) : Yii::$app->params['defaultProfPic_url']
                ];

                $response = ['response_code' => 200, 'response_message' => "Recipient verify successfully.", 'response_data' => $returnData];
            }
        } else {
            $response = ['response_code' => 400, 'response_message' => 'Please Enter Valid Recipient Name.'];
        }
        return $response;
    }

    public function balance_info($iUserId) {

        $model = Users::find()->select(['CONCAT("$",fTotBalance) AS fTotBalance'])->where(['iUserId' => $iUserId])->asArray()->one();
        $model['badge_count'] = Notifications::find()->where(['iToUserId' => $iUserId])->andWhere('tiNotificationReadFlag = 0 AND tiNotificationType IN(2,4,5)')->count();
        
        if (!empty($model)) {
            $response = ['response_code' => 200, 'response_message' => "Balance info.", 'response_data' => $model];
        } else {
            $response = ['response_code' => 400, 'response_message' => 'Unauthorized'];
        }

        return $response;
    }

    public function notification_on_off($params, $iUserId) {

        $model = Users::findOne(['iUserId' => $iUserId]);
        if (isset($params['tiAcceptPush'])) {
            $model->tiAcceptPush = $params['tiAcceptPush'];
        }
        if ($model->save()) {
            $response = ['response_code' => 200, 'response_message' => "Notification update successfully."];
        } else {
            $error = $model->errors;
            $response = ['response_code' => 400, 'response_message' => current($error)[0]];
        }
        return $response;
    }

    public function log_out($iUserId) {

        $model = Users::findOne(['iUserId' => $iUserId]);
        $model->tiDeviceType = NULL;
        $model->vDeviceToken = NULL;
        if ($model->save()) {
            $response = ['response_code' => 200, 'response_message' => "Logout successfully."];
        } else {
            $error = $model->errors;
            $response = ['response_code' => 400, 'response_message' => current($error)[0]];
        }
        return $response;
    }

    public function add_card($params, $iUserId) {
        if (empty($params['nonce'])) {
            return ['response_code' => 400, 'response_message' => 'Unauthorized'];
        }

        $response = Yii::$app->common->braintree_add_card($params['nonce'], $iUserId);
        return $response;
    }

    public function delete_card($cardToken) {
        if (empty($cardToken)) {
            return ['response_code' => 400, 'response_message' => 'Unauthorized'];
        }

        $response = Yii::$app->common->braintree_delete_card($cardToken);
        return $response;
    }

    private function users_response($modelUsers) {
        return [
            'vAuthKey' => $modelUsers->vAuthKey,
            'vEmail' => $modelUsers->vEmail,
            'vFirstName' => $modelUsers->vFirstName,
            'vLastName' => $modelUsers->vLastName,
            'vRecipientId' => $modelUsers->vRecipientId,
            'vProfilePic' => (!empty($modelUsers->vProfilePic)) ? (Yii::$app->params['profilePic_url'] . $modelUsers->iUserId . '/' . $modelUsers->vProfilePic) : Yii::$app->params['defaultProfPic_url'],
        ];
    }

}
