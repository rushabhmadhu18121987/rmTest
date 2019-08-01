<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace api\modules\v1\controllers\base;

use Yii;
use yii\web\Controller;
use api\modules\v1\models\AppSetting;
use api\modules\v1\models\UserMaster;
use api\modules\v1\models\UserDeviceMaster;
use api\modules\v1\models\response\SuccessResponse;
use api\modules\v1\models\response\ErrorResponse;
use api\modules\v1\models\response\UserDeviceMasterResponse;
use api\modules\v1\models\response\UserDeviceMasterResponseData;

/**
 * @SWG\Swagger(
 *      schemes={"http","https"},
 *      host=API_HOST,
 *      basePath=API_PATH,
 *      produces={"application/json","application/xml"},
 *      consumes={"application/x-www-form-urlencoded"},
 *      @SWG\Info(
 *          title=PROJECT_NAME,
 *          version=API_VERSION,
 *          description="
 *              Private Key : - Hg1dhgKS1A1MT0AI5Pf5ydf7r6vlwgjUfa9s
 *              Secret Key :- lc5dhgKS1A1MT5AI8SAMf5yds7s6vlwgjUfa9s",
 *              termsOfService="sha256",
 *          @SWG\Contact(
 *             email="yagnesh.spaceo@gmail.com"
 *          ),
 *      ),
 * )
 */

/**
 * Description of BaseController
 *
 * @author sotsys-109
 */
class BaseController extends Controller {

    /**
     * @var bool whether to enable CSRF validation for the actions in this controller.
     * CSRF validation is enabled only when both this property and [[\yii\web\Request::enableCsrfValidation]] are true.
     */
    public $enableCsrfValidation = false;

    /**
     *
     * @var \yii\web\HeaderCollection
     */
    public $headers;

    /**
     *
     * @var array $bodyParams
     */
    public $bodyParams;

    /**
     *
     * @var array $queryParams
     */
    public $queryParams;

    /**
     * 
     */
    public $response;

    /**
     * Login User Detail
     * @var \api\modules\v1\models\UserMaster 
     */
    public $iUser;

    /**
     * Login User Device Detail
     * @var \api\modules\v1\models\UserDeviceMaster 
     */
    public $iDevice;

    /**
     *
     * @var boolean 
     */
    public $responseValidate;

    /**
     *
     * @var \api\modules\v1\models\UserMaster
     */
    public $identity;

    /**
     *
     * @var  \api\modules\v1\models\response\AppSettingResponseData $appSetting
     */
    public $appSetting;

    /**
     * 
     * @param type $id
     * @param type $module
     * @author Vijay Panchal <yagnesh.spaceo@gmail.com>
     */
    public function __construct($id, $module) {
        parent::__construct($id, $module);
    }

    public function init() {
        parent::init();
        $this->bodyParams = Yii::$app->request->bodyParams;
        $this->queryParams = Yii::$app->request->queryParams;
        $this->headers = Yii::$app->request->headers;
        $this->appSetting = AppSetting::getAppSetting();
        Yii::$app->language = !empty($this->headers['lang']) ? $this->headers['lang'] : Yii::$app->params['default_language'] ?? 'en';
        $this->validateToken($this->headers);
    }

    /**
     * 
     * @param type $header
     */
    private function validateToken() {
        if (empty($this->headers['token'])) {
            $this->response = ErrorResponse::withData(BAD_REQUEST, Yii::t('response', 'token_error'));
        } else if (empty($this->headers['nonce'])) {
            $this->response = ErrorResponse::withData(BAD_REQUEST, Yii::t('response', 'nonce_error'));
        } else if (empty($this->headers['timestamp'])) {
            $this->response = ErrorResponse::withData(BAD_REQUEST, Yii::t('response', 'timestamp_error'));
        } else if ($content_type == true && $_SERVER["CONTENT_TYPE"] != 'application/x-www-form-urlencoded') {
            $this->response = ErrorResponse::withData(BAD_REQUEST, Yii::t('response', 'content_type_error'));
        } else {
            $hash_str = "nonce=" . $this->headers['nonce'] . "&timestamp=" . $this->headers['timestamp'] . "|" . SECRET_KEY;
            $sig = hash_hmac(HASH_KEY, $hash_str, PRIVATE_KEY);
            if ($sig !== $this->headers['token']) {
                $this->response = ErrorResponse::withData(BAD_REQUEST, Yii::t('response', 'token_invalid_error'));
            } else {
                $this->response = SuccessResponse::withData(OK, Yii::t('response', 'token_valid'));
            }
        }
    }

    /**
     * Check Authorization
     * @param int $tiUserType
     * @return SuccessResponse
     */
    public function checkAuthorization($tiUserType = NULL, $IsOptional = FALSE) {
        if ($this->response->getResponseCode() == OK) {
            $vAuthKey = $this->headers['Authorization'] ?? NULL;
            if (!empty($vAuthKey)) {
                $modelDevice = UserDeviceMaster::find()->where(['vAuthKey' => $vAuthKey])->one();
                if (!empty($modelDevice)) {
                    $this->iDevice = $modelDevice;
                    $this->iUser = $modelDevice->iUser ?? NULL;
                    if ($this->iUser->tiIsDeleted != 0) {
                        $this->response = ErrorResponse::withData(ACCESS_DENINED, Yii::t('response', 'account_deleted'));
                    } else if ($this->iUser->tiIsActive != 1) {
                        $this->response = ErrorResponse::withData(ACCESS_DENINED, Yii::t('response', 'account_inactive'));
                    } else if (!empty($tiUserType) && $modelDevice->iUser->tiUserType != $tiUserType) {
                        $this->response = ErrorResponse::withData(ACCESS_DENINED, Yii::t('response', 'invalid_user_type'));
                    } else {
                        $this->response = SuccessResponse::withData(OK, Yii::t('response', 'authkey_valid'));
                    }
                } else {
                    $this->response = ErrorResponse::withData(ACCESS_DENINED, Yii::t('response', 'authkey_invalid'));
                }
            } else if ($IsOptional == FALSE) {
                $this->response = ErrorResponse::withData(ACCESS_DENINED, Yii::t('response', 'authkey_required'));
            }
        }
        return $this->response;
    }

}
