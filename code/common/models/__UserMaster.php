<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_master".
 *
 * @property int $iUserId
 * @property string $vUserName
 * @property string $vFirstName
 * @property string $vLastName
 * @property string $vEmail
 * @property string $vMobileNumber
 * @property string $vPassword
 * @property int $bSocialType
 * @property string $vPasswordResetToken
 * @property int $tiIsActive 0=> Active 1=> Inactive
 * @property int $iCreatedAt
 * @property int $iUpdatedAt
 *
 * @property DeviceMaster[] $deviceMasters
 * @property MediaMaster[] $mediaMasters
 * @property UserSocialAccount[] $userSocialAccounts
 */
class UserMaster extends \yii\db\ActiveRecord implements \OAuth2\Storage\UserCredentialsInterface {

    public $id, $text;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'user_master';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['iCreatedAt'], 'required'],
            [['iCreatedAt', 'iUpdatedAt'], 'integer'],
            [['vUserName', 'vFirstName', 'vLastName'], 'string', 'max' => 50],
            [['vEmail'], 'string', 'max' => 100],
            [['vMobileNumber'], 'string', 'max' => 20],
            [['vPassword', 'vPasswordResetToken'], 'string', 'max' => 255],
            [['bSocialType', 'tiIsActive'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'iUserId' => 'I User ID',
            'vUserName' => 'V User Name',
            'vFirstName' => 'V First Name',
            'vLastName' => 'V Last Name',
            'vEmail' => 'V Email ID',
            'vMobileNumber' => 'V Mobile Number',
            'vPassword' => 'V Password',
            'bSocialType' => 'B Social Type',
            'vPasswordResetToken' => 'V Password Reset Token',
            'tiIsActive' => 'Ti Is Active',
            'iCreatedAt' => 'I Created At',
            'iUpdatedAt' => 'I Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeviceMasters() {
        return $this->hasMany(DeviceMaster::className(), ['iUserId' => 'iUserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediaMasters() {
        return $this->hasMany(MediaMaster::className(), ['iUserId' => 'iUserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserSocialAccounts() {
        return $this->hasMany(UserSocialAccount::className(), ['iUserId' => 'iUserId']);
    }

    /**
     * Implemented for Oauth2 Interface
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        /** @var \filsh\yii2\oauth2server\Module $module */
        $module = Yii::$app->getModule('oauth2');
        $token = $module->getServer()->getResourceController()->getToken();
        return !empty($token['user_id']) ? static::findIdentity($token['user_id']) : null;
    }

    /**
     * Implemented for Oauth2 Interface
     */
    public function checkUserCredentials($username, $password) {
        $user = static::findByUsername($username);
        if (empty($user)) {
            return false;
        }
        return $user->validatePassword($password);
    }

    /**
     * Implemented for Oauth2 Interface
     */
    public function getUserDetails($username) {
        $user = static::findByUsername($username);
        return ['user_id' => $user->getId()];
    }

}
