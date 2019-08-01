<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user_notification".
 *
 * @property int $iUserNotificationId
 * @property int $iUserId
 * @property int $iVehicleId
 * @property int $iParkingSpotId
 * @property int $iParkingLotId
 * @property int $iUserBookingId
 * @property string $vNotificationTitle
 * @property string $vNotificationDesc
 * @property int $tiNotificationType
 * @property int $tiIsActive 1 - Active, 0 - Inactive
 * @property int $tiIsRead 1 - Yes, 0 - No,
 * @property int $tiIsDeleted
 * @property int $iCreatedAt
 * @property int $iUpdatedAt
 *
 * @property UserMaster $iUser
 * @property VehicleMaster $iVehicle
 * @property ParkingSpotMaster $iParkingSpot
 * @property UserBookingDetails $iUserBooking
 */
class UserNotification extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'user_notification';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['iUserId','iEntryId', 'vNotificationTitle', 'iCreatedAt'], 'required'],
            [['iUserId', 'iVehicleId', 'iParkingSpotId', 'iParkingLotId', 'iUserBookingId', 'tiNotificationType', 'tiIsActive', 'tiIsRead', 'tiIsDeleted', 'iCreatedAt', 'iUpdatedAt'], 'integer'],
            [['vNotificationTitle'], 'string', 'max' => 100],
            [['vNotificationDesc'], 'string', 'max' => 255],
            [['iUserId'], 'exist', 'skipOnError' => true, 'targetClass' => \api\modules\v1\models\UserMaster::className(), 'targetAttribute' => ['iUserId' => 'iUserId']],
            [['iVehicleId'], 'exist', 'skipOnError' => true, 'targetClass' => VehicleMaster::className(), 'targetAttribute' => ['iVehicleId' => 'iVehicleId']],
            [['iParkingSpotId'], 'exist', 'skipOnError' => true, 'targetClass' => ParkingSpotMaster::className(), 'targetAttribute' => ['iParkingSpotId' => 'iParkingSpotId']],
            [['iUserBookingId'], 'exist', 'skipOnError' => true, 'targetClass' => UserBookingDetails::className(), 'targetAttribute' => ['iUserBookingId' => 'iUserBookingId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'iUserNotificationId' => 'Notification ID',
            'iUserId' => 'User ID',
            'iVehicleId' => 'Vehicle',
            'iParkingSpotId' => 'Parking Spot ID',
            'iParkingLotId' => 'Parking Lot',
            'iUserBookingId' => 'User Booking',
            'vNotificationTitle' => 'Title',
            'vNotificationDesc' => 'Description',
            'tiNotificationType' => 'Notification Type',
            'tiIsActive' => 'Is Active',
            'tiIsRead' => 'Is Read',
            'tiIsDeleted' => 'Is Deleted',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIVehicle() {
        return $this->hasOne(VehicleMaster::className(), ['iVehicleId' => 'iVehicleId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIParkingSpot() {
        return $this->hasOne(ParkingSpotMaster::className(), ['iParkingSpotId' => 'iParkingSpotId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIUserBooking() {
        return $this->hasOne(UserBookingDetails::className(), ['iUserBookingId' => 'iUserBookingId']);
    }

}
