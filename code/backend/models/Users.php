<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $iUserId
 * @property string $vAuthKey
 * @property string $vRecipientId
 * @property string $vEmail
 * @property string $vPassword
 * @property string $vFacebookId
 * @property string $vGoogleId
 * @property string $vFirstName
 * @property string $vLastName
 * @property string $vProfilePic 
 * @property int $tiLanguage 1=en, 2=es
 * @property double $fTotBalance
 * @property int $tiDeviceType
 * @property string $vDeviceToken
 * @property int $tiAcceptPush
 * @property string $vPasswordResetToken
 * @property int $iCreatedAt
 * @property int $tiIsActive
 * @property int $tiIsDelete
 */
class Users extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'user';
    }

    public static function find($query = null) {
        return parent::find($query)->andWhere([Users::tableName() . '.tiIsDeleted' => 0,]);
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['tiLanguage', 'tiDeviceType', 'tiAcceptPush', 'iCreatedAt', 'tiIsActive', 'tiIsDelete'], 'integer'],
            [['fTotBalance'], 'number'],
            [['iCreatedAt'], 'required'],
            [['vAuthKey', 'vRecipientId', 'vFacebookId', 'vGoogleId', 'vDeviceToken', 'vPasswordResetToken'], 'string', 'max' => 255],
            [['vEmail', 'vPassword'], 'string', 'max' => 100],
            [['vFirstName', 'vLastName', 'vProfilePic'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'iUserId' => 'User ID',
            'vAuthKey' => 'Auth Key',
            'vRecipientId' => 'Recipient ID',
            'vEmail' => 'Email ID',
            'vPassword' => 'Password',
            'vFacebookId' => 'Facebook ID',
            'vGoogleId' => 'Google ID',
            'vFirstName' => 'First Name',
            'vLastName' => 'Last Name',
            'vProfilePic' => 'Profile Pic',
            'tiLanguage' => 'Language',
            'fTotBalance' => 'Total Balance',
            'tiDeviceType' => 'Device Type',
            'vDeviceToken' => 'Device Token',
            'tiAcceptPush' => 'Accept Push',
            'vPasswordResetToken' => 'Password Reset Token',
            'iCreatedAt' => 'Created At',
            'tiIsActive' => 'Status',
            'tiIsDelete' => 'Is Delete',
        ];
    }

}
