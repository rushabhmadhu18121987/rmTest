<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user_master".
 *
 * @property int $iUserId
 * @property string $vEmail
 * @property string $cPassword
 * @property string $vMobileNumber
 * @property string $vName
 * @property string $vLangISOCode
 * @property int $tiGender 1=Male, 2=Female, 3=Other
 * @property string $dDOB
 * @property string $vProfilePic
 * @property int $tiIsMobileVerified
 * @property int $tiIsProfileCompleted
 * @property int $tiIsEventPlanner 1-Yes, 0-No
 * @property int $iOTP
 * @property int $iOTPExpireAt
 * @property int $iNotiBadgeCount
 * @property int $tiIsSocialLogin
 * @property int $tiIsAcceptPush
 * @property string $vPasswordResetToken
 * @property int $tiIsActive
 * @property int $tiIsDeleted
 * @property int $iCreatedAt
 * @property int $iUpdatedAt
 *
 * @property BusinessMaster[] $businessMasters
 * @property ContactUs[] $contactuses
 * @property DeviceMaster[] $deviceMasters
 * @property SocialMaster[] $socialMasters
 */
class UserMaster extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'user_master';
    }

    public static function find($query = null) {
        if ($query != -1) {
            return parent::find($query)->andWhere([ 'user_master.tiIsDeleted' => 0]);
        }else{
            return parent::find($query);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [[ 'tiGender', 'tiIsMobileVerified', 'tiIsProfileCompleted', 'tiIsEventPlanner', 'iOTP', 'iOTPExpireAt', 'iNotiBadgeCount', 'tiIsSocialLogin', 'tiIsAcceptPush', 'tiIsActive', 'tiIsDeleted', 'iCreatedAt', 'iUpdatedAt'], 'integer'],
            [['dDOB'], 'safe'],
            [['iCreatedAt'], 'required'],
            [['vEmail', 'vPasswordResetToken'], 'string', 'max' => 255],
            [['cPassword'], 'string', 'max' => 33],
            [['vMobileNumber'], 'string', 'max' => 25],
            [['vName'], 'string', 'max' => 50],
            [['vLangISOCode'], 'string', 'max' => 5],
            [['vProfilePic'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'iUserId' => Yii::t('admin', 'User ID'),
            'vEmail' => Yii::t('admin', 'Email ID'),
            'cPassword' => Yii::t('admin', 'Password'),
            'vMobileNumber' => Yii::t('admin', 'Mobile Number'),
            'vName' => Yii::t('admin', 'Full Name'),
          
            'vLangISOCode' => Yii::t('admin', 'Language'),
            'tiGender' => Yii::t('admin', 'Gender'),
            'dDOB' => Yii::t('admin', 'Birth Date'),
            'vProfilePic' => Yii::t('admin', 'Profile Pic'),
            'tiIsMobileVerified' => Yii::t('admin', 'Mobile Verified'),
            'tiIsProfileCompleted' => Yii::t('admin', 'Profile Completed'),
            'tiIsEventPlanner' => Yii::t('admin', 'Event Planner'),
            'iOTP' => Yii::t('admin', 'OTP'),
            'iOTPExpireAt' => Yii::t('admin', 'Otpexpire At'),
            'iNotiBadgeCount' => Yii::t('admin', 'Noti Badge Count'),
            'tiIsSocialLogin' => Yii::t('admin', 'Social Login'),
            'tiIsAcceptPush' => Yii::t('admin', 'Accept Push'),
            'vPasswordResetToken' => Yii::t('admin', 'Password Reset Token'),
            'tiIsActive' => Yii::t('admin', 'Active'),
            'tiIsDeleted' => Yii::t('admin', 'Deleted'),
            'iCreatedAt' => Yii::t('admin', 'Created At'),
            'iUpdatedAt' => Yii::t('admin', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessMasters() {
        return $this->hasMany(BusinessMaster::className(), ['iUserId' => 'iUserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContactuses() {
        return $this->hasMany(ContactUs::className(), ['iUserId' => 'iUserId']);
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
    public function getSocialMasters() {
        return $this->hasMany(SocialMaster::className(), ['iUserId' => 'iUserId']);
    }

}
