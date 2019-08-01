<?php

/** * ********************************************************************
 * Original Author: Vijay Panchal
 * File Creation Date: 16th Aug 2018
 * Development Group: Space-O Technologies
 * Description: This Controller is used for user authentication
 * Module covered 
 *  -signup
 *  -signin 
 *  -forgot password
 *  -social signin
 *  -logout
 * Last Modified on: 
 * Last Modified By: 
 * Modified Code:
 * ******************************************************************** */

namespace api\modules\v1\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use api\modules\v1\models\UserMaster;
use common\models\DeviceMaster;
use api\modules\v1\controllers\base\BaseController;

class OauthController extends BaseController {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'signup' => ['POST'],
                    'signin' => ['POST'],
                    'forgotpassword' => ['POST'],
                ],
            ],
        ];
    }

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    /**
     *  @SWG\Post(
     *      path="/oauth/signup",
     *      tags={"Authentication"},
     *      summary="SignUp",
     *      operationId="signUp",
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
     *          name="vName",
     *          in="formData",
     *          required=true,
     *          type="string",
     *          format="string",
     *          description="First Name of user",
     *          default="vb",
     *     ),
     *     @SWG\Parameter(
     *          name="vEmail",
     *          in="formData",
     *          required=true,
     *          type="string",
     *          format="string",
     *          description="Email Id of user",
     *          default="yagnesh.spaceo@gmail.com",
     *      ),
     *      @SWG\Parameter(
     *          name="vPassword",
     *          in="formData",
     *          required=true,
     *          type="string",
     *          format="string",
     *          description="Password of user",
     *          default="123456",
     *     ),
     *     @SWG\Parameter(
     *          name="vProfilePic",
     *          in="formData",
     *          required=false,
     *          type="file",
     *          description="Profile Pic of user",
     *          default="",
     *     ),
     *     @SWG\Parameter(
     *         description="Device Timezone",
     *         in="formData",
     *         name="vTimezone",
     *         required=false,
     *         type="string",
     *         format="string",
     *         default="",
     *     ),
     *     @SWG\Parameter(
     *         description="Device Token of device",
     *         in="formData",
     *         name="vDeviceToken",
     *         required=false,
     *         type="string",
     *         format="string",
     *         default="",
     *     ),
     *     @SWG\Parameter(
     *         description="DeviceType  1=>Android 2=> IOS 0=> Web",
     *         in="formData",
     *         name="tiDeviceType",
     *         required=true,
     *         type="string",
     *         format="string",
     *         default="0",
     *     ),
     *     @SWG\Parameter(
     *          name="vDeviceName",
     *          in="formData",
     *          description="Device Name of device",
     *          required=false,
     *          type="string",
     *          format="string",
     *          default="iPhone X",
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "Signup success response",
     *         @SWG\Schema(ref="#/definitions/UserMasterResponse"),
     *              examples={
     *                  "application/json": {
     *                      "responseCode": 200,
     *                      "responseMessage": "signup_success",
     *                      "responseData": {
     *                          "iUserId": 72,
     *                          "vName": "Vijay",
     *                          "vEmail": "yagnesh.spaceo11@gmail.com",
     *                          "vISDCode": null,
     *                          "vMobileNumber": null,
     *                          "tiIsMobileVerified": 0,
     *                          "tiAcceptPush": 1,
     *                          "tiIsSocialLogin": 0,
     *                          "iNotiBadgeCount": 0,
     *                          "vProfilePic": "http://172.16.17.179/project/basecode/code/uploads/user/72/1534490757.png",
     *                          "vAuthKey": "6cb6cfcb0df23491f6258af400aa3d92"
     *                      }
     *                  }
     *         }
     *     ),
     *     @SWG\Response(
     *         response = 201,
     *         description = "Bad Request",          
     *              examples={
     *                  "application/json": {
     *                      "responseCode": 400,
     *                      "responseMessage": "Email ID yagnesh.spaceo@gmail.com has already been taken.",
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
    public function actionSignup() {
        if ($this->response->getResponseCode() == OK) {
            $this->response = UserMaster::signup($this->bodyParams);
        }
        return $this->response->showEverything();
    }

    /**
     *  @SWG\Post(
     *      path="/oauth/signin",
     *      tags={"Authentication"},
     *      summary="SignIn",
     *      operationId="signIn",
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
     *     @SWG\Parameter(
     *          name="vEmail",
     *          in="formData",
     *          required=true,
     *          type="string",
     *          format="string",
     *          description="Email Id of user",
     *          default="yagnesh.spaceo@gmail.com",
     *      ),
     *      @SWG\Parameter(
     *          name="vPassword",
     *          in="formData",
     *          description="Password of user",
     *          required=true,
     *          type="string",
     *          format="string",
     *          default="123456",
     *     ),
     *      @SWG\Parameter(
     *          name="tiUserType",
     *          in="formData",
     *          description="User Type (1 - Customer ,2 - Business)",
     *          required=true,
     *          type="string",
     *          format="string",
     *          default="1",
     *     ),
     *     @SWG\Parameter(
     *         description="Device Timezone",
     *         in="formData",
     *         name="vTimezone",
     *         required=false,
     *         type="string",
     *         format="string",
     *         default="",
     *     ),
     *     @SWG\Parameter(
     *         description="DeviceType  1=>Android 2=> IOS 0=> Web",
     *         in="formData",
     *         name="tiDeviceType",
     *         required=true,
     *         type="string",
     *         format="string",
     *         default="0",
     *     ),
     *     @SWG\Parameter(
     *         description="Device Token of device",
     *         in="formData",
     *         name="vDeviceToken",
     *         required=false,
     *         type="string",
     *         format="string",
     *         default="",
     *     ),
     *     @SWG\Parameter(
     *          name="vDeviceName",
     *          in="formData",
     *          description="Device Name of device",
     *          required=false,
     *          type="string",
     *          format="string",
     *          default="iPhone X",
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "Signin success response",
     *         @SWG\Schema(ref="#/definitions/UserMasterResponse"),
     *              examples={
     *                  "application/json": {
     *                      "responseCode": 200,
     *                      "responseMessage": "signup_success",
     *                      "responseData": {
     *                          "iUserId": 72,
     *                          "vName": "Vijay",
     *                          "vEmail": "yagnesh.spaceo11@gmail.com",
     *                          "vISDCode": null,
     *                          "vMobileNumber": null,
     *                          "tiIsMobileVerified": 0,
     *                          "tiAcceptPush": 1,
     *                          "tiIsSocialLogin": 0,
     *                          "iNotiBadgeCount": 0,
     *                          "vProfilePic": "http://172.16.17.179/project/basecode/code/uploads/user/72/1534490757.png",
     *                          "vAuthKey": "6cb6cfcb0df23491f6258af400aa3d92"
     *                      }
     *                  }
     *         }
     *     ),
     *     @SWG\Response(
     *         response = "400",
     *         description = "Bad Request",          
     *              examples={
     *                  "application/json": {
     *                      "responseCode": 400,
     *                      "responseMessage": "Invalid email or password",
     *                      "responseData": {}
     *                   }
     *              }
     *     ),
     *     @SWG\Response(
     *         response="405",
     *         description="Method Not Allowed",
     *         @SWG\Schema(ref="#/definitions/UserMasterResponse"),
     *     ),
     * )
     */
    public function actionSignin() {
        if ($this->response->getResponseCode() == OK) {
            $this->response = UserMaster::signin($this->bodyParams);
        }
        return $this->response->showEverything();
    }

    /**
     * @SWG\Post(path="/oauth/social-signin",
     *      tags={"Authentication"},
     *      summary="Social Signin",
     *      operationId="socialSignin",
     *      produces={"application/xml", "application/json"},
     *      consumes={"application/x-www-form-urlencoded"},
     *      @SWG\Parameter(
     *         name="nonce",
     *         in="header",
     *         required=true,
     *         type="string",
     *         default="123456",
     *     ),
     *      @SWG\Parameter(
     *         name="timestamp",
     *         in="header",
     *         required=true,
     *         type="string",
     *         default="123456",
     *     ),
     *      @SWG\Parameter(
     *         name="token",
     *         in="header",
     *         required=true,
     *         type="string",
     *         default="57f0cb275421171c95294764476df124ebd0b3ccebca603cab5cec795c480238",
     *     ),   
     *     @SWG\Parameter(
     *         description="accessToken of social ",
     *         in="formData",
     *         name="accessToken",
     *         required=true,
     *         type="string",
     *         format="string",
     *         default="",
     *     ),
     *     @SWG\Parameter(
     *         description="service like facebook,google",
     *         in="formData",
     *         name="service",
     *         required=true,
     *         type="string",
     *         format="string",
     *         default="facebook",
     *     ),
     *     @SWG\Parameter(
     *         description="Device Timezone",
     *         in="formData",
     *         name="vTimezone",
     *         required=false,
     *         type="string",
     *         format="string",
     *         default="",
     *     ),
     *     @SWG\Parameter(
     *         description="DeviceType  1=>Android 2=> IOS 0=> Web",
     *         in="formData",
     *         name="tiDeviceType",
     *         required=true,
     *         type="string",
     *         format="string",
     *         default="0",
     *     ),
     *     @SWG\Parameter(
     *         description="Device Token of device",
     *         in="formData",
     *         name="vDeviceToken",
     *         required=false,
     *         type="string",
     *         format="string",
     *         default="",
     *     ),
     *     @SWG\Parameter(
     *          name="vDeviceName",
     *          in="formData",
     *          description="Device Name of device",
     *          required=false,
     *          type="string",
     *          format="string",
     *          default="iPhone X",
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "Social Signin success response",
     *         @SWG\Schema(ref="#/definitions/UserMasterResponse"),
     *              examples={
     *                  "application/json": {
     *                      "responseCode": 200,
     *                      "responseMessage": "signin_success",
     *                      "responseData": {
     *                        "iUserId": 107,
     *                        "vName": "Abhishree",
     *                        "vEmail": "accfbpost@gmail.com",
     *                        "vISDCode": null,
     *                       "vMobileNumber": null,
     *                        "tiIsMobileVerified": 0,
     *                        "tiAcceptPush": 1,
     *                        "tiIsSocialLogin": 1,
     *                        "iNotiBadgeCount": 0,
     *                        "vProfilePic": "http://172.16.17.179/project/basecode/code/uploads/user/107/1535096133.jpeg",
     *                        "vAuthKey": "e8374628a01da489191ecf3db761a2d3"
     *                     }
     *                    }
     *         },
     *     ),
     *   @SWG\Response(
     *         response = 400,
     *         description = "Confilct",
     *         @SWG\Schema  ( 
     *                  @SWG\Property(
     *                      property="ErrorResponse",
     *                      type="string",
     *                      ref="#/definitions/ErrorResponse"
     *                  ),
     *         ),           
     *         examples={
     *                   "application/json": {
     *                          {
     *                          "responseCode": 400,
     *                          "responseMessage": "Error validating access token: This may be because the user logged out or may be due to a system error",
     *                          "responseData": {
     *                              }
     *                              }
     *                          }
     *                   },
     *     ),
     *     @SWG\Response(
     *         response="405",
     *         description="page not found"
     *     ),
     * )
     */
    public function actionSocialSignin() {
        if ($this->response->getResponseCode() == OK) {
            $this->response = UserMaster::socialSignin(Yii::$app->request->bodyParams);
        }
        return $this->response->showEverything();
    }

    /**
     * @SWG\Post(path="/oauth/forgot-password",
     *     tags={"Authentication"},
     *     summary="Forgot Password",
     *      operationId="forgotPassword",
     *      produces={"application/xml", "application/json"},
     *      consumes={"application/x-www-form-urlencoded"},
     *      @SWG\Parameter(
     *         name="nonce",
     *         in="header",
     *         required=true,
     *         type="string",
     *         default="123456",
     *     ),
     *      @SWG\Parameter(
     *         name="timestamp",
     *         in="header",
     *         required=true,
     *         type="string",
     *         default="123456",
     *     ),
     *      @SWG\Parameter(
     *         name="token",
     *         in="header",
     *         required=true,
     *         type="string",
     *         default="57f0cb275421171c95294764476df124ebd0b3ccebca603cab5cec795c480238",
     *     ),
     *     @SWG\Parameter(
     *         description="Email Id of user",
     *         in="formData",
     *         name="vEmail",
     *         required=true,
     *         type="string",
     *         format="string",
     *         default="yagnesh.spaceo@gmail.com",
     *     ),
     *      @SWG\Parameter(
     *          name="tiUserType",
     *          in="formData",
     *          description="User Type (1 - Customer ,2 - Business)",
     *          required=true,
     *          type="string",
     *          format="string",
     *          default="1",
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "Resend otp response",
     *         @SWG\Schema(ref="#/definitions/SuccessResponse"),
     *              examples={
     *                  "application/json": {
     *                      "responseCode": 200,
     *                      "responseMessage": "Enter the One-time Password (OTP) that was Sent to +917201969694"
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
     *                      "responseMessage": "Unauthorize request."
     *                   }
     *              }
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="page not found"
     *     ),
     * )
     */
    public function actionForgotPassword() {
        if ($this->response->getResponseCode() == OK) {
            $this->response = UserMaster::forgotPassword(Yii::$app->request->bodyParams);
        }
        return $this->response->showEverything();
    }

}
