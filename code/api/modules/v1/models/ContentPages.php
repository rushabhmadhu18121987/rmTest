<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "content_pages".
 *
 * @property int $iPageId
 * @property string $vPageName
 * @property string $vPageSlug
 * @property string $txContent
 * @property int $tiIsActive 1-Active,0-Inactive
 * @property int $iCreatedAt
 * @property int $iUpdatedAt
 */
class ContentPages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'content_pages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vPageName', 'vPageSlug', 'txContent', 'iCreatedAt'], 'required'],
            [['txContent'], 'string'],
            [['tiIsActive', 'iCreatedAt', 'iUpdatedAt'], 'integer'],
            [['vPageName', 'vPageSlug'], 'string', 'max' => 50],
            [['vPageName'], 'unique'],
            [['vPageSlug'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'iPageId' => 'I Page ID',
            'vPageName' => 'V Page Name',
            'vPageSlug' => 'V Page Slug',
            'txContent' => 'Tx Content',
            'tiIsActive' => 'Ti Is Active',
            'iCreatedAt' => 'I Created At',
            'iUpdatedAt' => 'I Updated At',
        ];
    }
}
