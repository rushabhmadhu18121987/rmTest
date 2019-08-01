<?php

namespace api\modules\v1\models;

use Yii;
use yii\db\Transaction;
use api\modules\v1\models\UserNotification;
use api\modules\v1\models\response\ErrorResponse;
use api\modules\v1\models\response\SuccessResponse;
use api\modules\v1\models\response\AppSettingResponse;
use api\modules\v1\models\response\AppSettingResponseData;

/**
 * This is the model class for table "app_setting".
 *
 * @property int $iAppSettingId
 * @property string $vAppSettingKey
 * @property string $eAppSettingDatatype
 * @property string $vAppSettingValue
 * @property string $vAppSettingDesc
 * @property int $iCreatedAt
 * @property int $iUpdatedAt
 */
class AppSetting extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'app_setting';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['vAppSettingKey', 'vAppSettingValue', 'iCreatedAt'], 'required'],
            [['eAppSettingDatatype'], 'string'],
            [['iCreatedAt', 'iUpdatedAt'], 'integer'],
            [['vAppSettingKey'], 'string', 'max' => 50],
            [['vAppSettingValue', 'vAppSettingDesc'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'iAppSettingId' => 'I App Setting ID',
            'vAppSettingKey' => 'V App Setting Key',
            'eAppSettingDatatype' => 'E App Setting Datatype',
            'vAppSettingValue' => 'V App Setting Value',
            'vAppSettingDesc' => 'V App Setting Desc',
            'iCreatedAt' => 'I Created At',
            'iUpdatedAt' => 'I Updated At',
        ];
    }

    /**
     * 
     * @return type
     */
    public static function getAppSetting() {
        $appSettingList = static::find()->all();

        $appSettings = [];
        foreach ($appSettingList as $key => $setting) {
            if ($setting->eAppSettingDatatype == 'int') {
                $appSettings[$setting->vAppSettingKey] = (int) $setting->vAppSettingValue;
            } else if ($setting->eAppSettingDatatype == 'float') {
                $appSettings[$setting->vAppSettingKey] = (float) $setting->vAppSettingValue;
            } else if ($setting->eAppSettingDatatype == 'double') {
                $appSettings[$setting->vAppSettingKey] = (double) $setting->vAppSettingValue;
            } else {
                $appSettings[$setting->vAppSettingKey] = (string) $setting->vAppSettingValue;
            }
        }
        return (object) $appSettings;
    }

    /**
     * Get App Setting List
     * @param \api\modules\v1\controllers\AppSettingController $request
     * @author Yagnesh Panchal <yagnesh.spaceo@gmail.com>
     */
    public function getList($request) {
        $transaction = Yii::$app->db->beginTransaction(Transaction::SERIALIZABLE);
        try {
            $appSettings = static::getAppSetting();

            if (!empty($request->iUser->iUserId)) {
                $appSettings->NOTIFICATION_BADGE_COUNT = UserNotification::find()
                        ->where(['tiIsRead' => 0, 'tiIsActive' => 1, 'iUserId' => $request->iUser->iUserId])
                        ->count();
            } else {
                $appSettings->NOTIFICATION_BADGE_COUNT = 0;
            }
            if (!empty($appSettings)) {
                $appSettingData = AppSettingResponseData::withModel($appSettings);
                return AppSettingResponse::withData(OK, Yii::t('response', 'app_setting_found'), $appSettingData->showEverything());
            } else {
                return AppSettingResponse::withData(OK, Yii::t('response', 'app_setting_not_found'), new \stdClass());
            }
        } catch (Exception $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        }
    }

}
