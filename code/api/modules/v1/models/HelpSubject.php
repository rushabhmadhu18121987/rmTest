<?php

namespace api\modules\v1\models;

use Yii;
use yii\db\Transaction;
use api\modules\v1\models\response\HelpSubjectListResponse;
use api\modules\v1\models\response\HelpSubjectResponseData;

/**
 * This is the model class for table "help_subject".
 *
 * @property int $iHelpSubjectId
 * @property int $vHelpSubject
 * @property int $tiHelpSubjectFor 1 - User , 0- Business
 * @property int $tiIsDeleted 1 - Yes , 0 - No
 * @property int $tiIsActive 1 - Active, 0 - Inactive
 * @property int $iCreatedAt
 * @property int $IUpdatedAt
 *
 * @property UserHelpRequest[] $userHelpRequests
 */
class HelpSubject extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'help_subject';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['vHelpSubject', 'iCreatedAt'], 'required'],
            [['tiHelpSubjectFor', 'tiIsDeleted', 'tiIsActive', 'iCreatedAt', 'IUpdatedAt'], 'integer'],
            [['vHelpSubject'], 'stting', 'max' => 100],
            [['vHelpSubject'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'iHelpSubjectId' => 'I Help Subject ID',
            'vHelpSubject' => 'V Help Subject',
            'tiHelpSubjectFor' => 'Ti Help Subject For',
            'tiIsDeleted' => 'Ti Is Deleted',
            'tiIsActive' => 'Ti Is Active',
            'iCreatedAt' => 'I Created At',
            'IUpdatedAt' => 'Iupdated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserHelpRequests() {
        return $this->hasMany(UserHelpRequest::className(), ['iHelpSubjectId' => 'iHelpSubjectId']);
    }

    /**
     * Get Cancellation Reason List
     * @param \api\modules\v1\controllers\CancellationReasonController $request
     * @author Yagnesh Panchal <yagnesh.spaceo@gmail.com>
     */
    public function getList($request) {
        $transaction = Yii::$app->db->beginTransaction(Transaction::SERIALIZABLE);
        try {
            $helpSubjects = static::find()->where(['tiIsActive' => 1, 'tiIsDeleted' => 0])->all();
            $responseData = [];
            if (!empty($helpSubjects)) {
                foreach ($helpSubjects as $key => $helpSubject) {
                    $responseData[] = $helpSubject->getResponseData();
                }
            }
            if (!empty($responseData)) {
                return HelpSubjectListResponse::withData(OK, Yii::t('response', 'help_subject_found'), $responseData);
            } else {
                return HelpSubjectListResponse::withData(OK, Yii::t('response', 'help_subject_not_found'), $responseData);
            }
        } catch (Exception $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        }
    }

    public function getResponseData() {
        $responseData = HelpSubjectResponseData::withModel($this);
        return $responseData->showEverything();
    }

}
