<?php

namespace api\modules\v1\models;

use Yii;
use yii\db\Transaction;
use yii\helpers\ArrayHelper;
use api\modules\v1\models\response\ErrorResponse;
use api\modules\v1\models\response\TransactionResponse;
use api\modules\v1\models\response\StringDataResponse;
use api\modules\v1\models\response\UserCardResponse;
use api\modules\v1\models\response\UserCardListResponse;
use api\modules\v1\models\response\UserCardResponseData;

/**
 * This is the model class for table "user_card_details".
 *
 * @property int $iUserCardId
 * @property int $iUserId
 * @property string $vCardToken
 * @property string $vCardBrand
 * @property string $vCardNo
 * @property int $iExpiryMonth 
 * @property int $iExpiryYear 
 * @property int $tiIsDefault 1-Yes , 0-No
 * @property int $tiIsActive 1 - Active, 0 - Inactive
 * @property int $tiIsDeleted 1 - Yes , 0 - No
 * @property int $iCreatedAt
 * @property int $iUpdatedAt
 *
 * @property UserMaster $iUser
 */
class UserCardDetails extends \yii\db\ActiveRecord {

    public $stripe;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'user_card_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['iUserId', 'vCardToken', 'vCardBrand', 'vCardNo', 'iCreatedAt'], 'required', 'on' => [SCH_CREATE, SCH_DELETE, SCH_UPDATE]],
            [['iUserId', 'tiIsDefault', 'iExpiryMonth', 'iExpiryYear', 'tiIsActive', 'tiIsDeleted', 'iCreatedAt', 'iUpdatedAt'], 'integer', 'on' => [SCH_CREATE, SCH_DELETE, SCH_UPDATE]],
            [['vCardToken'], 'string', 'max' => 255, 'on' => [SCH_CREATE, SCH_DELETE, SCH_UPDATE]],
            [['vCardBrand', 'vCardHolderName'], 'string', 'max' => 50, 'on' => [SCH_CREATE, SCH_DELETE, SCH_UPDATE]],
            [['vCardNo'], 'string', 'max' => 4, 'on' => [SCH_CREATE, SCH_DELETE, SCH_UPDATE]],
            [['iUserId'], 'exist', 'skipOnError' => true, 'targetClass' => UserMaster::className(), 'targetAttribute' => ['iUserId' => 'iUserId'], 'on' => [SCH_CREATE, SCH_DELETE, SCH_UPDATE]],
        ];
    }

    public function init() {
        parent::init();
        $this->stripe = \Stripe\Stripe::setApiKey(Yii::$app->params['STRIPE_SECRET_KEY']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'iUserCardId' => 'User Card ID',
            'iUserId' => 'User ID',
            'vCardToken' => 'Card Token',
            'vCardBrand' => 'Card Brand',
            'vCardNo' => 'Card No',
            'iExpiryMonth' => 'Expiry Month',
            'iExpiryYear' => 'Expiry Year',
            'tiIsDefault' => 'Is Default',
            'tiIsActive' => 'Is Active',
            'tiIsDeleted' => 'Is Deleted',
            'iCreatedAt' => 'Created At',
            'iUpdatedAt' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIUser() {
        return $this->hasOne(UserMaster::className(), ['iUserId' => 'iUserId']);
    }

    /**
     * Get Card List
     * @param \api\modules\v1\controllers\UserCardController $request
     * @author Yagnesh Panchal <yagnesh.spaceo@gmail.com>
     */
    public static function getList($request) {
        $transaction = Yii::$app->db->beginTransaction(Transaction::SERIALIZABLE);
        try {
            $iUser = $request->iUser;
            $userCards = static::find()->where(['tiIsActive' => 1, 'tiIsDeleted' => 0, 'iUserId' => $request->iUser->iUserId])->all();

            $responseData = [];
            if (!empty($userCards)) {
                foreach ($userCards as $key => $userCard) {
                    $userCardData = UserCardResponseData::withModel($userCard);
                    $responseData[] = $userCardData->showEverything();
                }
            }
            if (!empty($responseData)) {
                return UserCardListResponse::withData(OK, Yii::t('response', 'user_card_found'), $responseData);
            } else {
                return UserCardListResponse::withData(OK, Yii::t('response', 'user_card_not_found'), $responseData);
            }
        } catch (\Exception $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        }
    }

    /**
     * Add Card to Stripe
     * @param \api\modules\v1\controllers\UserCardController $request
     * @author Yagnesh Panchal <yagnesh.spaceo@gmail.com>
     */
    public static function addCard($request) {
        $transaction = Yii::$app->db->beginTransaction(Transaction::SERIALIZABLE);
        try {
            $iUser = $request->iUser;
            $stripe = \Stripe\Stripe::setApiKey(Yii::$app->params['STRIPE_SECRET_KEY']);
            if (empty($iUser->vStripeCustomerId)) {
                $customer = \Stripe\Customer::create(["email" => $user->vEmail, "description" => $user->vFirstName . ' ' . $user->vLastName]);
                if (!empty($customer->id)) {
                    $iUser->vStripeCustomerId = $customer->id;
                    $iUser->save();
                } else {
                    Yii::$app->generallib->responseData(BAD_REQUEST, Yii::t('response', 'invalid_stripe_customer'));
                }
            } else {
                $customer = \Stripe\Customer::retrieve($iUser->vStripeCustomerId);
            }

            if (!empty($customer)) {
                $card = $customer->sources->create(["source" => $request->bodyParams['vCardToken']]);
                if (!empty($card->id)) {
                    $modelCard = new UserCardDetails();
                    $defaultCard = static::find()->where(['iUserId' => $request->iUser->iUserId, 'tiIsDeleted' => 0, 'tiIsActive' => 1, 'tiIsDefault' => 1])->one();
                    $IsDefault = empty($defaultCard) ? 1 : 0;
                    $params = [
                        'iUserId' => $request->iUser->iUserId,
                        'vCardToken' => $card->id,
                        'vCardHolderName' => $card->name,
                        'vCardBrand' => $card->brand,
                        'vCardNo' => $card->last4,
                        'iExpiryMonth' => $card->exp_month,
                        'iExpiryYear' => $card->exp_year,
                        'tiIsActive' => 1,
                        'tiIsDefault' => $IsDefault
                    ];
                    $response = Yii::$app->apptransaction->insert($modelCard, $params, $transaction, SCH_CREATE);
                    if ($response->getResponseCode() == OK) {
                        $transaction->commit();
                        $modelCard = $response->getResponseModel();
                        $responseData = UserCardResponseData::withModel($modelCard);
                        return UserCardResponse::withData(OK, Yii::t('response', 'user_card_add_success'), $responseData->showEverything());
                    } else {
                        $transaction->rollBack();
                        return $response;
                    }
                } else {
                    $transaction->rollBack();
                    return ErrorResponse::withData(BAD_REQUEST, Yii::t('response', 'invalid_stripe_card_token'));
                }
            } else {
                $transaction->rollBack();
                return ErrorResponse::withData(BAD_REQUEST, Yii::t('response', 'invalid_stripe_customer'));
            }
        } catch (\Stripe\Error\InvalidRequest $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (\Stripe\Error\Api $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (\Stripe\Error\ApiConnection $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (\Stripe\Error\Base $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (\Stripe\Error\Card $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (\Stripe\Error\Idempotency $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (\Stripe\Error\Permission $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (\Stripe\Error\RateLimit $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (\Stripe\Error\SignatureVerification $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (\Exception $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        }
    }

    /** Delete Card
     * Delete Card to Stripe
     * @param \api\modules\v1\controllers\UserCardController $request
     * @author Yagnesh Panchal <yagnesh.spaceo@gmail.com>
     */
    public static function deleteCard($request) {
        $transaction = Yii::$app->db->beginTransaction(Transaction::SERIALIZABLE);
        try {
            $modelCard = static::find()->where(['iUserId' => $request->iUser->iUserId, 'iUserCardId' => $request->queryParams['id'], 'tiIsDeleted' => 0, 'tiIsActive' => 1])->one();
            if (empty($modelCard) || $modelCard->iUserId != $request->iUser->iUserId || $modelCard->tiIsDeleted == 1) {
                return ErrorResponse::withData(BAD_REQUEST, Yii::t('response', 'invalid_delete_request'));
            } else if ($modelCard->tiIsDefault == 1) {
                return ErrorResponse::withData(BAD_REQUEST, Yii::t('response', 'cannot_delete_default_card'));
            }
            $iUser = $request->iUser;
            $stripe = \Stripe\Stripe::setApiKey(Yii::$app->params['STRIPE_SECRET_KEY']);
            if (empty($iUser->vStripeCustomerId)) {
                $customer = \Stripe\Customer::create(["email" => $user->vEmail, "description" => $user->vFirstName . ' ' . $user->vLastName]);
                if (!empty($customer->id)) {
                    $iUser->vStripeCustomerId = $customer->id;
                    $iUser->save();
                } else {
                    Yii::$app->generallib->responseData(BAD_REQUEST, Yii::t('response', 'invalid_stripe_customer'));
                }
            } else {
                $customer = \Stripe\Customer::retrieve($iUser->vStripeCustomerId);
            }

            $response = Yii::$app->apptransaction->delete($modelCard, TRUE, SCH_DELETE);
            if ($response->getResponseCode() == OK) {
                $card = $customer->sources->retrieve($modelCard->vCardToken)->delete();
                $transaction->commit();
                return $response;
            } else {
                $transaction->rollBack();
                return $response;
            }
        } catch (\Stripe\Error\InvalidRequest $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (\Stripe\Error\Api $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (\Stripe\Error\ApiConnection $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (\Stripe\Error\Base $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (\Stripe\Error\Card $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (\Stripe\Error\Idempotency $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (\Stripe\Error\Permission $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (\Stripe\Error\RateLimit $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (\Stripe\Error\SignatureVerification $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (\Exception $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        }
    }

    /** Set Default Card
     * Delete Card to Stripe
     * @param \api\modules\v1\controllers\UserCardController $request
     * @author Yagnesh Panchal <yagnesh.spaceo@gmail.com>
     */
    public function setDefaultCard($request) {

        $transaction = Yii::$app->db->beginTransaction(Transaction::SERIALIZABLE);
        try {
            $modelCard = static::find()->where(['iUserId' => $request->iUser->iUserId, 'iUserCardId' => $request->bodyParams['iUserCardId'], 'tiIsDeleted' => 0, 'tiIsActive' => 1])->one();
            if (empty($modelCard)) {
                return ErrorResponse::withData(BAD_REQUEST, Yii::t('response', 'invalid_request'));
            }
            $iUser = $request->iUser;
            $stripe = \Stripe\Stripe::setApiKey(Yii::$app->params['STRIPE_SECRET_KEY']);
            if (empty($iUser->vStripeCustomerId)) {
                $customer = \Stripe\Customer::create(["email" => $user->vEmail, "description" => $user->vFirstName . ' ' . $user->vLastName]);
                if (!empty($customer->id)) {
                    $iUser->vStripeCustomerId = $customer->id;
                    $iUser->save();
                } else {
                    Yii::$app->generallib->responseData(BAD_REQUEST, Yii::t('response', 'invalid_stripe_customer'));
                }
            } else {
                $customer = \Stripe\Customer::retrieve($iUser->vStripeCustomerId);
            }
            static::updateAll(['tiIsDefault' => 0], ['iUserId' => $request->iUser->iUserId]);
            $params = ['tiIsDefault' => 1];
            $customer->default_source = $modelCard->vCardToken;
            $customer->save();

            $response = Yii::$app->apptransaction->update($modelCard, $params, $transaction, SCH_UPDATE);
            if ($response->getResponseCode() == OK) {
                $transaction->commit();
                $modelCard = $response->getResponseModel();
                $responseData = UserCardResponseData::withModel($modelCard);
                return UserCardResponse::withData(OK, Yii::t('response', 'user_card_set_fault_success'), $responseData->showEverything());
            } else {
                $transaction->rollBack();
                return $response;
            }
        } catch (\Stripe\Error\InvalidRequest $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (\Stripe\Error\Api $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (\Stripe\Error\ApiConnection $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (\Stripe\Error\Base $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (\Stripe\Error\Card $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (\Stripe\Error\Idempotency $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (\Stripe\Error\Permission $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (\Stripe\Error\RateLimit $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (\Stripe\Error\SignatureVerification $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (\Exception $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        }
    }

    /**
     * Make Stripe Payment
     * @param UserCardDetails $modelCard
     * @param float $Amount
     * @param boolean $capture
     * @return TransactionResponse
     */
    public static function makeStripePayment($modelCard, $Amount = 0, $capture = TRUE) {
        $transaction = Yii::$app->db->beginTransaction(Transaction::SERIALIZABLE);
        try {
            $customer = \Stripe\Customer::retrieve($modelCard->iUser->vStripeCustomerId);
            $customer->default_source = $modelCard->vCardToken;
            $customer->save();
            $charge = \Stripe\Charge::create(['amount' => round($Amount * 100, 2), 'currency' => 'CAD', 'description' => mt_rand(10000000, 99999999), 'customer' => $modelCard->iUser->vStripeCustomerId, 'capture' => $capture]);
            if (empty($charge)) {
                return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
            }
            $transaction->commit();
            return TransactionResponse::withData(OK, Yii::t('response', 'booking_payment_success'), $charge);
        } catch (\Stripe\Error\InvalidRequest $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (\Stripe\Error\Api $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (\Stripe\Error\ApiConnection $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (\Stripe\Error\Base $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (\Stripe\Error\Card $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (\Stripe\Error\Idempotency $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (\Stripe\Error\Permission $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (\Stripe\Error\RateLimit $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (\Stripe\Error\SignatureVerification $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        } catch (\Exception $ex) {
            $transaction->rollBack();
            return ErrorResponse::withData(BAD_REQUEST, $ex->getMessage());
        }
    }

    function getResponseData() {
        $responseData = UserCardResponseData::withModel($this);
        return $responseData->showEverything();
    }

}
