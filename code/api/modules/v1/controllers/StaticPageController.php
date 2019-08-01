<?php

/* * *********************************************************************
 * Original Author: Vijay Panchal
 * File Creation Date: 31th Aug 2018
 * Development Group: Space-O Technologies
 * Description: This Controller is used for user authentication
 * Module covered 
 *      -   Get Static Page List
 *      -   Get Static Page Detail
 * ******************************************************************** */

namespace api\modules\v1\controllers;

use Yii;
use yii\filters\VerbFilter;
use api\modules\v1\models\StaticPages;
use api\modules\v1\controllers\base\BaseController;

class StaticPageController extends BaseController {

    public $enableCsrfValidation = false;

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['GET'],
                ],
            ]
        ];
    }

    /**
     *  @SWG\Get(
     *      path="/static-pages",
     *      tags={"Static Pages"},
     *      summary="Get Static Page List",
     *      operationId="getStaticPageList",
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
     *     @SWG\Response(
     *         response = 200,
     *         description = "Signup success response",
     *         @SWG\Schema(ref="#/definitions/StaticPageListResponse"),
     *              examples={
     *                  "application/json": {
     *                         "responseCode": 200,
     *                         "responseMessage": "vehicle_type_found",
     *                         "responseData": {
     *                              {
     *                                  "iVehicleTypeId": 1,
     *                                  "vVehicleTypeName": "Small Vehicle",
     *                                  "vVehicleTypeImage": null
     *                            }
     *                          }
     *                        }
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
            $this->response = StaticPages::getList($this->bodyParams);
        }
        return $this->response->showEverything();
    }

    /**
     *  @SWG\Get(
     *      path="/static-pages/{vPageSlug}",
     *      tags={"Static Pages"},
     *      summary="Get Static Page Detail",
     *      operationId="getStaticPageDetail",
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
     *          name="vPageSlug",
     *          in="path",
     *          required=true,
     *          type="string",
     *          format="string",
     *          description="Page Slug",
     *          default="faq",
     *      ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "Signup success response",
     *         @SWG\Schema(ref="#/definitions/StaticPageResponse"),
     *              examples={
     *                  "application/json": {
     *                         "responseCode": 200,
     *                         "responseMessage": "vehicle_type_found",
     *                         "responseData": {
     *                              {
     *                                  "iVehicleTypeId": 1,
     *                                  "vVehicleTypeName": "Small Vehicle",
     *                                  "vVehicleTypeImage": null
     *                            }
     *                          }
     *                        }
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
    public function actionView($slug) {
        if ($this->response->getResponseCode() == OK) {
            $this->bodyParams['vPageSlug'] = $slug;
            $this->response = StaticPages::getDetail($this->bodyParams);
        }
        return $this->response->showEverything();
    }
}
