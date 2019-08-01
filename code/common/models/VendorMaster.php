<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "vendor_master".
 *
 * @property int $iVendorId
 * @property string $vEmail
 * @property string $vMobileNumber
 * @property string $vPassword
 * @property string $vProfilePic
 * @property string $vBusinessName
 * @property string $vWebsite
 * @property string $vCountry
 * @property string $vState
 * @property string $vCity
 * @property double $dbLatitude
 * @property double $dbLogitude
 * @property string $vEjabberedId
 * @property string $vStripeCustomerId
 * @property string $vStripeCardId
 * @property string $vSubscriptionId
 * @property string $vPasswordResetToken
 * @property int $iNotiBadgeCount
 * @property int $tiAcceptPush 1 - Yes , 0 - No
 * @property int $tiAcceptEmail 1 - Yes, 0 - No 
 * @property int $tiAcceptSMS 1 - Yes, 0 - No  
 * @property int $tiVerificationStatus 0 - Pending, 1 - Verified, 2 - Declined
 * @property int $tiIsActive 1 - Active, 0 - Inactive
 * @property int $tiIsDeleted 1-Yes , 0-No
 * @property int $iCreatedAt
 * @property int $iUpdatedAt
 *
 * @property EventQuote[] $eventQuotes
 * @property VendorPortfolio[] $vendorPortfolios
 * @property VendorServiceCategory[] $vendorServiceCategories
 */
class VendorMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vendor_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vEmail', 'iCreatedAt','vBusinessName'], 'required'],
            [['vEmail'], 'unique'],
            ['vEmail', 'email'],
            [['dbLatitude', 'dbLogitude'], 'number'],
            [['iNotiBadgeCount', 'tiAcceptPush', 'tiAcceptEmail', 'tiAcceptSMS', 'tiVerificationStatus', 'tiIsActive', 'tiIsDeleted', 'iCreatedAt', 'iUpdatedAt'], 'integer'],
            [['vEmail', 'vCountry', 'vState', 'vCity'], 'string', 'max' => 100],
            [['vMobileNumber'], 'string', 'max' => 20],
            [['vPassword', 'vWebsite', 'vEjabberedId', 'vStripeCustomerId', 'vStripeCardId', 'vSubscriptionId', 'vPasswordResetToken'], 'string', 'max' => 255],
            [['vProfilePic'], 'string', 'max' => 30],
            [['vBusinessName'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'iVendorId' => 'Vendor ID',
            'vEmail' => 'Email',
            'vMobileNumber' => 'Mobile Number',
            'vPassword' => 'Password',
            'vProfilePic' => 'Profile Pic',
            'vBusinessName' => 'Business Name',
            'vWebsite' => 'Website',
            'vCountry' => 'Country',
            'vState' => 'State',
            'vCity' => 'City',
            'dbLatitude' => 'Latitude',
            'dbLogitude' => 'Logitude',
            'vEjabberedId' => 'Ejabbered ID',
            'vStripeCustomerId' => 'Stripe Customer ID',
            'vStripeCardId' => 'Stripe Card ID',
            'vSubscriptionId' => 'Subscription ID',
            'vPasswordResetToken' => 'Password Reset Token',
            'iNotiBadgeCount' => 'Notification Badge Count',
            'tiAcceptPush' => 'Accept Push',
            'tiAcceptEmail' => 'Accept Email',
            'tiAcceptSMS' => 'Accept Sms',
            'tiVerificationStatus' => 'Verification Status',
            'tiIsActive' => 'Is Active',
            'tiIsDeleted' => 'Is Deleted',
            'iCreatedAt' => 'Created At',
            'iUpdatedAt' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventQuotes()
    {
        return $this->hasMany(EventQuote::className(), ['iVendorId' => 'iVendorId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendorPortfolios()
    {
        return $this->hasMany(VendorPortfolio::className(), ['iVendorId' => 'iVendorId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendorServiceCategories()
    {
        return $this->hasMany(VendorServiceCategory::className(), ['iVendorId' => 'iVendorId']);
    }
}
