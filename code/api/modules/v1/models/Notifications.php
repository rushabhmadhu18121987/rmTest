<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "notifications".
 *
 * @property int $iNotificationId
 * @property int $iFromUserId
 * @property int $iToUserId
 * @property int $iEntryId
 * @property int $tiNotificationType 1=sendTips
 * @property string $vMessage
 * @property int $vBoldContent
 * @property int $tiNotificationReadFlag
 * @property int $iCreatedAt
 *
 * @property Users $iFromUser
 * @property Users $iToUser
 */
class Notifications extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'notifications';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['iFromUserId', 'iToUserId', 'iEntryId', 'tiNotificationType', 'tiNotificationReadFlag', 'iCreatedAt'], 'integer'],
            //[['iToUserId', 'iCreatedAt'], 'required'],
            [['vMessage', 'vBoldContent'], 'string', 'max' => 255],
//            [['iFromUserId'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['iFromUserId' => 'iUserId']],
//            [['iToUserId'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['iToUserId' => 'iUserId']],
            [['vMessage', 'vBoldContent'], 'default', 'value' => ""],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'iNotificationId' => 'Notification ID',
            'iFromUserId' => 'From User ID',
            'iToUserId' => 'To User ID',
            'iEntryId' => 'Entry ID',
            'tiNotificationType' => 'Notification Type',
            'vMessage' => 'Message',
            'vBoldContent' => 'Bold Content',
            'tiNotificationReadFlag' => 'Notification Read Flag',
            'iCreatedAt' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIFromUser() {
        return $this->hasOne(Users::className(), ['iUserId' => 'iFromUserId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIToUser() {
        return $this->hasOne(Users::className(), ['iUserId' => 'iToUserId']);
    }

    public function notification_list($params, $iUserId) {

        $limit = \Yii::$app->params['notification_limit'];
        $timestamp = (!empty($params['timestamp'])) ? $params['timestamp'] : time();

        if (!empty($params['pull']) && $params['pull'] == 'up') {
            $condQry = 'n.iCreatedAt > ' . $timestamp;
            $ordQry = 'n.iCreatedAt ASC';
        } else {
            $condQry = 'n.iCreatedAt < ' . $timestamp;
            $ordQry = 'n.iCreatedAt DESC';
        }

        $typeQry = 4;
        if (!empty($params['type'])) {
            switch ($params['type']) {
                case 1:
                    $typeQry = 'n.tiNotificationType = 1';
                    break;
                case 2:
                    $typeQry = 'n.tiNotificationType = 2';
                    break;
                case 3:
                    $typeQry = 'n.tiNotificationType IN(1,3)';
                    break;
                default:
                    $typeQry = 'n.tiNotificationType IN(2,4,5)';
            }
        }

        $modelNotifications = Notifications::find()->alias('n')
                ->innerJoin('users u', 'u.iUserId = n.iFromUserId')
                ->select(['n.iNotificationId', 'n.vMessage', 'IF(vBoldContent IS NOT NULL,vBoldContent,"") AS vBoldContent', new \yii\db\Expression('IF(vProfilePic IS NOT NULL,CONCAT("' . \Yii::$app->params['profilePic_url'] . '",u.iUserId,"/",u.vProfilePic),"' . \Yii::$app->params['defaultProfPic_url'] . '") AS vProfilePic'), 'u.vRecipientId', 'n.iCreatedAt AS timestamp', 'n.tiNotificationReadFlag'])
                ->where(['n.iToUserId' => $iUserId])
                ->andWhere($condQry)
                ->andWhere($typeQry)
                ->orderBy($ordQry)
                ->limit($limit)
                ->asArray()
                ->all();

        $sinceData = '';
        $maxData = '';
        $returnData = [];
        if (!empty($modelNotifications)) {
            $sinceData = current($modelNotifications);
            $sinceData = $sinceData['timestamp'];
            $maxData = end($modelNotifications);
            $maxData = $maxData['timestamp'];
            if (!empty($params['pull']) && $params['pull'] == 'up') {
                $modelNotifications = array_reverse($modelNotifications);
            }
            $cnt = 0;
            foreach ($modelNotifications AS $value) {
                $returnData[$cnt] = [
                    'iNotificationId' => $value['iNotificationId'],
                    'vMessage' => $value['vMessage'],
                    'vBoldContent' => $value['vBoldContent'],
                    'vProfilePic' => $value['vProfilePic'],
                    'vRecipientId' => $value['vRecipientId'],
                    'timestamp' => Yii::$app->common->time_ago($value['timestamp']),
                        //'isRead' => $value['tiNotificationReadFlag'],
                ];
                if (!empty($params['type']) && $params['type'] == 4) {
                    $returnData[$cnt]['isRead'] = $value['tiNotificationReadFlag'];
                }
                $cnt++;
            }
        }

        $response = ['response_code' => 200, 'response_message' => "Notification List.", 'response_data' => $returnData, 'response_since' => $sinceData, 'response_max' => $maxData];
        if (!empty($params['type']) && $params['type'] == 4) {
            $response['badge_count'] = Notifications::find()->where(['iToUserId' => $iUserId])->andWhere('tiNotificationReadFlag = 0 AND tiNotificationType IN(2,4,5)')->count();
        }
        return $response;
    }

    public function send_thank_you($params, $iUserId, $vRecipientId) {
        if (empty($params['vRecipientId'])) {
            return ['response_code' => 400, 'response_message' => 'Unauthorized'];
        }
        $modelUsers = Users::find()->where(['vRecipientId' => $params['vRecipientId']])->one();
        if (!empty($modelUsers)) {
            $toMsg = $vRecipientId . ' sent a thank you!';
            $postData = [
                'iUserId' => $iUserId,
                'iToUserId' => $modelUsers->iUserId,
                'iTipId' => NULL,
                'fromBoldContent' => 'thank you!',
                'toBoldContent' => 'thank you!',
                'fromMsg' => 'You sent ' . $params['vRecipientId'] . ' a thank you!',
                'toMsg' => $toMsg,
                'time' => time()
            ];

            self::from_notification_send($postData, $params['vRecipientId'], 3);
            self::to_notification_send($postData, $vRecipientId, 4, 1);
            Yii::$app->generallib->send_push($modelUsers, ['msg' => $toMsg, 'type' => 'sendThankYou']);
            return ['response_code' => 200, 'response_message' => 'You sent ' . $params['vRecipientId'] . ' a thank you!'];
        } else {
            return ['response_code' => 400, 'response_message' => 'Please Enter Valid Recipient Name.'];
        }
    }

    public function from_notification_send($postData, $vRecipientId, $type) {
        $modelNotifications = new Notifications();
        $modelNotifications->iFromUserId = $postData['iToUserId'];
        $modelNotifications->iToUserId = $postData['iUserId'];
        $modelNotifications->iEntryId = $postData['iTipId'];
        $modelNotifications->tiNotificationType = $type;
        $modelNotifications->vMessage = $postData['fromMsg'];
        $modelNotifications->vBoldContent = $postData['fromBoldContent'];
        $modelNotifications->tiNotificationReadFlag = 1;
        $modelNotifications->iCreatedAt = $postData['time'];
        $modelNotifications->save();
    }

    public function to_notification_send($postData, $vRecipientId, $type, $isRead) {
        $modelNotifications = new Notifications();
        $modelNotifications->iFromUserId = $postData['iUserId'];
        $modelNotifications->iToUserId = $postData['iToUserId'];
        $modelNotifications->iEntryId = $postData['iTipId'];
        $modelNotifications->tiNotificationType = $type;
        $modelNotifications->vMessage = $postData['toMsg'];
        $modelNotifications->vBoldContent = $postData['toBoldContent'];
        $modelNotifications->tiNotificationReadFlag = $isRead;
        $modelNotifications->iCreatedAt = $postData['time'];
        $modelNotifications->save();
    }

    public function badge_read($params, $iUserId) {
        if (empty($params['iNotificationId'])) {
            return ['response_code' => 400, 'response_message' => 'Unathorized request.'];
        }
        $modelNotifications = Notifications::find()->where(['iNotificationId' => $params['iNotificationId'], 'iToUserId' => $iUserId, 'tiNotificationReadFlag' => 0])->one();
        if (!empty($modelNotifications)) {
            $modelNotifications->tiNotificationReadFlag = 1;
            $modelNotifications->save();
            return ['response_code' => 200, 'response_message' => 'Notification read sucessfully.'];
        } else {
            return ['response_code' => 400, 'response_message' => 'Unathorized request.'];
        }
    }

}
