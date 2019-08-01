<?php

namespace backend\models;

//use Yii;

/**
 * This is the model class for table "pages".
 *
 * @property integer $iPageId
 * @property string $vPageName
 * @property string $txContent
 * @property integer $iCreatedAt
 * @property string $eIsActive
 * @property string $eIsDeleted
 */
class ContentPages extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'content_pages';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['vPageName', 'txContent', 'iCreatedAt', 'tiIsActive'], 'required'],
            [['txContent'], 'string'],
            [['iCreatedAt', 'tiIsActive'], 'integer'],
            [['vPageName'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'iPageId' => 'Page ID',
            'vPageName' => 'Page Name',
            'txContent' => 'Content',
            'tiIsActive' => 'Is Active',
            'iCreatedAt' => 'Created At',
            'iUpdatedAt' => 'Updated At'
        ];
    }

}
