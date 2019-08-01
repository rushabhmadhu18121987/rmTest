<?php

namespace api\modules\v1\models;

use Yii;
use yii\db\Transaction;
use api\modules\v1\models\response\ErrorResponse;
use api\modules\v1\models\response\SuccessResponse;
use api\modules\v1\models\response\UserMasterResponse;
use api\modules\v1\models\response\UserMasterResponseData;
use api\modules\v1\models\response\UserDeviceMasterResponse;
use api\modules\v1\models\response\UserDeviceMasterResponseData;
use yii\web\UploadedFile;

/**
 * This is the model class for table "user_master".
 *
 * @property int $iUserId
 * @property string $vParkingOfficerEmployeeId
 * @property string $vUserName
 * @property string $vStripeCustomerId
 * @property string $vBrainTreeCustomerId
 * @property string $vName
 * @property string $vEmail
 * @property string $vISDCode
 * @property string $vMobileNumber
 * @property string $vNewISDCode
 * @property string $vNewMobileNumber
 * @property string $vPassword
 * @property string $vProfilePic
 * @property string $vTimezone
 * @property int $iPasswordExpireAt
 * @property int $tiUserType 1 - User, 2 - Business
 * @property int $tiIsSocialLogin 1-Yes , 0-No
 * @property string $vOTP
 * @property int $iOTPExpireAt
 * @property int $tiIsMobileVerified 1-Yes , 0-No
 * @property string $vPasswordResetToken
 * @property int $iNotiBadgeCount
 * @property int $iRegistrationProgress
 * @property int $tiAcceptPush 1 - Yes , 0 - No
 * @property int $tiIsActive 1 - Active, 0 - Inactive
 * @property int $tiIsDeleted 1-Yes , 0-No
 * @property int $iCreatedAt
 * @property int $iUpdatedAt
 *
 * @property AdminAnnouncementReceiver[] $adminAnnouncementReceivers
 * @property UserContactUs[] $userContactuses
 * @property UserDeviceMaster[] $userDeviceMasters
 * @property UserSocialAccount[] $userSocialAccounts
 */
class UserMaster extends \yii\db\ActiveRecord {

    public $token, $vAuthKey;
    public $currentPassword, $vNewPassword, $confirmPassword, $service, $accessToken;
    public $vNewPin;

