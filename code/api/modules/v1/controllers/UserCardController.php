<?php

/* * *********************************************************************
 * Original Author: Vijay Panchal
 * File Creation Date: 7th Sept 2018
 * Development Group: Space-O Technologies
 * Description: This Controller is used for application
 * Module covered 
 *      -  Add Card
 *      -  Delete Card
 *      -  Set Dafault Card
 *      -  Get Card List
 * ******************************************************************** */

namespace api\modules\v1\controllers;

use Yii;
use yii\filters\VerbFilter;
use api\modules\v1\models\States;
use api\modules\v1\controllers\base\BaseController;
use api\modules\v1\models\UserCardDetails;

class UserCardController extends BaseController {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['GET'],
                    'create' => ['POST'],
                    'delete' => ['DELETE'],
                    'set-default-card' => ['POST'],
                ],
            ],
        ];
    }

    /**
     *  @SWG\GET(
     *      path="/user-card",
     *      tags={"User Cards"},
     *      summary="Get User Card List",
     *      operationId="getUserCardList",
     *      produces={"application/json"},
     *      consumes={"multipart/form-data"},
     *      @SWG\Parameter(
     *          name="nonce",
     *          in="header",
     *          required=true,
     *          type="string",
     *          default="123456",
     *      ),
     *      @SWG\Parameter(
     *          name="timestamp",
     *          in="header",
     *          required=true,
     *          type="string",
     *          default="123456",
     *      ),
     *      @SWG\Parameter(
     *          name="token",
     *          in="header",
     *          required=true,
     *          type="string",
     *          default="57f0cb275421171c95294764476df124ebd0b3ccebca603cab5cec795c480238",
     *      ),
     *      @SWG\Parameter(
     *          name="Authorization",
     *          in="header",
     *          required=true,
     *          type="string",
     *          default="3738b45dad593a0e180274bbe11ecffe",
     *      ),
     *      @SWG\Response(
     *         response = 200,
     *         description = "Success response",
     *         @SWG\Schema(ref="#/definitions/UserCardListResponse"),
     *              examples={
     *                  "application/json": {
     *                      "responseCode": 200,
     *                      "responseMessage": "Card List",
     *                      "responseData": {
     *                             {
     *                                   "iUserCardId": 7,
     *                                    "iUserId": 2,
     *                                   "vCardToken": "card_1CtpU7JYWCxUzaUghy4HB0tg",
     *                                   "vCardBrand": "Visa",
     *                                   "vCardNo": "4242",
     *                                   "iExpiryMonth": 7,
     *                                   "iExpiryYear": 2019
     *                               },
     *                               {
     *                                   "iUserCardId": 8,
     *                                   "iUserId": 2,
     *                                   "vCardToken": "card_1CuYtqJYWCxUzaUgLPUUtaM8",
     *                                   "vCardBrand": "Visa",
     *                                   "vCardNo": "4242",
     *                                   "iExpiryMonth": 8,
     *                                   "iExpiryYear": 2019
     *                               }
     *                         }
     *                   }
     *         },
     *     ),
     *     @SWG\Response(
     *         response = 400,
     *         description = "Bad Request",       
     *         @SWG\Schema(ref="#/definitions/ErrorResponse"),      
     *              examples={
     *                  "application/json": {
     *                      "responseCode": 400,
     *                      "responseMessage": "Current password is incorrect.",
     *                      "responseData": {}
     *                   }
     *              }
     *     ),
     *     @SWG\Response(
     *         response="405",
     *         description="Method Not Allowed"
     *     ),
     * )
     */
    public function actionIndex() {
        if ($this->response->getResponseCode() == OK) {
            $this->checkAuthorization();
            if ($this->response->getResponseCode() == OK) {
                $this->response = UserCardDetails::getList($this);
            }
        }
        return $this->response->showEverything();
    }

    /**
     *  @SWG\Post(
     *      path="/user-card",
     *      tags={"User Cards"},
     *      summary="Add User Card",
     *      operationId="addUserCard",
     *      produces={"application/json"},
     *      consumes={"application/x-www-form-urlencoded"},
     *      @SWG\Parameter(
     *          name="nonce",
     *          in="header",
     *          required=true,
     *          type="string",
     *          default="123456",
     *      ),
     *      @SWG\Parameter(
     *          name="timestamp",
     *          in="header",
     *          required=true,
     *          type="string",
     *          default="123456",
     *      ),
     *      @SWG\Parameter(
     *          name="token",
     *          in="header",
     *          required=true,
     *          type="string",
     *          default="57f0cb275421171c95294764476df124ebd0b3ccebca603cab5cec795c480238",
     *      ),
     *      @SWG\Parameter(
     *          name="Authorization",
     *          in="header",
     *          required=true,
     *          type="string",
     *          default="3738b45dad593a0e180274bbe11ecffe",
     *      ),
     *      @SWG\Parameter(
     *          name="vCardToken",
     *          in="formData",
     *          description="Stripe Token",
     *          required=true,
     *          type="string",
     *          format="string",
     *          default="tok_visa",
     *      ),
     *      @SWG\Response(
     *         response = 200,
     *         description = "Success response",
     *         @SWG\Schema(ref="#/definitions/UserCardResponse"),
     *              examples={
     *                  "application/json": {
     *                      "responseCode": 200,
     *                      "responseMessage": "Card added successfully successfully.",
     *                      "responseData": {
     *                             "iUserCardId": 1,
     *                             "iUserId": 65,
     *                             "vCardToken": "card_1CqwteJYWCxUzaUgB4HadnzI",
     *                             "vCardBrand": "Visa",
     *                             "vCardNo": "4242",
     *                             "iExpiryMonth": 7,
     *                             "iExpiryYear": 2019
     *                         }
     *                   }
     *         },
     *     ),
     *     @SWG\Response(
     *         response = 201,
     *         description = "Bad Request",    
     *         @SWG\Schema(ref="#/definitions/ErrorResponse"),      
     *              examples={
     *                  "application/json": {
     *                      "responseCode": 400,
     *                      "responseMessage": "Email ID yagnesh.spaceo@gmail.com has already been taken."
     *                   }
     *              }
     *     ),
     *     @SWG\Response(
     *         response="405",
     *         description="Method Not Allowed"
     *     ),
     * )
     */
    public function actionCreate() {
        if ($this->response->getResponseCode() == OK) {
            $this->checkAuthorization();
            if ($this->response->getResponseCode() == OK) {
                $this->response = UserCardDetails::addCard($this);
            }
        }
        return $this->response->showEverything();
    }

    /**
     *  @SWG\Delete(
     *      path="/user-card/{iUserCardId}",
     *      tags={"User Cards"},
     *      summary="Delete User Card",
     *      operationId="deleteUserCard",
     *      produces={"application/json"},
     *      consumes={"multipart/form-data"},
     *      @SWG\Parameter(
     *          name="nonce",
     *          in="header",
     *          required=true,
     *          type="string",
     *          default="123456",
     *      ),
     *      @SWG\Parameter(
     *          name="timestamp",
     *          in="header",
     *          required=true,
     *          type="string",
     *          default="123456",
     *      ),
     *      @SWG\Parameter(
     *          name="token",
     *          in="header",
     *          required=true,
     *          type="string",
     *          default="57f0cb275421171c95294764476df124ebd0b3ccebca603cab5cec795c480238",
     *      ),
     *      @SWG\Parameter(
     *          name="Authorization",
     *          in="header",
     *          required=true,
     *          type="string",
     *          default="3738b45dad593a0e180274bbe11ecffe",
     *      ),
     *      @SWG\Parameter(
     *          name="iUserCardId",
     *          in="path",
     *          required=true,
     *          type="integer",
     *          format="integer",
     *          description="User Card Id",
     *          default="5",
     *      ),
     *      @SWG\Response(
     *         response = 200,
     *         description = "Success response",
     *         @SWG\Schema(ref="#/definitions/SuccessResponse"),
     *              examples={
     *                  "application/json": {
     *                      "responseCode": 200,
     *                      "responseMessage": "Card Delete successfully successfully.",
     *                   }
     *         },
     *     ),
     *     @SWG\Response(
     *         response = 400,
     *         description = "Bad Request",    
     *         @SWG\Schema(ref="#/definitions/ErrorResponse"),         
     *              examples={
     *                  "application/json": {
     *                      "responseCode": 400,
     *                      "responseMessage": "Current password is incorrect.",
     *                   }
     *              }
     *     ),
     *     @SWG\Response(
     *         response="405",
     *         description="Method Not Allowed"
     *     ),
     * )
     */
    public function actionDelete($id) {
        if ($this->response->getResponseCode() == OK) {
            $this->checkAuthorization();
            if ($this->response->getResponseCode() == OK) {
                $this->response = UserCardDetails::deleteCard($this);
            }
        }
        return $this->response->showEverything();
    }

    /**
     *  @SWG\Post(
     *      path="/user-card/set-default-card",
     *      tags={"User Cards"},
     *      summary="Set Default Card",
     *      operationId="setDefaultCard",
     *      produces={"application/json"},
     *      consumes={"application/x-www-form-urlencoded"},
     *      @SWG\Parameter(
     *          name="nonce",
     *          in="header",
     *          required=true,
     *          type="string",
     *          default="123456",
     *      ),
     *      @SWG\Parameter(
     *          name="timestamp",
     *          in="header",
     *          required=true,
     *          type="string",
     *          default="123456",
     *      ),
     *      @SWG\Parameter(
     *          name="token",
     *          in="header",
     *          required=true,
     *          type="string",
     *          default="57f0cb275421171c95294764476df124ebd0b3ccebca603cab5cec795c480238",
     *      ),
     *      @SWG\Parameter(
     *          name="Authorization",
     *          in="header",
     *          required=true,
     *          type="string",
     *          default="3738b45dad593a0e180274bbe11ecffe",
     *      ),
     *      @SWG\Parameter(
     *          name="iUserCardId",
     *          in="formData",
     *          description="User Card Id",
     *          required=true,
     *          type="integer",
     *          format="int32",
     *          default="1",
     *      ),
     *      @SWG\Response(
     *         response = 200,
     *         description = "Success response",
     *         @SWG\Schema(ref="#/definitions/UserCardResponse"),
     *              examples={
     *                  "application/json": {
     *                      "responseCode": 200,
     *                      "responseMessage": "Card added successfully successfully.",
     *                      "responseData": {
     *                             "iUserCardId": 1,
     *                             "iUserId": 65,
     *                             "vCardToken": "card_1CqwteJYWCxUzaUgB4HadnzI",
     *                             "vCardBrand": "Visa",
     *                             "vCardNo": "4242",
     *                             "iExpiryMonth": 7,
     *                             "iExpiryYear": 2019
     *                         }
     *                   }
     *         },
     *     ),
     *     @SWG\Response(
     *         response = 201,
     *         description = "Bad Request",    
     *         @SWG\Schema(ref="#/definitions/ErrorResponse"),      
     *              examples={
     *                  "application/json": {
     *                      "responseCode": 400,
     *                      "responseMessage": "Email ID yagnesh.spaceo@gmail.com has already been taken."
     *                   }
     *              }
     *     ),
     *     @SWG\Response(
     *         response="405",
     *         description="Method Not Allowed"
     *     ),
     * )
     */
    public function actionSetDefaultCard() {
        if ($this->response->getResponseCode() == OK) {
            $this->checkAuthorization();
            if ($this->response->getResponseCode() == OK) {
                $this->response = UserCardDetails::setDefaultCard($this);
            }
        }
        return $this->response->showEverything();
    }

}
