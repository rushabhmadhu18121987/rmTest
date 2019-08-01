<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "category_master".
 *
 * @property int $iCategoryId
 * @property int $iParentCategoryId
 * @property string $vCategoryName
 * @property string $vCategoryIcon
 * @property int $tiOrderNo
 * @property int $tiCategoryType 1=Business,2=Event
 * @property int $tiIsActive
 * @property int $tiIsDeleted
 * @property int $iCreatedAt
 * @property int $iUpdatedAt
 *
 * @property BusinessMaster[] $businessMasters
 * @property CategoryMaster $iParentCategory
 * @property CategoryMaster[] $categoryMasters
 */
class CategoryMaster extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'category_master';
    }

    public static function find($query = null) {
        return parent::find($query)->andWhere(['category_master.tiIsDeleted' => 0]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['iParentCategoryId', 'tiOrderNo','tiIsActive', 'tiIsDeleted', 'iCreatedAt', 'iUpdatedAt'], 'integer', 'on' => [SCH_CREATE, SCH_UPDATE]],
            [['vCategoryName', 'iCreatedAt', 'tiIsActive', 'tiIsDeleted', 'iCreatedAt'], 'required', 'on' => [SCH_CREATE, SCH_UPDATE]],
            [['vCategoryName'], 'string', 'max' => 100, 'on' => [SCH_CREATE, SCH_UPDATE]],
            [['vCategoryName'], 'unique', 'on' => [SCH_CREATE, SCH_UPDATE]],
            [['tiOrderNo'], 'required', 'on' => [SCH_CREATE, SCH_UPDATE]],
            [['iParentCategoryId'], 'exist', 'skipOnError' => true, 'targetClass' => CategoryMaster::className(), 'targetAttribute' => ['iParentCategoryId' => 'iCategoryId'], 'on' => [SCH_CREATE, SCH_UPDATE]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'iCategoryId' => Yii::t('admin', 'Category ID'),
            'iParentCategoryId' => Yii::t('admin', 'Parent Category ID'),
            'vCategoryName' => Yii::t('admin', 'Category Name'),
            'vCategoryIcon' => Yii::t('admin', 'Category Icon'),
            'tiOrderNo' => Yii::t('admin', 'Order No'),
            'tiIsActive' => Yii::t('admin', 'Is Active'),
            'tiIsDeleted' => Yii::t('admin', 'Is Deleted'),
            'iCreatedAt' => Yii::t('admin', 'Created At'),
            'iUpdatedAt' => Yii::t('admin', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessMasters() {
        return $this->hasMany(BusinessMaster::className(), ['iCategoryId' => 'iCategoryId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIParentCategory() {
        return $this->hasOne(CategoryMaster::className(), ['iCategoryId' => 'iParentCategoryId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryMasters() {
        return $this->hasMany(CategoryMaster::className(), ['iParentCategoryId' => 'iCategoryId']);
    }

}
