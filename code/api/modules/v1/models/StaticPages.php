<?php

namespace api\modules\v1\models;

use Yii;
use yii\db\Transaction;
use api\modules\v1\models\response\ErrorResponse;
use api\modules\v1\models\response\SuccessResponse;
use api\modules\v1\models\response\StaticPageListResponse;
use api\modules\v1\models\response\StaticPageResponse;
use api\modules\v1\models\response\StaticPageResponseData;

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
class StaticPages extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'content_pages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
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
    public function attributeLabels() {
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

    /**
     * Get Static Page List
     * @param type $params
     * @author Yagnesh Panchal <yagnesh.spaceo@gmail.com>
     */
    public function getList($params) {
        $transaction = Yii::$app->db->beginTransaction(Transaction::SERIALIZABLE);
        try {
            $staticPages = static::find()->where(['tiIsActive' => 1, 'tiIsDeleted' => 0])->all();
            $responseData = [];
            if (!empty($staticPages)) {
                foreach ($staticPages as $key => $staticPage) {
                    $staticPageData = StaticPageResponseData::withModel($staticPage);
                    $responseData[] = $staticPageData->showEverything();
                }
            }
            if (!empty($responseData)) {
                return StaticPageListResponse::withData(OK, Yii::t('response', 'static_page_found'), $responseData);
            } else {
                return StaticPageListResponse::withData(OK, Yii::t('response', 'static_page_not_found'), $responseData);
            }
        } catch (Exception $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        }
    }

    /**
     * 
     */
    public function getDetail($params) {
        $transaction = Yii::$app->db->beginTransaction(Transaction::SERIALIZABLE);
        try {
            $staticPage = static::find()->where(['tiIsActive' => 1, 'tiIsDeleted' => 0, 'vPageSlug' => $params['vPageSlug']])->one();
            $responseData = [];
            if (!empty($staticPage)) {
                $staticPageData = StaticPageResponseData::withModel($staticPage);
                return StaticPageResponse::withData(OK, Yii::t('response', 'static_page_found'), $staticPageData->showEverything());
            } else {
                return StaticPageResponse::withData(OK, Yii::t('response', 'static_page_not_found'), $responseData);
            }
        } catch (Exception $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        }
    }

}
