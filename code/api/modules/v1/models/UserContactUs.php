<?php

namespace api\modules\v1\models;

use Yii;
use yii\db\Transaction;
use api\modules\v1\models\response\ErrorResponse;
use api\modules\v1\models\response\SuccessResponse;

/**
 * This is the model class for table "user_contact_us".
 *
 * @property int $iContactUsId
 * @property int $iUserId
 * @property string $vName
 * @property string $vEmail
 * @property string $vSubject
 * @property string $vMessage
 * @property int $tiIsActive
 * @property int $tiIsDeleted
 * @property int $iCreatedAt
 *
 * @property UserMaster $iUser
 */
class UserContactUs extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'user_contact_us';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['iUserId', 'tiIsActive', 'tiIsDeleted', 'iCreatedAt'], 'integer', 'on' => [SCH_CREATE]],
            [['vName', 'vEmail', 'iCreatedAt'], 'required', 'on' => [SCH_CREATE]],
            [['vName'], 'string', 'max' => 50, 'on' => [SCH_CREATE]],
            [['vEmail'], 'string', 'max' => 100, 'on' => [SCH_CREATE]],
            [['vSubject'], 'string', 'max' => 100, 'on' => [SCH_CREATE]],
            [['vMessage'], 'string', 'max' => 500, 'on' => [SCH_CREATE]],
            [['iUserId'], 'exist', 'skipOnError' => true, 'targetClass' => UserMaster::className(), 'targetAttribute' => ['iUserId' => 'iUserId'], 'on' => [SCH_CREATE]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'iContactUsId' => 'Contact Us ID',
            'iUserId' => 'User ID',
            'vName' => 'Name',
            'vEmail' => 'Email',
            'vSubject' => 'Subject',
            'vMessage' => 'Message',
            'tiIsActive' => 'Status',
            'tiIsDeleted' => 'Is Deleted',
            'iCreatedAt' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIUser() {
        return $this->hasOne(UserMaster::className(), ['iUserId' => 'iUserId']);
    }

    /** User Contact Us
     * @param \api\modules\v1\controllers\UserController $request
     * @author Yagnesh Panchal <yagnesh.spaceo@gmail.com>
     */
    public function contactUs($request) {
        $transaction = Yii::$app->db->beginTransaction(Transaction::SERIALIZABLE);
        try {
            $modelUser = $request->iUser;
            $modelContactUs = new UserContactUs();
            $modelContactUs->iUserId = $request->iUser->iUserId ?? NULL;
            $response = Yii::$app->apptransaction->insert($modelContactUs, $request->bodyParams, $transaction, SCH_CREATE);
            if ($response->getResponseCode() == OK) {
                $transaction->commit();
                return SuccessResponse::withData(OK, Yii::t('response', 'contect_us_success'));
            } else {
                $transaction->rollBack();
                return $response;
            }
        } catch (Exception $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        }
    }

}
