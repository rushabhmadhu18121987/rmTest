<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_master".
 *
 * @property int $iUserId
 * @property string $vFirstName
 * @property string $vLastName
 * @property string $vEmail
 * @property string $vMobileNumber
 * @property string $vPassword
 * @property string $vProfilePic
 * @property int $tiIsSocialLogin 1-Yes , 0-No
 * @property double $dbLatitude
 * @property double $dbLogitude
 * @property string $vOTP
 * @property int $iOTPExpireAt
 * @property int $tiIsMobileVerified 1-Yes , 0-No
 * @property string $vEjabberedId
 * @property string $vPasswordResetToken
 * @property int $iNotiBadgeCount
 * @property int $tiAcceptPush 1 - Yes , 0 - No
 * @property int $tiAcceptEmail 1 - Yes, 0 - No 
 * @property int $tiAcceptSMS 1 - Yes, 0 - No  
 * @property int $tiIsActive 1 - Active, 0 - Inactive
 * @property int $tiIsDeleted 1-Yes , 0-No
 * @property int $iCreatedAt
 * @property int $iUpdatedAt
 *
 * @property AdminAnnouncementReceiver[] $adminAnnouncementReceivers
 * @property EventInvite[] $eventInvites
 * @property EventInvite[] $eventInvites0
 * @property EventQuote[] $eventQuotes
 * @property EventQuote[] $eventQuotes0
 * @property UserDeviceMaster[] $userDeviceMasters
 * @property UserSocialAccount[] $userSocialAccounts
 * @property VendorPortfolio[] $vendorPortfolios
 * @property VendorServiceCategory[] $vendorServiceCategories
 */
class UserMaster extends \yii\db\ActiveRecord
{       

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vEmail'], 'required'],
            [['tiIsSocialLogin', 'iOTPExpireAt', 'tiIsMobileVerified', 'iNotiBadgeCount', 'tiAcceptPush', 'tiAcceptEmail', 'tiAcceptSMS', 'tiIsActive', 'tiIsDeleted', 'iCreatedAt', 'iUpdatedAt'], 'integer'],
            [['dbLatitude', 'dbLogitude'], 'number'],
            [['vFirstName', 'vLastName'], 'string', 'max' => 30],
            ['vProfilePic', 'image', 'extensions' => 'jpg,jpeg,png'],                        
            [['vFirstName', 'vLastName'], 'match', 'pattern' => '/^[a-zA-Z\s]*$/','message'=>Yii::t('app','Enter characters only.')],
            [['vEmail'], 'string', 'max' => 100],
            [['vMobileNumber'], 'string', 'max' => 20],
            [['vPassword', 'vEjabberedId', 'vPasswordResetToken'], 'string', 'max' => 255],
            [['vOTP'], 'string', 'max' => 6],
            [['vEmail'],'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'iUserId' => 'User ID',
            'vFirstName' => 'First Name',
            'vLastName' => 'Last Name',
            'vEmail' => 'Email',
            'vMobileNumber' => 'Mobile Number',
            'vPassword' => 'Password',
            'vProfilePic' => 'Profile Pic',
            'tiIsSocialLogin' => 'Is Social Login',
            'dbLatitude' => 'Latitude',
            'dbLogitude' => 'Logitude',
            'vOTP' => 'OTP',
            'iOTPExpireAt' => 'OTP Expire At',
            'tiIsMobileVerified' => 'Is Mobile Verified',
            'vEjabberedId' => 'Ejabbered ID',
            'vPasswordResetToken' => 'Password Reset Token',
            'iNotiBadgeCount' => 'Notification Badge Count',
            'tiAcceptPush' => 'Accept Push',
            'tiAcceptEmail' => 'Accept Email',
            'tiAcceptSMS' => 'Accept Sms',
            'tiIsActive' => 'Is Active',
            'tiIsDeleted' => 'Is Deleted',
            'iCreatedAt' => 'Created At',
            'iUpdatedAt' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdminAnnouncementReceivers()
    {
        return $this->hasMany(AdminAnnouncementReceiver::className(), ['iUserId' => 'iUserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventInvites()
    {
        return $this->hasMany(EventInvite::className(), ['iUserId' => 'iUserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventInvites0()
    {
        return $this->hasMany(EventInvite::className(), ['iInviteUserId' => 'iUserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventQuotes()
    {
        return $this->hasMany(EventQuote::className(), ['iUserId' => 'iUserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventQuotes0()
    {
        return $this->hasMany(EventQuote::className(), ['iVendorUserId' => 'iUserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserDeviceMasters()
    {
        return $this->hasMany(UserDeviceMaster::className(), ['iUserId' => 'iUserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserSocialAccounts()
    {
        return $this->hasMany(UserSocialAccount::className(), ['iUserId' => 'iUserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendorPortfolios()
    {
        return $this->hasMany(VendorPortfolio::className(), ['iUserId' => 'iUserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendorServiceCategories()
    {
        return $this->hasMany(VendorServiceCategory::className(), ['iUserId' => 'iUserId']);
    }
}
