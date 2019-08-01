<?php

namespace api\modules\v1\models;

use Yii;
use yii\db\Transaction;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;
use api\modules\v1\models\response\SuccessResponse;
use api\modules\v1\models\response\ErrorResponse;
use api\modules\v1\models\response\TransactionResponse;
use api\modules\v1\models\response\StringDataResponse;
use api\modules\v1\models\response\UserNotificationResponse;
use api\modules\v1\models\response\UserNotificationListResponse;
use api\modules\v1\models\response\UserNotificationResponseData;
use api\modules\v1\models\response\UserNotificationPaginationResponse;
use api\modules\v1\models\response\UserNotificationPaginationResponseData;

/**
 * This is the model class for table "user_notification".
 *
 * @property int $iUserNotificationId
 * @property int $iUserId
 * @property int $iEntryId
 * @property string $vNotificationTitle
 * @property string $vNotificationDesc
 * @property int $tiNotificationReceiver 0-Both , 1-App User, 2 - Parking Officer
 * @property int $tiNotificationType
 * @property int $tiIsActive 1 - Active, 0 - Inactive
 * @property int $tiIsRead 1 - Yes, 0 - No,
 * @property int $tiIsDeleted
 * @property int $iCreatedAt
 * @property int $iUpdatedAt
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
            [['iUserId', 'vNotificationTitle', 'iCreatedAt'], 'required'],
            [['iUserId', 'iEntryId', 'tiNotificationReceiver', 'tiNotificationType', 'tiIsActive', 'tiIsRead', 'tiIsDeleted', 'iCreatedAt', 'iUpdatedAt'], 'integer'],
            [['vNotificationTitle'], 'string', 'max' => 100],
            [['vNotificationDesc'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'iUserNotificationId' => 'I User Notification ID',
            'iUserId' => 'I User ID',
            'iEntryId' => 'I Entry ID',
            'vNotificationTitle' => 'V Notification Title',
            'vNotificationDesc' => 'V Notification Desc',
            'tiNotificationReceiver' => 'Ti Notification Receiver',
            'tiNotificationType' => 'Ti Notification Type',
            'tiIsActive' => 'Ti Is Active',
            'tiIsRead' => 'Ti Is Read',
            'tiIsDeleted' => 'Ti Is Deleted',
            'iCreatedAt' => 'I Created At',
            'iUpdatedAt' => 'I Updated At',
        ];
    }

    /**
     * Get Notification List
     * @param \api\modules\v1\controllers\NotificationController $request
     * @author Yagnesh Panchal <yagnesh.spaceo@gmail.com>
     */
    public static function getList($request) {
        $transaction = Yii::$app->db->beginTransaction(Transaction::SERIALIZABLE);
        try {
            $iUser = $request->iUser;
            $query = static::find()->where(['tiIsActive' => 1, 'tiIsDeleted' => 0, 'iUserId' => $request->iUser->iUserId])
                    ->orderBy(['iUserNotificationId' => SORT_DESC]);
            $countQuery = clone $query;
            $totalCount = $countQuery->count();
            $pagination = new Pagination(['totalCount' => $totalCount]);
            if (isset($request->queryParams['page'])) {
                if ($request->queryParams['page'] < 0) {
                    $pagination->setPage(0);
                    $pagination->setPageSize($pagination->totalCount);
                } else {
                    $pagination->setPage($request->queryParams['page']);
                    $pagination->setPageSize($request->appSetting->API_PAGE_LIMIT);
                }
            } else {
                $pagination->setPage(0);
                $pagination->setPageSize($request->appSetting->API_PAGE_LIMIT);
            }
            $provider = new ActiveDataProvider(['query' => $query]);
            $provider->setPagination($pagination);
            $userNotifications = $provider->getModels();

            $responseData = [];
            if (!empty($userNotifications)) {
                foreach ($userNotifications as $key => $userNotification) {
                    $userNotificationData = UserNotificationResponseData::withModel($userNotification);
                    $responseData[] = $userNotificationData->showEverything();
                }
            }
            $paginationResponseData = UserNotificationPaginationResponseData::withData($pagination->getPage(), $pagination->getPageSize(), $pagination->totalCount, $responseData);
            if (!empty($responseData)) {
                return UserNotificationPaginationResponse::withData(OK, Yii::t('response', 'user_notification_found'), $paginationResponseData->showEverything());
            } else {
                return UserNotificationPaginationResponse::withData(OK, Yii::t('response', 'user_notification_not_found'), $paginationResponseData->showEverything());
            }
        } catch (Exception $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        }
    }

    /**
     * Read Notification
     * @param \api\modules\v1\controllers\NotificationController $request
     * @author Yagnesh Panchal <yagnesh.spaceo@gmail.com>
     */
    public static function readNotification($request) {
        $transaction = Yii::$app->db->beginTransaction(Transaction::SERIALIZABLE);
        try {
            $readCount = static::read($request->bodyParams['iUserNotificationIds']);
            if ($readCount) {
                $transaction->commit();
                return SuccessResponse::withData(OK, \Yii::t('response', 'user_notification_read_success'));
            } else {
                $transaction->rollBack();
                return ErrorResponse::withData(BAD_REQUEST, \Yii::t('response', 'user_notification_read_fail'));
            }
        } catch (\yii\base\InvalidArgumentException $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (Exception $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (Exception $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        }
    }

    /**
     * Read Notification
     * @param \api\modules\v1\controllers\NotificationController $request
     * @author Yagnesh Panchal <yagnesh.spaceo@gmail.com>
     */
    public static function deleteNotification($request) {
        $transaction = Yii::$app->db->beginTransaction(Transaction::SERIALIZABLE);
        try {
            $deleteCount = 0;
            if (empty($request->bodyParams['iUserNotificationIds'])) {
                $deleteCount = static::deleteAll(['iUserId' => $request->iUser->iUserId]);
            } else {
                $deleteCount = static::deleteAll(['IN', 'iUserNotificationId', explode(',', $request->bodyParams['iUserNotificationIds'])]);
            }

            if ($deleteCount) {
                $transaction->commit();
                return SuccessResponse::withData(OK, \Yii::t('response', 'user_notification_delete_success'));
            } else {
                $transaction->rollBack();
                return ErrorResponse::withData(BAD_REQUEST, \Yii::t('response', 'user_notification_delete_fail'));
            }
        } catch (\yii\base\InvalidArgumentException $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (Exception $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (Exception $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        }
    }

    public static function read($iUserNotificationIds) {
        return static::updateAll(['tiIsRead' => 1], ['IN', 'iUserNotificationId', explode(',', $iUserNotificationIds)]);
    }

}
