<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "user_master".
 *
 * @property int $iUserId
 * @property string $vName
 * @property string $vUserName
 * @property string $vPassword
 * @property string $vEmailId
 * @property string $vLocation
 * @property int $tiGender 1-Male,2-Female,3-Other
 * @property string $vMobileNumber
 * @property string $vISDCode
 * @property int $tiIsSocialLogin 1-Yes, 0-No
 * @property string $vProfilePic
 * @property string $vPasswordResetToken
 * @property int $iTotalCoin
 * @property int $iTotalBoost
 * @property int $iSwap 
 * @property int $tiIsActive 1-Active,0-Inactive
 * @property int $tiIsDeleted 1-Deleted,0-NotDelete
 * @property int $iCreatedAt
 * @property int $iUpdatedAt
 *
 * @property ChallengeComment[] $challengeComments
 * @property ChallengesInviters[] $challengesInviters
 * @property ChallengesReport[] $challengesReports
 * @property ChallengesVote[] $challengesVotes
 * @property ContactUs[] $contactuses
 * @property DeviceMaster[] $deviceMasters
 * @property MessageSystem[] $messageSystems
 * @property MessageSystem[] $messageSystems0
 * @property Subscription[] $subscriptions
 * @property UserCategories[] $userCategories
 * @property UserFollow[] $userFollows
 * @property UserFollow[] $userFollows0
 * @property UserSocialAccount[] $userSocialAccounts
 * @property UsersNotifications[] $usersNotifications
 */
class UserMaster extends \yii\db\ActiveRecord {

    public $confirmPassword;

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
            [['vPassword', 'confirmPassword'], 'required', 'on' => 'reset_password'],
            ['confirmPassword', 'compare', 'compareAttribute' => 'vPassword', 'message' => "Password and Confirm Password not match", 'on' => 'reset_password'],
            ['vPassword', 'string', 'min' => 8],
            [['tiGender', 'tiIsSocialLogin', 'iTotalCoin', 'iTotalBoost', 'iSwap', 'tiIsActive', 'tiIsDeleted', 'iCreatedAt', 'iUpdatedAt'], 'integer'],
            [['iCreatedAt'], 'required'],
            [['vName', 'vUserName', 'vProfilePic'], 'string', 'max' => 30],
            [['vPassword', 'vLocation', 'vPasswordResetToken'], 'string', 'max' => 255],
            [['vEmailId'], 'string', 'max' => 100],
            [['vMobileNumber'], 'string', 'max' => 20],
            [['vISDCode'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'iUserId' => 'User ID',
            'vName' => 'Name',
            'vUserName' => 'User Name',
            'vPassword' => 'Password',
            'vEmailId' => 'Email ID',
            'vLocation' => 'Location',
            'tiGender' => 'Gender',
            'vMobileNumber' => 'Mobile Number',
            'vISDCode' => 'Isdcode',
            'tiIsSocialLogin' => 'Social Login',
            'vProfilePic' => 'Profile Pic',
            'vPasswordResetToken' => 'Password Reset Token',
            'iTotalCoin' => 'Total Coin',
            'iTotalBoost' => 'Boost',
            'iSwap' => 'Swap',
            'tiIsActive' => 'Ti Status',
            'tiIsDeleted' => 'Ti Is Deleted',
            'iCreatedAt' => 'I Created At',
            'iUpdatedAt' => 'I Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChallengeComments() {
        return $this->hasMany(ChallengeComment::className(), ['iUserId' => 'iUserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChallengesInviters() {
        return $this->hasMany(ChallengesInviters::className(), ['iUserId' => 'iUserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChallengesReports() {
        return $this->hasMany(ChallengesReport::className(), ['iUserId' => 'iUserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChallengesVotes() {
        return $this->hasMany(ChallengesVote::className(), ['iUserId' => 'iUserId']);
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
    public function getMessageSystems() {
        return $this->hasMany(MessageSystem::className(), ['iFromUserId' => 'iUserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessageSystems0() {
        return $this->hasMany(MessageSystem::className(), ['iToUserId' => 'iUserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubscriptions() {
        return $this->hasMany(Subscription::className(), ['iUserId' => 'iUserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserCategories() {
        return $this->hasMany(UserCategories::className(), ['iUserId' => 'iUserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserFollows() {
        return $this->hasMany(UserFollow::className(), ['iFromUserId' => 'iUserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserFollows0() {
        return $this->hasMany(UserFollow::className(), ['iToUserId' => 'iUserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserSocialAccounts() {
        return $this->hasMany(UserSocialAccount::className(), ['iUserId' => 'iUserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersNotifications() {
        return $this->hasMany(UsersNotifications::className(), ['iUserId' => 'iUserId']);
    }

    public static function findByPasswordResetToken($token) {
        $expire = \Yii::$app->params['PASSWORD_RESET_TOKEN_EXPIRE'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return static::findOne([
                    'vPasswordResetToken' => $token
        ]);
    }

}
