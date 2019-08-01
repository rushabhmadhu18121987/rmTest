<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "admin_announcements".
 *
 * @property int $iAnnouncementId
 * @property string $vSubject
 * @property string $vMessage
 * @property int $tiNotificationReceiver 0-Both , 1-Customer, 2 - Business Provider
 * @property int $iCreatedAt
 * @property int $tiIsDeleted 1-Yes,0-No
 * 
 * @property AdminAnnouncementReceiver[] $adminAnnouncementReceivers 
 */
class AdminAnnouncements extends \yii\db\ActiveRecord {

    const NOTIFICATION_TYPE = 1;

    public $iUsers;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'admin_announcements';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['tiNotificationReceiver', 'iCreatedAt', 'tiIsDeleted'], 'integer', 'on' => [SCH_CREATE, SCH_UPDATE]],
            [['vMessage', 'tiNotificationReceiver', 'iCreatedAt'], 'required', 'on' => [SCH_CREATE, SCH_UPDATE]],
            [['iUsers'], 'required', 'when' => function ($model) {
                    return in_array($model->tiNotificationReceiver, [1, 2]);
                }, 'enableClientValidation' => true, 'on' => [SCH_CREATE, SCH_UPDATE]
            ],
            [['vSubject'], 'string', 'max' => 50, 'on' => [SCH_CREATE, SCH_UPDATE]],
            [['vMessage'], 'string', 'max' => 255, 'on' => [SCH_CREATE, SCH_UPDATE]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'iAnnouncementId' => 'Announcement ID',
            'vSubject' => 'Subject',
            'vMessage' => 'Message',
            'iUsers' => 'Users',
            'tiNotificationReceiver' => 'Notification Receiver',
            'iCreatedAt' => 'Created At',
            'tiIsDeleted' => 'Is Deleted',
        ];
    }

    public function sendNotification() {
        $receiverUserIds = ArrayHelper::getColumn($this->adminAnnouncementReceivers, 'iUserId');
        if (!empty($receiverUserIds)) {
            $notificationData = [];
            foreach ($receiverUserIds as $key => $iUserId) {
                $notificationDetail = [
                    'iUserId' => $iUserId,
                    'iEntryId' => $this->iAnnouncementId,
                    'tiNotificationType' => self::NOTIFICATION_TYPE,
                    'vNotificationTitle' => \Yii::t('response', 'admin_annoncement_received'),
                    'vNotificationDesc' => $this->vMessage,
                    'iCreatedAt' => time()
                ];
                $notification = new UserNotification();
                $notification->attributes = $notificationDetail;
                if ($notification->save()) {
                    $notificationDetail['iUserNotificationId'] = $notification->iUserNotificationId;
                    Yii::$app->generallib->sendFCMNotification($notificationDetail, $iUserId);
                }
            }
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdminAnnouncementReceivers() {
        return $this->hasMany(AdminAnnouncementReceiver::className(), ['iAnnouncementId' => 'iAnnouncementId']);
    }

}
