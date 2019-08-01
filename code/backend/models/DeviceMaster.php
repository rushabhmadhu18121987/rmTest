<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "device_master".
 *
 * @property int $iDeviceId
 * @property int $iUserId
 * @property string $vAccessToken
 * @property string $vDeviceToken
 * @property int $tiDeviceType 0 - Web, 1 - iOs, 2 - Android
 * @property string $vDeviceName
 * @property int $iCreatedAt
 * @property int $iUpdatedAt
 *
 * @property UserMaster $iUser
 */
class DeviceMaster extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'device_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['iUserId', 'tiDeviceType', 'iCreatedAt', 'iUpdatedAt'], 'integer'],
            [['iCreatedAt'], 'required'],
            [['vAccessToken', 'vDeviceToken', 'vDeviceName'], 'string', 'max' => 255],
            [['iUserId'], 'exist', 'skipOnError' => true, 'targetClass' => UserMaster::className(), 'targetAttribute' => ['iUserId' => 'iUserId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'iDeviceId' => Yii::t('admin', 'I Device ID'),
            'iUserId' => Yii::t('admin', 'I User ID'),
            'vAccessToken' => Yii::t('admin', 'V Access Token'),
            'vDeviceToken' => Yii::t('admin', 'V Device Token'),
            'tiDeviceType' => Yii::t('admin', 'Ti Device Type'),
            'vDeviceName' => Yii::t('admin', 'V Device Name'),
            'iCreatedAt' => Yii::t('admin', 'I Created At'),
            'iUpdatedAt' => Yii::t('admin', 'I Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIUser() {
        return $this->hasOne(UserMaster::className(), ['iUserId' => 'iUserId']);
    }

}
