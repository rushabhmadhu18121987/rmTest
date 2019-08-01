<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "countries".
 *
 * @property int $iCountryId
 * @property string $vCountryName
 * @property string $vCountryCode
 * @property string $vISDCode
 * @property string $vCurrencyName
 * @property string $vCurrencyCode
 * @property int $tiIsActive 1-Active,0-Inactive
 * @property int $iCreatedAt
 * @property int $iUpdatedAt
 *
 * @property States[] $states
 */
class Countries extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'countries';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vCountryName', 'vCountryCode', 'vISDCode', 'vCurrencyName', 'vCurrencyCode', 'iCreatedAt'], 'required'],
            [['tiIsActive', 'iCreatedAt', 'iUpdatedAt'], 'integer'],
            [['vCountryName', 'vCurrencyName'], 'string', 'max' => 50],
            [['vCountryCode', 'vISDCode', 'vCurrencyCode'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'iCountryId' => 'I Country ID',
            'vCountryName' => 'V Country Name',
            'vCountryCode' => 'V Country Code',
            'vISDCode' => 'V Isdcode',
            'vCurrencyName' => 'V Currency Name',
            'vCurrencyCode' => 'V Currency Code',
            'tiIsActive' => 'Ti Is Active',
            'iCreatedAt' => 'I Created At',
            'iUpdatedAt' => 'I Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStates()
    {
        return $this->hasMany(States::className(), ['iCountryId' => 'iCountryId']);
    }
}
