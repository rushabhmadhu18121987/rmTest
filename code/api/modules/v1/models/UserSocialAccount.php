<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "user_social_account".
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
class UserSocialAccount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_social_account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['iUserId', 'vSocialId', 'iCreatedAt'], 'required'],
            [['iUserId', 'iCreatedAt', 'iUpdatedAt'], 'integer'],
            [['vSocialId', 'vProfileUrl', 'vImageUrl'], 'string', 'max' => 255],
            [['tiSocialType'], 'string', 'max' => 1],
            [['iUserId'], 'exist', 'skipOnError' => true, 'targetClass' => UserMaster::className(), 'targetAttribute' => ['iUserId' => 'iUserId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iSocialId' => 'I Social ID',
            'iUserId' => 'I User ID',
            'vSocialId' => 'V Social ID',
            'tiSocialType' => 'Ti Social Type',
            'vProfileUrl' => 'V Profile Url',
            'vImageUrl' => 'V Image Url',
            'iCreatedAt' => 'I Created At',
            'iUpdatedAt' => 'I Updated At',
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
