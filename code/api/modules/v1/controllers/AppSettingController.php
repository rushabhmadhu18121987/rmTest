<?php

/* * *********************************************************************
 * Original Author: Vijay Panchal
 * File Creation Date: 7th Sept 2018
 * Development Group: Space-O Technologies
 * Description: This Controller is used for project
 * Module covered 
 *      -  Get App Setting
 * ******************************************************************** */

namespace api\modules\v1\controllers;

use Yii;
use yii\filters\VerbFilter;
use api\modules\v1\models\States;
use api\modules\v1\controllers\base\BaseController;
use api\modules\v1\models\AppSetting;

class AppSettingController extends BaseController {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['GET']
                ],
            ],
        ];
    }

    /**
     *  @SWG\Get(
     *      path="/app-setting",
     *      tags={"App Setting"},
     *      summary="Get App Setting List",
     *      operationId="getAppSettingList",
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
     *          required=false,
     *          type="string",
     *          default="3738b45dad593a0e180274bbe11ecffe",
     *      ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "Signup success response",
     *         @SWG\Schema(ref="#/definitions/AppSettingResponse"),
     *              examples={
     *                  "application/json": {
     *                        "responseCode": 200,
     *                       "responseMessage": "app_setting_found",
     *                        "responseData": {
     *                          "APP_MAP_DISTANCE_RADIUS": 500,
     *                          "FILTER_RANGE_MIN_COST": 0,
     *                          "FILTER_RANGE_MAX_COST": 50
     *                        }
     *                      }
     *         }
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
    public function actionIndex() {
        if ($this->response->getResponseCode() == OK) {
            $this->checkAuthorization(NULL, TRUE);
            if ($this->response->getResponseCode() == OK) {
                $this->response = AppSetting::getList($this);
            }
        }
        return $this->response->showEverything();
    }

}