    public static function find($query = null) {
        return parent::find($query)->andWhere(['user_master.tiIsDeleted' => 0]);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'user_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['vName', 'vEmail', 'vPassword'], 'required', 'on' => [SCH_CREATE, SCH_SIGNUP]],
            [['vName', 'vEmail', 'vNewISDCode', 'vNewMobileNumber'], 'required', 'on' => [SCH_UPDATE_PROFILE]],
            [['tiUserType', 'tiIsSocialLogin', 'iOTPExpireAt', 'tiIsMobileVerified', 'iNotiBadgeCount', 'tiAcceptPush', 'tiIsActive', 'tiIsDeleted', 'iCreatedAt', 'iUpdatedAt'], 'integer'],
            [['vUserName', 'vName'], 'string', 'max' => 50],
            [['vTimezone'], 'safe', 'on' => [SCH_CREATE, SCH_SIGNUP, SCH_UPDATE_PROFILE, SCH_SOCIAL_SIGNIN, SCH_SOCIAL_SIGNUP, SCH_SIGNIN, SCH_CHANGE_PASSWORD]],
            [['vEmail'], 'string', 'max' => 100],
            [['vISDCode'], 'string', 'max' => 5],
            [['vMobileNumber'], 'string', 'max' => 20],
            [['vPassword', 'vPasswordResetToken'], 'string', 'max' => 255],
            [['vProfilePic'], 'string', 'max' => 30],
            [['vEmail'], 'unique', 'on' => [SCH_SIGNUP, SCH_SOCIAL_SIGNUP]],
            [['vMobileNumber'], 'unique', 'on' => [SCH_SIGNUP]],
            [['vUserName'], 'unique', 'on' => [SCH_SIGNUP]],
            [['vEmail'], 'unique', 'targetAttribute' => 'iUserId', 'on' => [SCH_UPDATE_PROFILE, SCH_DEFAULT]],
            [['vMobileNumber'], 'unique', 'targetAttribute' => 'iUserId', 'on' => [SCH_UPDATE_PROFILE, SCH_DEFAULT]],
            [['vUserName'], 'unique', 'targetAttribute' => 'iUserId', 'on' => [SCH_UPDATE_PROFILE, SCH_DEFAULT]],
            ['vMobileNumber', 'required', 'message' => 'Unauthorize request.', 'on' => [SCH_VERIFY_OTP, SCH_RESEND_OTP]],
            [['vEmail', 'vPassword', 'tiUserType'], 'required', 'on' => [SCH_SIGNIN]],
            [['vISDCode', 'vMobileNumber'], 'required', 'on' => [SCH_ADD_MOBILENO]],
            [['vMobileNumber'], 'unique', 'on' => [SCH_ADD_MOBILENO]],
            [['vEmail', 'tiUserType'], 'required', 'on' => SCH_FORGOT_PASSWORD],
            [['service', 'accessToken'], 'required', 'on' => SCH_SOCIAL_SIGNIN],
            [['vName', 'vEmail', 'tiIsSocialLogin'], 'required', 'on' => SCH_SOCIAL_SIGNUP],
            [['currentPassword', 'vNewPassword', 'confirmPassword'], 'required', 'on' => SCH_CHANGE_PASSWORD],
            ['confirmPassword', 'compare', 'compareAttribute' => 'vNewPassword', 'message' => "Confirm Password does not match.", 'on' => SCH_CHANGE_PASSWORD],
            ['currentPassword', 'compare', 'compareAttribute' => 'vPassword', 'message' => "Current Password does not match.", 'on' => SCH_CHANGE_PASSWORD],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'iUserId' => 'User ID',
            'vParkingOfficerEmployeeId' => 'Business Employee ID',
            'vUserName' => 'User Name',
            'vStripeCustomerId' => 'Stripe Customer ID',
            'vBrainTreeCustomerId' => 'Brain Tree Customer ID',
            'vName' => 'Name',
            'vEmail' => 'Email',
            'vISDCode' => 'Isdcode',
            'vMobileNumber' => 'Mobile Number',
            'vNewISDCode' => 'Isdcode',
            'vNewMobileNumber' => 'Mobile Number',
            'vPassword' => 'Password',
            'vProfilePic' => 'Profile Pic',
            'tiUserType' => 'User Type',
            'tiIsSocialLogin' => 'Is Social Login',
            'vOTP' => 'Otp',
            'iOTPExpireAt' => 'Otpexpire At',
            'tiIsMobileVerified' => 'Is Mobile Verified',
            'vPasswordResetToken' => 'Password Reset Token',
            'iNotiBadgeCount' => 'Noti Badge Count',
            'iRegistrationProgress' => 'Registration Progress',
            'tiAcceptPush' => 'Accept Push',
            'tiIsActive' => 'Is Active',
            'tiIsDeleted' => 'Is Deleted',
            'iCreatedAt' => 'Created At',
            'iUpdatedAt' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookingCancellationRequests() {
        return $this->hasMany(BookingCancellationRequest::className(), ['iUserId' => 'iUserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserContactuses() {
        return $this->hasMany(UserContactUs::className(), ['iUserId' => 'iUserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserDeviceMasters() {
        return $this->hasMany(UserDeviceMaster::className(), ['iUserId' => 'iUserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserSocialAccounts() {
        return $this->hasMany(UserSocialAccount::className(), ['iUserId' => 'iUserId']);
    }

    /**
     * Validate AuthKey
     * @param string $vAuthKey
     * @author VB Panchal <yagnesh.spaceo@gmail.com>
     */
    public static function validateAuthKey($vAuthKey) {
        if (!empty($vAuthKey)) {
            $modelDevice = UserDeviceMaster::find()->where(['vAuthKey' => $vAuthKey])->one();
            if (!empty($modelDevice)) {
                $responseData = UserDeviceMasterResponseData::withModel($modelDevice);
                $finalResponse = new UserDeviceMasterResponse();
                $finalResponse->setResponseCode(OK);
                $finalResponse->setResponseMessage(Yii::t('response', 'authkey_valid'));
                $finalResponse->setResponseData($responseData->showEverything());
                return $finalResponse;
            } else {
                return ErrorResponse::withData(ACCESS_DENINED, Yii::t('response', 'authkey_invalid'));
                return $errorresponse;
            }
        } else {
            return ErrorResponse::withData(ACCESS_DENINED, Yii::t('response', 'authkey_required'));
            return $errorresponse;
        }
    }

    /**
     * Signup
     * @param \yii\web\UploadedFile $vProfilePic
     * @param array $params
     * @author VB Panchal <yagnesh.spaceo@gmail.com>
     */
    public function signup($params) {
        $transaction = Yii::$app->db->beginTransaction(Transaction::SERIALIZABLE);
        try {
            $modelUser = new UserMaster();
            $modelUser->scenario = SCH_SIGNUP;
            $modelUser->attributes = $params;
            $modelUser->iCreatedAt = time();
            if (!$modelUser->validate()) {
                $transaction->rollBack();
                return ErrorResponse::withData(BAD_REQUEST, current($modelUser->getFirstErrors()));
            } else {
                $modelUser->tiAcceptPush = 1;
                $modelUser->tiIsSocialLogin = 0;
                $modelUser->iNotiBadgeCount = 0;
                $modelUser->iRegistrationProgress = 1;
                $modelUser->vPassword = md5($params['vPassword']);
                $vProfilePic = UploadedFile::getInstanceByName('vProfilePic');
                $profilePicName = NULL;
                if (!empty($vProfilePic)) {
                    $profilePicName = time() . '.' . $vProfilePic->extension;
                    $modelUser->vProfilePic = $profilePicName;
                }
                if ($modelUser->save()) {
                    $vAuthKey = md5($modelUser->vEmail . time());
                    $modelDevice = new UserDeviceMaster();
                    $modelDevice->scenario = SCH_SIGNIN;
                    $modelDevice->attributes = $params;
                    $modelDevice->iUserId = $modelUser->iUserId;
                    $modelDevice->vAuthKey = $vAuthKey;
                    $modelDevice->iCreatedAt = time();
                    if ($modelDevice->save()) {
                        if (!empty($vProfilePic)) {
                            $dir = Yii::getAlias('@uploads') . '/users/' . $modelUser->iUserId;
                            Yii::$app->generallib->createDir($dir);
                            $vProfilePic->saveAs($dir . '/' . $profilePicName);
                        }
                        $modelUser->sendWelcomeMail();
                        $transaction->commit();
                        $modelUser->vAuthKey = $vAuthKey;
                        $responseData = UserMasterResponseData::withModel($modelUser);
                        $finalResponse = new UserMasterResponse();
                        $finalResponse->setResponseCode(OK);
                        $finalResponse->setResponseMessage(Yii::t('response', 'signup_success'));
                        $finalResponse->setResponseData($responseData->showEverything());
                        return $finalResponse;
                    } else {
                        $transaction->rollBack();
                        return ErrorResponse::withData(BAD_REQUEST, current($modelDevice->getFirstErrors()));
                    }
                } else {
                    $transaction->rollBack();
                    return ErrorResponse::withData(BAD_REQUEST, current($modelUser->getFirstErrors()));
                }
            }
        } catch (\Exception $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        }
    }

    /**
     * SignIn
     * @param array $params
     * @author VB Panchal <yagnesh.spaceo@gmail.com>
     */
    public function signin($params) {
        $transaction = Yii::$app->db->beginTransaction(Transaction::SERIALIZABLE);
        try {
            $modelUser = new UserMaster();
            $modelUser->scenario = SCH_SIGNIN;
            $modelUser->attributes = $params;
            if (!$modelUser->validate()) {
                $transaction->rollBack();
                return ErrorResponse::withData(BAD_REQUEST, current($modelUser->getFirstErrors()));
            } else {
                $modelUser = UserMaster::find()->where(['vEmail' => $params['vEmail'], 'vPassword' => md5($params['vPassword']), 'tiUserType' => $params['tiUserType'], 'tiIsDeleted' => 0])->one();
                if (!empty($modelUser)) {
                    if ($modelUser->tiIsActive == 0) {
                        $transaction->rollBack();
                        return ErrorResponse::withData(BAD_REQUEST, Yii::t('response', 'account_inactive'));
                    } else if (!empty($modelUser->iPasswordExpireAt) && $modelUser->iPasswordExpireAt < time()) {
                        $transaction->rollBack();
                        return ErrorResponse::withData(BAD_REQUEST, Yii::t('response', 'user_password_expired'));
                    } else {
                        UserDeviceMaster::deleteAll(['iUserId' => $modelUser->iUserId]);
                        $modelDevice = new UserDeviceMaster();
                        $modelDevice->scenario = SCH_SIGNIN;
                        $modelDevice->attributes = $params;
                        $modelDevice->iUserId = $modelUser->iUserId;
                        $vAuthKey = md5($modelUser->vEmail . $modelUser->iUserId . time());
                        $modelDevice->vAuthKey = $vAuthKey;
                        $modelDevice->iCreatedAt = time();
                        if ($modelDevice->save()) {
                            $transaction->commit();
                            $modelUser->vAuthKey = $vAuthKey;
                            $responseData = UserMasterResponseData::withModel($modelUser);
                            return UserMasterResponse::withData(OK, Yii::t('response', 'signin_success'), $responseData->showEverything());
                        } else {
                            $transaction->rollBack();
                            return ErrorResponse::withData(BAD_REQUEST, current($modelDevice->getFirstErrors()));
                        }
                    }
                } else {
                    $transaction->rollBack();
                    return ErrorResponse::withData(BAD_REQUEST, Yii::t('response', 'signin_fail'));
                }
            }
        } catch (\Exception $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        }
    }

    /**
     * Add Mobile Number
     * @param array $params
     * @param self $modelUser
     * @author VB Panchal <yagnesh.spaceo@gmail.com>
     */
    public function addMobileNo($params, $modelUser) {
        $transaction = Yii::$app->db->beginTransaction(Transaction::SERIALIZABLE);
        try {
            if (!empty($modelUser->vMobileNumber) && $modelUser->tiIsMobileVerified == 1) {
                return ErrorResponse::withData(BAD_REQUEST, Yii::t('response', 'mobile_number_already_added'));
            }
            $user = $modelUser;
            $user->scenario = SCH_ADD_MOBILENO;
            $user->iUserId = $modelUser->iUserId;
            $user->attributes = $params;
            if (!$user->validate()) {
                $transaction->rollBack();
                return ErrorResponse::withData(BAD_REQUEST, current($user->getFirstErrors()));
            }
            $modelUser->vNewISDCode = $params['vISDCode'];
            $modelUser->vNewMobileNumber = $params['vMobileNumber'];
            if (!empty($modelUser->vehicleMasters)) {
                $modelUser->iRegistrationProgress = 3;
            } else {
                $modelUser->iRegistrationProgress = 2;
            }
            $response = static::sendOTP($modelUser);
            if ($response->getResponseCode() == OK) {
                $transaction->commit();
                return $response;
            } else {
                $transaction->rollBack();
                return $response;
            }
        } catch (\Exception $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        }
    }

    /**
     * Resend OTP
     * @param array $params 
     * @author VB Panchal <yagnesh.spaceo@gmail.com>
     */
    public function resendOTP($params) {
        $transaction = Yii::$app->db->beginTransaction(Transaction::SERIALIZABLE);
        try {
            $modelUser = new UserMaster(['scenario' => SCH_RESEND_OTP]);
            $modelUser->attributes = $params;
            if (!$modelUser->validate()) {
                return ErrorResponse::withData(BAD_REQUEST, current($modelUser->getFirstErrors()));
            } else {
                $modelUser = UserMaster::find()->where(['vNewMobileNumber' => $params['vMobileNumber']])->one();
                if (!empty($modelUser)) {
                    $response = static::sendOTP($modelUser);
                    if ($response->getResponseCode() == OK) {
                        $transaction->commit();
                        return $response;
                    } else {
                        $transaction->rollBack();
                        return $response;
                    }
                } else {
                    $transaction->rollBack();
                    return ErrorResponse::withData(BAD_REQUEST, Yii::t('response', 'invalid_mobile_number'));
                }
            }
        } catch (\Exception $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        }
    }

    /**
     * Verify OTP
     * @param type $params
     * @author VB Panchal <yagnesh.spaceo@gmail.com>
     */
    public function verifyOTP($params) {
        $transaction = Yii::$app->db->beginTransaction(Transaction::SERIALIZABLE);
        try {
            $modelUser = new UserMaster(['scenario' => SCH_VERIFY_OTP]);
            $modelUser->attributes = $params;
            if (!$modelUser->validate()) {
                $transaction->rollBack();
                return ErrorResponse::withData(BAD_REQUEST, current($modelUser->getFirstErrors()));
            }
            $modelUser = UserMaster::find()->where(['vNewMobileNumber' => $params['vMobileNumber'], 'vOTP' => $params['vOTP']])->one();
            if (!empty($modelUser) && $modelUser->iOTPExpireAt > time()) {
                $modelUser->vISDCode = $modelUser->vNewISDCode;
                $modelUser->vMobileNumber = $modelUser->vNewMobileNumber;
                $modelUser->tiIsMobileVerified = 1;
                $modelUser->vOTP = NULL;
                $modelUser->iOTPExpireAt = NULL;
                $modelUser->vNewISDCode = NULL;
                $modelUser->vNewMobileNumber = NULL;
                if (!empty($modelUser->vehicleMasters)) {
                    $modelUser->iRegistrationProgress = 3;
                } else {
                    $modelUser->iRegistrationProgress = 2;
                }
                if ($modelUser->save()) {
                    UserDeviceMaster::deleteAll(['iUserId' => $modelUser->iUserId]);
                    $modelDevice = new UserDeviceMaster();
                    $modelDevice->scenario = SCH_SIGNIN;
                    $modelDevice->attributes = $params;
                    $modelDevice->iUserId = $modelUser->iUserId;
                    $vAuthKey = md5($modelUser->vEmail . $modelUser->iUserId . time());
                    $modelDevice->vAuthKey = $vAuthKey;
                    $modelDevice->iCreatedAt = time();
                    if ($modelDevice->save()) {
                        $transaction->commit();
                        $modelUser->vAuthKey = $modelDevice->vAuthKey;
                        $responseData = UserMasterResponseData::withModel($modelUser, $modelDevice->vAuthKey);
                        return UserMasterResponse::withData(OK, Yii::t('response', 'otp_verify_success'), $responseData->showEverything());
                    } else {
                        return ErrorResponse::withData(BAD_REQUEST, current($modelDevice->getFirstErrors()));
                    }
                } else {
                    $transaction->rollBack();
                    return ErrorResponse::withData(BAD_REQUEST, current($modelUser->getFirstErrors()));
                }
            } else {
                $transaction->rollBack();
                return ErrorResponse::withData(BAD_REQUEST, Yii::t('response', 'invalid_otp'));
            }
        } catch (\Exception $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        }
    }

    /**
     * 
     * @param array $params
     * @author VB Panchal <yagnesh.spaceo@gmail.com>
     */
    public function forgotPassword($params) {
        $transaction = Yii::$app->db->beginTransaction(Transaction::SERIALIZABLE);
        try {
            $modelUser = new UserMaster();
            $modelUser->scenario = SCH_FORGOT_PASSWORD;
            $modelUser->attributes = $params;
            if (!$modelUser->validate()) {
                return ErrorResponse::withData(BAD_REQUEST, current($modelUser->getFirstErrors()));
            } else {
                $modelUser = UserMaster::find()->where(['vEmail' => $params['vEmail'], 'tiUserType' => $params['tiUserType'], 'tiIsDeleted' => 0])->one();
                if (empty($modelUser)) {
                    $transaction->rollBack();
                    return ErrorResponse::withData(BAD_REQUEST, Yii::t('response', 'email_not_registered'));
                } else if ($modelUser->tiIsActive == 0) {
                    $transaction->rollBack();
                    return ErrorResponse::withData(BAD_REQUEST, Yii::t('response', 'account_inactive'));
                } else {
                    $randomPassword = UserMaster::generateRandomPassword(8);
                    $modelUser->vPassword = md5($randomPassword);
                    $modelUser->iPasswordExpireAt = time() + 1800;
                    $modelUser->iUpdatedAt = time();

                    if ($modelUser->save()) {
                        $email = explode('@', $modelUser['vEmail']);
                        $rest = substr($email[0], 0, 3);
                        $string = str_repeat('*', strlen($email[0]) - 3);
                        $newEmail = $rest . $string . '@' . $email[1];
                        $mailSend = Yii::$app->mailer->compose('passwordReset', ['user' => $modelUser, 'vPassword' => $randomPassword])
                                ->setFrom([Yii::$app->params['SMTP_FROM_EMAIL'] => Yii::$app->name])
                                ->setTo($params['vEmail'])
                                ->setSubject(' Reset your ' . Yii::$app->name . ' Password')
                                ->send();

                        if ($mailSend == 1) {
                            $transaction->commit();
                            return SuccessResponse::withData(OK, Yii::t('response', 'forgot_password_success'));
                        } else {
                            $transaction->rollBack();
                            return ErrorResponse::withData(BAD_REQUEST, Yii::t('response', 'mail_send_error'));
                        }
                    } else {
                        $transaction->rollBack();
                        return ErrorResponse::withData(BAD_REQUEST, current($modelUser->getFirstErrors()));
                    }
                }
            }
        } catch (\Exception $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        }
    }

    /**
     * Social Sign In
     * @param int $length - Length of Password - Default 6
     * @return string
     * @author VB Panchal <yagnesh.spaceo@gmail.com>
     */
    public function generateRandomPassword($length = 6) {
        $chars = "53b707b53499965f93905d7c8f59e1f1146c05aeabcdefghijkmnopqrstuvwxyz023456789";
        $i = 0;
        $pass = '';
        while ($i <= $length) {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $pass = $pass . $tmp;
            $i++;
        }
        return $pass;
    }

    public function socialSignin($params) {
        $transaction = Yii::$app->db->beginTransaction(Transaction::SERIALIZABLE);
        try {
            $modelUser = new UserMaster();
            $modelUser->scenario = SCH_SOCIAL_SIGNIN;
            $modelUser->attributes = $params;
            if (!$modelUser->validate()) {
                return ErrorResponse::withData(BAD_REQUEST, current($modelUser->getFirstErrors()));
            } else {
                $response = Yii::$app->social->getSocialId($params['service'], $transaction, $params['accessToken']);

                if ($response->getResponseCode() == OK) {
                    $responseData = $response->getResponseModel();
                    $iUserId = $responseData->iUserId;
                    $modelUser = static::find()->where(['iUserId' => $iUserId])->one();
                    if (!empty($modelUser)) {
                        if ($modelUser->tiIsActive == 0 || $modelUser->tiIsDeleted == 1) {
                            $transaction->rollBack();
                            return ErrorResponse::withData(BAD_REQUEST, Yii::t('response', 'account_inactive'));
                        } else {
                            UserDeviceMaster::deleteAll(['iUserId' => $modelUser->iUserId]);
                            $modelDevice = new UserDeviceMaster();
                            $modelDevice->scenario = SCH_SIGNIN;
                            $modelDevice->attributes = $params;
                            $modelDevice->iUserId = $modelUser->iUserId;
                            $vAuthKey = md5($modelUser->vEmail . $modelUser->iUserId . time());
                            $modelDevice->vAuthKey = $vAuthKey;
                            $modelDevice->iCreatedAt = time();
                            if ($modelDevice->save()) {
                                $transaction->commit();
                                $modelUser->vAuthKey = $vAuthKey;
                                $responseData = UserMasterResponseData::withModel($modelUser);
                                $finalResponse = new UserMasterResponse();
                                $finalResponse->setResponseCode(OK);
                                $finalResponse->setResponseMessage(Yii::t('response', 'signin_success'));
                                $finalResponse->setResponseData($responseData->showEverything());
                                return $finalResponse;
                            } else {
                                $transaction->rollBack();
                                return ErrorResponse::withData(BAD_REQUEST, current($modelDevice->getFirstErrors()));
                            }
                        }
                    } else {
                        $transaction->rollBack();
                        return ErrorResponse::withData(BAD_REQUEST, Yii::t('response', 'social_signin_fail'));
                    }
                } else {
                    $transaction->rollBack();
                    return $response;
                }
            }
        } catch (\Exception $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        }
    }

    /**
     * Change password
     * @param \api\modules\v1\controllers\UserController $request
     * @author VB Panchal <yagnesh.spaceo@gmail.com>
     */
    public function changePassword($request) {
        $transaction = Yii::$app->db->beginTransaction(Transaction::SERIALIZABLE);
        try {
            $params = $request->bodyParams;
            $modelUser = $request->iUser;
            $modelUser->scenario = SCH_CHANGE_PASSWORD;
            $modelUser->attributes = $params;
            $modelUser->currentPassword = md5($params['currentPassword']);
            if (!$modelUser->validate()) {
                return ErrorResponse::withData(BAD_REQUEST, current($modelUser->getFirstErrors()));
            }
            $params['vPassword'] = md5($modelUser->vNewPassword);
            $params['currentPassword'] = md5($modelUser->vNewPassword);
            $modelUser->iPasswordExpireAt = NULL;
            $response = Yii::$app->apptransaction->update($modelUser, $params, $transaction, SCH_CHANGE_PASSWORD);
            if ($response->getResponseCode() != OK) {
                return $response;
            }
            $transaction->commit();
            $modelUser = $response->getResponseModel();
            $responseData = UserMasterResponseData::withModel($modelUser, $request->headers['Authorization']);
            return UserMasterResponse::withData(OK, Yii::t('response', 'change_password_success'), $responseData->showEverything());
        } catch (\Exception $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        }
    }

    /** Edit Profile
     * @param \api\modules\v1\controllers\UserController $request
     * @author VB Panchal <yagnesh.spaceo@gmail.com>
     */
    public function editProfile($request) {
        $transaction = Yii::$app->db->beginTransaction(Transaction::SERIALIZABLE);
        try {
            $params = $request->bodyParams;
            $modelUser = $request->iUser;
            $profilePicName = NULL;
            $vProfilePic = UploadedFile::getInstanceByName('vProfilePic');
            if (!empty($vProfilePic)) {
                $params['vProfilePic'] = time() . '.' . $vProfilePic->extension;
            }
            $model = new UserMaster();
            $model->scenario = SCH_UPDATE_PROFILE;
            $model->attributes = $params;
            if ($model->validate()) {
                $response = Yii::$app->apptransaction->update($modelUser, $params, $transaction, SCH_UPDATE_PROFILE);
                if ($response->getResponseCode() == OK) {
                    $modelUser = $response->getResponseModel();
                    if ($modelUser->vMobileNumber != $modelUser->vNewMobileNumber || $modelUser->vISDCode != $modelUser->vNewISDCode) {
                        $responceOtp = static::sendOTP($modelUser);
                        if ($responceOtp->getResponseCode() != OK) {
                            return $responceOtp;
                        }
                    }
                    $dir = Yii::getAlias('@uploads') . '/user/' . $modelUser->iUserId;
                    if (!is_dir($dir)) {
                        Yii::$app->generallib->createDir($dir);
                    }
                    if (!empty($vProfilePic) && !$vProfilePic->saveAs($dir . '/' . $modelUser->vProfilePic)) {
                        $transaction->rollBack();
                        return ErrorResponse::withData(BAD_REQUEST, Yii::t('response', 'error_in_file_upload'));
                    }
                    $transaction->commit();
                    $responseData = UserMasterResponseData::withModel($modelUser, $request->headers['Authorization']);
                    return UserMasterResponse::withData(OK, Yii::t('response', 'edit_profile_success'), $responseData->showEverything());
                } else {
                    $transaction->rollBack();
                    return $response;
                }
            } else {
                $transaction->rollBack();
                return ErrorResponse::withData(BAD_REQUEST, current($model->getFirstErrors()));
            }
        } catch (\Exception $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        }
    }

    /** Sign Out
     * @param \api\modules\v1\controllers\UserController $request
     * @author VB Panchal <yagnesh.spaceo@gmail.com>
     */
    public function signOut($request) {
        $transaction = Yii::$app->db->beginTransaction(Transaction::SERIALIZABLE);
        try {
            $modelDevice = $request->iDevice;
            if ($modelDevice->delete()) {
                $transaction->commit();
                return SuccessResponse::withData(OK, Yii::t('response', 'signout_success'));
            } else {
                $transaction->rollBack();
                return ErrorResponse::withData(BAD_REQUEST, Yii::t('response', 'signout_failed'));
            }
            $vAuthKey = $request->headers['Authorization'];
        } catch (\Exception $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        }
    }

    /** Sign Out
     * @param \api\modules\v1\controllers\UserController $request
     * @author VB Panchal <yagnesh.spaceo@gmail.com>
     */
    public function myProfile($request) {
        $transaction = Yii::$app->db->beginTransaction(Transaction::SERIALIZABLE);
        try {
            $params = $request->queryParams;
            $modelUser = $request->iUser;
            $vAuthKey = $request->headers['Authorization'];
            $responseData = UserMasterResponseData::withModel($modelUser, $request->headers['Authorization']);
            return UserMasterResponse::withData(OK, Yii::t('response', 'edit_profile_success'), $responseData->showEverything());
        } catch (\Exception $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        }
    }

    /**
     * 
     * @param self $modelUser
     * @return type
     */
    public static function sendOTP($modelUser) {
        try {
            if (empty($modelUser->vOTP) || $modelUser->iOTPExpireAt <= time()) {
                $modelUser->vOTP = rand(1000, 9999);
                $modelUser->iOTPExpireAt = time() + 900;
                $modelUser->tiIsMobileVerified = 0;
            }
            if ($modelUser->save()) {
                $vISDCode = $modelUser->vNewISDCode ?? $modelUser->vISDCode;
                $vMobileNumber = $modelUser->vNewMobileNumber ?? $modelUser->vMobileNumber;
                $msg = Yii::$app->name . ' One-time Pin (OTP) is ' . $modelUser->vOTP . ' and will be valid for 15 minutes from the time of generation.';
                $response = Yii::$app->generallib->twilioSend($vISDCode . $vMobileNumber, $msg);
                return $response;
            } else {
                $transaction->rollBack();
                return ErrorResponse::withData(BAD_REQUEST, current($modelUser->getFirstErrors()));
            }
        } catch (\Exception $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        }
    }

    public function getResponseData($vAuthKey = NULL) {
        $responseData = UserMasterResponseData::withModel($this, $vAuthKey);
        return $responseData->showEverything();
    }

    public function sendWelcomeMail($params = NULL) {
        try {
            $toEmail = $this->vEmail;
            $mailSend = Yii::$app->mailer->compose('welcomeMailUser', ['modelUser' => $this])
                    ->setFrom([Yii::$app->params['SMTP_FROM_EMAIL'] => Yii::$app->name])
                    ->setTo($toEmail)
                    ->setSubject('Welcome to ' . Yii::$app->name)
                    ->send();
        } catch (\Exception $ex) {
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        }
    }

}
