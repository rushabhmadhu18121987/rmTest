<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "app_setting".
 *
 * @property int $iAppSettingId
 * @property string $vSettingLabel
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
            [['vSettingLabel', 'vAppSettingKey', 'vAppSettingValue', 'iCreatedAt'], 'required'],
            [['eAppSettingDatatype'], 'string'],
            [['iCreatedAt', 'iUpdatedAt'], 'integer'],
            [['vSettingLabel', 'vAppSettingKey'], 'string', 'max' => 50],
            [['vAppSettingValue', 'vAppSettingDesc'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'iAppSettingId' => 'App Setting ID',
            'vSettingLabel' => 'Setting Label',
            'vAppSettingKey' => 'App Setting Key',
            'eAppSettingDatatype' => 'App Setting Datatype',
            'vAppSettingValue' => 'App Setting Value',
            'vAppSettingDesc' => 'Description',
            'iCreatedAt' => 'Created At',
            'iUpdatedAt' => 'Updated At',
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

}
