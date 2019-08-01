<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "social_master".
 *
 * @property int $iSocialId
 * @property int $iUserId
 * @property string $vSocialId
 * @property int $tiSocialType 1 - Facebook, 2 - Google
 * @property string $vProfileUrl
 * @property string $vImageUrl
 * @property int $iCreatedAt
 * @property int $iUpdatedAt
 *
 * @property UserMaster $iUser
 */
class SocialMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'social_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iUserId', 'vSocialId', 'iCreatedAt'], 'required'],
            [['iUserId', 'tiSocialType', 'iCreatedAt', 'iUpdatedAt'], 'integer'],
            [['vSocialId', 'vProfileUrl', 'vImageUrl'], 'string', 'max' => 255],
            [['iUserId'], 'exist', 'skipOnError' => true, 'targetClass' => UserMaster::className(), 'targetAttribute' => ['iUserId' => 'iUserId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'iSocialId' => Yii::t('admin', 'I Social ID'),
            'iUserId' => Yii::t('admin', 'I User ID'),
            'vSocialId' => Yii::t('admin', 'V Social ID'),
            'tiSocialType' => Yii::t('admin', 'Ti Social Type'),
            'vProfileUrl' => Yii::t('admin', 'V Profile Url'),
            'vImageUrl' => Yii::t('admin', 'V Image Url'),
            'iCreatedAt' => Yii::t('admin', 'I Created At'),
            'iUpdatedAt' => Yii::t('admin', 'I Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIUser()
    {
        return $this->hasOne(UserMaster::className(), ['iUserId' => 'iUserId']);
    }
}
