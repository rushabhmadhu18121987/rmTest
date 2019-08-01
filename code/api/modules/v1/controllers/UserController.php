<?php

/* * *********************************************************************
 * Original Author: Vijay Panchal
 * File Creation Date: 16th Aug 2018
 * Development Group: Space-O Technologies
 * Description: This Controller is used for user authentication
 * Module covered 
 *      -  signup
 *      -  signin 
 *      -  social-signin
 *      -  logout
 *      -  ChangePin
 *      -  ResetPin
 * ******************************************************************** */

namespace api\modules\v1\controllers;

use Yii;
use yii\filters\VerbFilter;
use api\modules\v1\models\UserMaster;
use api\modules\v1\models\UserContactUs;
use api\modules\v1\controllers\base\BaseController;

class UserController extends BaseController {

    public $enableCsrfValidation = false;

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'add-mobile-number' => ['POST'],
                    'resend-otp' => ['POST'],
                    'verify-otp' => ['POST'],
                    'my-profile' => ['GET'],
                    'contact-us' => ['POST'],
                    'sign-out' => ['POST'],
                ],
            ]
        ];
    }

    /**
     *  @SWG\Post(
     *      path="/user/add-mobile-number",
     *      tags={"User"},
     *      summary="Add Mobile Number",
     *      operationId="addMobileNumber",
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
     *     @SWG\Parameter(
     *          name="vISDCode",
     *          in="formData",
     *          required=true,
     *          type="string",
     *          format="string",
     *          description="ISD Code of mobile number",
     *          default="+91",
     *     ),
     *      @SWG\Parameter(
     *          name="vMobileNumber",
     *          in="formData",
     *          description="Mobile Number of user",
     *          required=true,
     *          type="string",
     *          format="string",
     *          default="7201969694",
     *      ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "Verify otp response",
     *         @SWG\Schema(ref="#/definitions/SuccessResponse"),
     *              examples={
     *                  "application/json": {
     *                      "responseCode": 200,
     *                      "responseMessage": "Enter the One-time Password (OTP) that was Sent to +917201969694"
     *              }
     *         },
     *     ),
     *     @SWG\Response(
     *         response = 201,
     *         description = "Bad Request",  
     *         @SWG\Schema(ref="#/definitions/ErrorResponse"),
     *              examples={
     *                  "application/json": {
     *                      "responseCode": 201,
     *                      "responseMessage": "Isdcode cannot be blank"
     *              }
     *         },
     *     ),
     *     @SWG\Response(
     *         response="205",
     *         description="Method Not Allowed"
     *     ),
     * )
     */
    public function actionAddMobileNumber() {
        if ($this->response->getResponseCode() == OK) {
            $this->checkAuthorization();
            if ($this->response->getResponseCode() == OK) {
                $this->response = UserMaster::addMobileNo($this->bodyParams, $this->iUser);
            }
        }
        return $this->response->showEverything();
    }

    /**
     *  @SWG\Post(
     *      path="/user/resend-otp",
     *      tags={"User"},
     *      summary="Resend OTP",
     *      operationId="resendOTP",
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
     *          name="vMobileNumber",
     *          in="formData",
     *          description="Mobile Number of user",
     *          required=true,
     *          type="string",
     *          format="string",
     *          default="7201969694",
     *      ),
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
     *         response="405",
     *         description="Method Not Allowed"
     *     ),
     * )
     */
    public function actionResendOtp() {
        if ($this->response->getResponseCode() == OK) {
            $this->response = UserMaster::resendOTP($this->bodyParams);
        }
        return $this->response->showEverything();
    }

    /**
     *  @SWG\Post(
     *      path="/user/verify-otp",
     *      tags={"User"},
     *      summary="Verify OTP",
     *      operationId="verifyOTP",
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
     *          name="vMobileNumber",
     *          in="formData",
     *          description="Mobile Number of user",
     *          required=true,
     *          type="string",
     *          format="string",
     *          default="7201969694",
     *      ),
     *      @SWG\Parameter(
     *          name="vOTP",
     *          in="formData",
     *          description="one time pin",
     *          required=true,
     *          type="string",
     *          format="string",
     *          default="123456",
     *     ),
     *     @SWG\Parameter(
     *          name="vDeviceToken",
     *          in="formData",
     *          description="Device Token of device",
     *          required=false,
     *          type="string",
     *          format="string",
     *          default="123456",
     *     ),
     *     @SWG\Parameter(
     *          name="tiDeviceType",
     *          in="formData",
     *          description="DeviceType 0-Web, 1-IOS, 2-Android",
     *          required=true,
     *          type="string",
     *          format="string",
     *          default="1",
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
     *                      "responseMessage": "otp_verify_success",
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
     *         @SWG\Schema(ref="#/definitions/ErrorResponse"),         
     *              examples={
     *                  "application/json": {
     *                      "responseCode": 201,
     *                      "responseMessage": "Invalid OTP or may be expired.",
     *                   }
     *              }
     *     ),
     *     @SWG\Response(
     *         response="205",
     *         description="Method Not Allowed"
     *     ),
     * )
     */
    public function actionVerifyOtp() {
        if ($this->response->getResponseCode() == OK) {
            $this->response = UserMaster::verifyOTP($this->bodyParams);
        }
        return $this->response->showEverything();
    }

    /**
     *  @SWG\Post(
     *      path="/user/change-password",
     *      tags={"User"},
     *      summary="Change Password",
     *      operationId="changePassword",
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
     *          name="currentPassword",
     *          in="formData",
     *          description="Current Password",
     *          required=true,
     *          type="string",
     *          format="string",
     *          default="123456",
     *      ),
     *      @SWG\Parameter(
     *          name="vNewPassword",
     *          in="formData",
     *          description="New Password",
     *          required=true,
     *          type="string",
     *          format="string",
     *          default="123456",
     *      ),
     *      @SWG\Parameter(
     *          name="confirmPassword",
     *          in="formData",
     *          description="Confirm Password",
     *          required=true,
     *          type="string",
     *          format="string",
     *          default="1234567",
     *      ),
     *      @SWG\Response(
     *         response = 200,
     *         description = "Change password response",
     *         @SWG\Schema(ref="#/definitions/SuccessResponse"),
     *              examples={
     *                  "application/json": {
     *                      "responseCode": 200,
     *                      "responseMessage": "Password changed successfully.",
     *                      "responseData": {
     *                       }
     *                   }
     *         },
     *     ),
     *     @SWG\Response(
     *         response = 201,
     *         description = "Bad Request",         
     *              examples={
     *                  "application/json": {
     *                      "responseCode": 201,
     *                      "responseMessage": "Current password is incorrect.",
     *                      "responseData": {}
     *                   }
     *              }
     *     ),
     *     @SWG\Response(
     *         response="205",
     *         description="Method Not Allowed"
     *     ),
     * )
     */
    public function actionChangePassword() {
        if ($this->response->getResponseCode() == OK) {
            $this->checkAuthorization();
            if ($this->response->getResponseCode() == OK) {
                $this->response = UserMaster::changePassword($this);
            }
        }
        return $this->response->showEverything();
    }

    /**
     *  @SWG\Post(
     *      path="/user/edit-profile",
     *      tags={"User"},
     *      summary="Edit Profile",
     *      operationId="editProfile",
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
     *     @SWG\Parameter(
     *          description="Name",
     *          in="formData",
     *          name="vName",
     *          required=true,
     *          type="string",
     *          format="string",
     *          default="VB",
     *     ),
     *     @SWG\Parameter(
     *          description="Email Id",
     *          in="formData",
     *          name="vEmail",
     *          required=true,
     *          type="string",
     *          format="string",
     *          default="yagnesh.spaceo@gmail.com",
     *      ),
     *     @SWG\Parameter(
     *          description="ISD Code",
     *          in="formData",
     *          name="vNewISDCode",
     *          required=true,
     *          type="string",
     *          format="string",
     *          default="+91",
     *     ),
     *     @SWG\Parameter(
     *          description="Mobile Number",
     *          in="formData",
     *          name="vNewMobileNumber",
     *          required=true,
     *          type="string",
     *          format="string",
     *          default="7201969694",
     *     ),
     *     @SWG\Parameter(
     *          description="Profile Pic",
     *          in="formData",
     *          name="vProfilePic",
     *          required=false,
     *          type="file",
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "Edit profile success response",
     *         @SWG\Schema(ref="#/definitions/UserMasterResponse"),
     *              examples={
     *                  "application/json": {
     *                      "responseCode": 200,
     *                      "responseMessage": "Profile updated successfully.",
     *                      "responseData": {
     *                          "vAuthKey": "a54785aea69261e4f808aadce55545f5",
     *                          "iUserId": 2,
     *                          "vEmail": "yagnesh.spaceo+21@gmail.com",
     *                          "vUserName": "aaa",
     *                          "vFirstName": "Vijay",
     *                          "vLastName": "Panchal",
     *                          "dBirthDate": "1994/05/17",
     *                          "vISDCode": "+91",
     *                          "vMobileNumber": "7201969694",
     *                          "tiIsMobileVerified": 1,
     *                          "tiAcceptPush": 1,
     *                          "tiIsSocialLogin": 0,
     *                          "iNotiBadgeCount": 0,
     *                          "vProfilePic": null,
     *                          "vProfilePic": "http://172.16.17.82/project/MedSpaMaps/code/uploads/default_profile_pic.png"
     *                       }
     *                   }
     *         }
     *     ),
     *     @SWG\Response(
     *         response = 201,
     *         description = "Bad Request", 
     *         @SWG\Schema(ref="#/definitions/ErrorResponse"),             
     *              examples={
     *                  "application/json": {
     *                      "responseCode": 201,
     *                      "responseMessage": "Email ID sameerp.spaceo@gmail.com has already been taken.",
     *                      "responseData": {}
     *                   }
     *              }
     *     ),
     *     @SWG\Response(
     *         response="205",
     *         description="Method Not Allowed"
     *     ),
     * )
     */
    public function actionEditProfile() {
        if ($this->response->getResponseCode() == OK) {
            $this->checkAuthorization();
            if ($this->response->getResponseCode() == OK) {
                $this->response = UserMaster::editProfile($this);
            }
        }
        return $this->response->showEverything();
    }

    /**
     *  @SWG\Post(
     *      path="/user/contact-us",
     *      tags={"User"},
     *      summary="Contact Us",
     *      operationId="contactUs",
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
     *     @SWG\Parameter(
     *          description="Name",
     *          in="formData",
     *          name="vName",
     *          required=true,
     *          type="string",
     *          format="string",
     *          default="VB",
     *     ),
     *     @SWG\Parameter(
     *          description="Email Id",
     *          in="formData",
     *          name="vEmail",
     *          required=true,
     *          type="string",
     *          format="string",
     *          default="yagnesh.spaceo@gmail.com",
     *      ),
     *     @SWG\Parameter(
     *          description="Subject",
     *          in="formData",
     *          name="vSubject",
     *          required=true,
     *          type="string",
     *          format="string",
     *          default="+91",
     *     ),
     *     @SWG\Parameter(
     *          description="Message",
     *          in="formData",
     *          name="vMessage",
     *          required=true,
     *          type="string",
     *          format="string",
     *          default="+91",
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "Contact Us success response",
     *         @SWG\Schema(ref="#/definitions/SuccessResponse"),
     *              examples={
     *                  "application/json": {
     *                      "responseCode": 201,
     *                      "responseMessage": "contect_us_success.",
     *                   }
     *         }
     *     ),
     *     @SWG\Response(
     *         response = 201,
     *         description = "Bad Request",     
     *         @SWG\Schema(ref="#/definitions/ErrorResponse"),     
     *              examples={
     *                  "application/json": {
     *                      "responseCode": 201,
     *                      "responseMessage": "Message cannot be blank.",
     *                   }
     *              }
     *     ),
     *     @SWG\Response(
     *         response="205",
     *         description="Method Not Allowed"
     *     ),
     * )
     */
    public function actionContactUs() {
        if ($this->response->getResponseCode() == OK) {
            $this->checkAuthorization();
            if ($this->response->getResponseCode() == OK) {
                $this->response = UserContactUs::contactUs($this);
            }
        }
        return $this->response->showEverything();
    }

    /**
     *  @SWG\Post(
     *      path="/user/sign-out",
     *      tags={"User"},
     *      summary="User Sign Out",
     *      operationId="signOut",
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
     *     @SWG\Response(
     *         response = 200,
     *         description = "Contact Us success response",
     *         @SWG\Schema(ref="#/definitions/SuccessResponse"),
     *              examples={
     *                  "application/json": {
     *                      "responseCode": 201,
     *                      "responseMessage": "signout_success.",
     *                   }
     *         }
     *     ),
     *     @SWG\Response(
     *         response = 201,
     *         description = "Bad Request",     
     *         @SWG\Schema(ref="#/definitions/ErrorResponse"),     
     *              examples={
     *                  "application/json": {
     *                      "responseCode": 201,
     *                      "responseMessage": "signout_failed",
     *                   }
     *              }
     *     ),
     *     @SWG\Response(
     *         response="205",
     *         description="Method Not Allowed"
     *     ),
     * )
     */
    public function actionSignOut() {
        if ($this->response->getResponseCode() == OK) {
            $this->checkAuthorization();
            if ($this->response->getResponseCode() == OK) {
                $this->response = UserMaster::signOut($this);
            }
        }
        return $this->response->showEverything();
    }

    /**
     *  @SWG\Get(
     *      path="/user/profile",
     *      tags={"User"},
     *      summary="User Profile",
     *      operationId="myProfile",
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
     *     @SWG\Response(
     *         response = 200,
     *         description = "Contact Us success response",
     *         @SWG\Schema(ref="#/definitions/UserMasterResponse"),
     *              examples={
     *                  "application/json": {
     *                      "responseCode": 201,
     *                      "responseMessage": "signout_success.",
     *                   }
     *         }
     *     ),
     *     @SWG\Response(
     *         response = 201,
     *         description = "Bad Request",     
     *         @SWG\Schema(ref="#/definitions/ErrorResponse"),     
     *              examples={
     *                  "application/json": {
     *                      "responseCode": 201,
     *                      "responseMessage": "signout_failed",
     *                   }
     *              }
     *     ),
     *     @SWG\Response(
     *         response="205",
     *         description="Method Not Allowed"
     *     ),
     * )
     */
    public function actionProfile() {
        if ($this->response->getResponseCode() == OK) {
            $this->checkAuthorization();
            if ($this->response->getResponseCode() == OK) {
                $this->response = UserMaster::myProfile($this);
            }
        }
        return $this->response->showEverything();
    }

}
