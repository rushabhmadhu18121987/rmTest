<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\filters\VerbFilter;
use api\modules\v1\models\UserMaster;
use api\modules\v1\models\response\SuccessResponse;
use api\modules\v1\models\UserNotification;
use api\modules\v1\controllers\base\BaseController;

class NotificationController extends BaseController {

    /**
     *  @SWG\Get(
     *      path="/notification",
     *      tags={"User Notifications"},
     *      summary="Get User Notification List",
     *      operationId="getUserNotificationList",
     *      produces={"application/json"},
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
     *          name="page",
     *          in="query",
     *          required=false,
     *          type="integer",
     *          format="int32",
     *          description="Page No Like '0,1,2,3' , -1 for all",
     *          default="-1",
     *      ),
     *      @SWG\Response(
     *         response = 200,
     *         description = "Success response",
     *         @SWG\Schema(ref="#/definitions/UserNotificationPaginationResponse"),
     *              examples={
     *                  "application/json": {
     *                      "responseCode": 200,
     *                      "responseMessage": "Notification List",
     *                      "responseData": {
     *                             {
     *                                   "iUserNotificationId": 7,
     *                                    "iUserId": 2,
     *                                   "vNotificationToken": "card_1CtpU7JYWCxUzaUghy4HB0tg",
     *                                   "vNotificationBrand": "Visa",
     *                                   "vNotificationNo": "4242",
     *                                   "iExpiryMonth": 7,
     *                                   "iExpiryYear": 2019
     *                               },
     *                               {
     *                                   "iUserNotificationId": 8,
     *                                   "iUserId": 2,
     *                                   "vNotificationToken": "card_1CuYtqJYWCxUzaUgLPUUtaM8",
     *                                   "vNotificationBrand": "Visa",
     *                                   "vNotificationNo": "4242",
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
                $this->response = UserNotification::getList($this);
            }
        }
        return $this->response->showEverything();
    }

    /**
     *  @SWG\Post(
     *      path="/notification/read",
     *      tags={"User Notifications"},
     *      summary="Read User Notification",
     *      operationId="readUserNotification",
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
     *          name="iUserNotificationIds",
     *          in="formData",
     *          required=true,
     *          type="string",
     *          format="string",
     *          description="Notification Id List Like '1,2,3'",
     *          default="1",
     *      ),
     *      @SWG\Response(
     *         response = 200,
     *         description = "Success response",
     *         @SWG\Schema(ref="#/definitions/SuccessResponse"),
     *              examples={
     *   "responseCode": 200,
     *   "responseMessage": "read notification"
     * },
     *     ),
     *     @SWG\Response(
     *         response = 400,
     *         description = "Bad Request",       
     *         @SWG\Schema(ref="#/definitions/ErrorResponse"),      
     *              examples={
     *   "responseCode": 201,
     *   "responseMessage": "Something when wrong while read notification"
     * }
     *     ),
     *     @SWG\Response(
     *         response="405",
     *         description="Method Not Allowed"
     *     ),
     * )
     */
    public function actionRead() {
        if ($this->response->getResponseCode() == OK) {
            $this->checkAuthorization();
            if ($this->response->getResponseCode() == OK) {
                $this->response = UserNotification::readNotification($this);
            }
        }
        return $this->response->showEverything();
    }

    /**
     *  @SWG\Post(
     *      path="/notification/delete",
     *      tags={"User Notifications"},
     *      summary="Delete User Notification",
     *      operationId="deleteUserNotification",
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
     *          name="iUserNotificationIds",
     *          in="formData",
     *          required=false,
     *          type="string",
     *          format="string",
     *          description="Notification Id List Like '1,2,3'",
     *          default="1",
     *      ),
     *      @SWG\Response(
     *         response = 200,
     *         description = "Success response",
     *         @SWG\Schema(ref="#/definitions/SuccessResponse"),
     *              examples={
     *   "responseCode": 200,
     *   "responseMessage": "delete notification"
     * },
     *     ),
     *     @SWG\Response(
     *         response = 400,
     *         description = "Bad Request",       
     *         @SWG\Schema(ref="#/definitions/ErrorResponse"),      
     *              examples={
     *   "responseCode": 201,
     *   "responseMessage": "Something when wrong while read notification"
     * }
     *     ),
     *     @SWG\Response(
     *         response="405",
     *         description="Method Not Allowed"
     *     ),
     * )
     */
    public function actionDelete() {
        if ($this->response->getResponseCode() == OK) {
            $this->checkAuthorization();
            if ($this->response->getResponseCode() == OK) {
                $this->response = UserNotification::deleteNotification($this);
            }
        }
        return $this->response->showEverything();
    }

}
