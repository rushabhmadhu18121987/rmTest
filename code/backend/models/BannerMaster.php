<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "banner_master".
 *
 * @property int $iBannerId
 * @property string $vTitle
 * @property string $vBannerPic
 * @property int $tiBannerType 1 - Default, 2 - Business, 3 - Event
 * @property int $iEntryId
 * @property int $tiOrderNo
 * @property int $tiIsActive
 * @property int $tiIsDeleted
 * @property int $iCreatedAt
 * @property int $iUpdatedAt
 */
class BannerMaster extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'banner_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['vTitle', 'tiBannerType', 'tiOrderNo', 'iCreatedAt'], 'required', 'on' => [SCH_CREATE, SCH_UPDATE]],
            ['vBannerPic', 'required', 'on' => [SCH_CREATE]],
            ['vBannerPic', 'safe', 'on' => [SCH_UPDATE]],
            [['tiBannerType', 'tiOrderNo', 'tiIsActive', 'tiIsDeleted', 'iCreatedAt', 'iUpdatedAt'], 'integer', 'on' => [SCH_CREATE, SCH_UPDATE]],
            [['vTitle'], 'string', 'max' => 255, 'on' => [SCH_CREATE, SCH_UPDATE]],
            [['vBannerPic'], 'string', 'max' => 30, 'on' => [SCH_CREATE, SCH_UPDATE]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'iBannerId' => Yii::t('admin', 'Banner ID'),
            'vTitle' => Yii::t('admin', 'Title'),
            'vBannerPic' => Yii::t('admin', 'Banner Pic'),
            'tiBannerType' => Yii::t('admin', 'Banner Type'),
            'tiOrderNo' => Yii::t('admin', 'Order No'),
            'tiIsActive' => Yii::t('admin', 'Is Active'),
            'tiIsDeleted' => Yii::t('admin', 'Is Deleted'),
            'iCreatedAt' => Yii::t('admin', 'Created At'),
            'iUpdatedAt' => Yii::t('admin', 'Updated At'),
        ];
    }

}
