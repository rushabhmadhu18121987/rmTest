<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "user_device_master".
 *
 * @property int $iDeviceId
 * @property int $iUserId
 * @property string $vAuthKey
 * @property string $vDeviceToken
 * @property int $tiDeviceType 0 - Web, 1 - iOs, 2 - Android
 * @property string $vDeviceName
 * @property int $iCreatedAt
 * @property int $iUpdatedAt
 * 
 * @property UserMaster $iUser
 */
class UserDeviceMaster extends \yii\db\ActiveRecord {

    public $badgeCount = 0;
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'user_device_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['vDeviceToken'], 'safe', 'on' => [SCH_SIGNIN, SCH_SIGNUP]],
            [['iUserId', 'tiDeviceType'], 'required', 'on' => [SCH_SIGNIN, SCH_SIGNUP]],
            [['vAuthKey', 'vDeviceToken'], 'string', 'max' => 255, 'on' => [SCH_SIGNIN, SCH_SIGNUP]],
            [['vDeviceName'], 'string', 'max' => 100, 'on' => [SCH_SIGNIN, SCH_SIGNUP]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'iDeviceId' => 'Device ID',
            'iUserId' => 'User ID',
            'vAuthKey' => 'Auth Key',
            'vDeviceToken' => 'Device Token',
            'tiDeviceType' => 'Device Type',
            'vDeviceName' => 'Device Name',
            'iCreatedAt' => 'Created At',
            'iUpdatedAt' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery 
     */
    public function getIUser() {
        return $this->hasOne(UserMaster::className(), ['iUserId' => 'iUserId']);
    }

}
