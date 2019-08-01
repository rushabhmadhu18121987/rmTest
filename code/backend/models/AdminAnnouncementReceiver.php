<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "admin_announcement_receiver".
 *
 * @property int $iAnnouncementReceiverId
 * @property int $iAnnouncementId
 * @property int $iUserId
 * @property int $iCreatedAt
 *
 * @property UserMaster $iUser
 * @property AdminAnnouncements $iAnnouncement
 */
class AdminAnnouncementReceiver extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin_announcement_receiver';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iAnnouncementId', 'iUserId', 'iCreatedAt'], 'required'],
            [['iAnnouncementId', 'iUserId', 'iCreatedAt'], 'integer'],
            [['iUserId'], 'exist', 'skipOnError' => true, 'targetClass' => UserMaster::className(), 'targetAttribute' => ['iUserId' => 'iUserId']],
            [['iAnnouncementId'], 'exist', 'skipOnError' => true, 'targetClass' => AdminAnnouncements::className(), 'targetAttribute' => ['iAnnouncementId' => 'iAnnouncementId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'iAnnouncementReceiverId' => 'I Announcement Receiver ID',
            'iAnnouncementId' => 'I Announcement ID',
            'iUserId' => 'I User ID',
            'iCreatedAt' => 'I Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIUser()
    {
        return $this->hasOne(UserMaster::className(), ['iUserId' => 'iUserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIAnnouncement()
    {
        return $this->hasOne(AdminAnnouncements::className(), ['iAnnouncementId' => 'iAnnouncementId']);
    }
}
