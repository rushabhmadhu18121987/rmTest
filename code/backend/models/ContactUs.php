<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "contact_us".
 *
 * @property int $iContactId
 * @property int $iUserId
 * @property string $vEmail
 * @property string $txMessage
 * @property int $tiStatus 1=Requested, 2=Completed
 * @property int $iCreatedAt
 *
 * @property UserMaster $iUser
 */
class ContactUs extends \yii\db\ActiveRecord {
    
    public $vName;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'contact_us';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['iUserId', 'vEmail', 'txMessage', 'iCreatedAt'], 'required'],
            [['iUserId', 'tiStatus', 'iCreatedAt'], 'integer'],
            [['txMessage'], 'string'],
            [['vEmail'], 'string', 'max' => 255],
            [['iUserId'], 'exist', 'skipOnError' => true, 'targetClass' => UserMaster::className(), 'targetAttribute' => ['iUserId' => 'iUserId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'iContactId' => Yii::t('admin', 'Contact ID'),
            'iUserId' => Yii::t('admin', 'User ID'),
            'vName' => Yii::t('admin', 'Full Name'),
            'vEmail' => Yii::t('admin', 'Email ID'),
            'txMessage' => Yii::t('admin', 'Message'),
            'tiStatus' => Yii::t('admin', 'Status'),
            'iCreatedAt' => Yii::t('admin', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIUser() {
        return $this->hasOne(\common\models\UserMaster::className(), ['iUserId' => 'iUserId']);
    }

}
