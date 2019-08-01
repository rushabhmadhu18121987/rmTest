<?php

namespace api\modules\v1\models\response;

use Yii;

/**
 * @SWG\Definition(
 *   type="object",
 *   @SWG\Xml(name="UserMasterResponseFields")
 * )
 */
class UserMasterResponseData {

    /**
     * @SWG\Property(format="int32")
     * @var int
     */
    private $iUserId;

    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $vName;

    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $vEmail;

    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $vISDCode;

    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $vMobileNumber;

    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $vNewISDCode;

    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $vNewMobileNumber;

    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $vStripeCustomerId;

    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $vBrainTreeCustomerId;

    /**
     * @SWG\Property(format="int32")
     * @var int
     */
    private $tiIsMobileVerified;

    /**
     * @SWG\Property(format="int32")
     * @var int
     */
    private $tiAcceptPush;

    /**
     * @SWG\Property(format="int32")
     * @var int
     */
    private $tiIsSocialLogin;

    /**
     * @SWG\Property(format="int32")
     * @var int
     */
    private $tiIsSetPassword;

    /**
     * @SWG\Property(format="int32")
     * @var int
     */
    private $iNotiBadgeCount;

    /**
     * @SWG\Property(format="int32")
     * @var int
     */
    private $iRegistrationProgress;

    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $vProfilePic;

    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $vAuthKey;

    function getIUserId() {
        return $this->iUserId;
    }

    function getVName() {
        return $this->vName;
    }

    function getVEmail() {
        return $this->vEmail;
    }

    function getVISDCode() {
        return $this->vISDCode;
    }

    function getVMobileNumber() {
        return $this->vMobileNumber;
    }

    function getVNewISDCode() {
        return $this->vNewISDCode;
    }

    function getVNewMobileNumber() {
        return $this->vNewMobileNumber;
    }

    function getVStripeCustomerId() {
        return $this->vStripeCustomerId;
    }

    function getVBrainTreeCustomerId() {
        return $this->vBrainTreeCustomerId;
    }

    function getTiIsMobileVerified() {
        return $this->tiIsMobileVerified;
    }

    function getTiAcceptPush() {
        return $this->tiAcceptPush;
    }

    function getTiIsSocialLogin() {
        return $this->tiIsSocialLogin;
    }

    function getTiIsSetPassword() {
        return $this->tiIsSetPassword;
    }

    function getINotiBadgeCount() {
        return $this->iNotiBadgeCount;
    }

    function getIRegistrationProgress() {
        return $this->iRegistrationProgress;
    }

    function getVProfilePic() {
        return $this->vProfilePic;
    }

    function getVAuthKey() {
        return $this->vAuthKey;
    }

    function setIUserId($iUserId) {
        $this->iUserId = $iUserId;
    }

    function setVName($vName) {
        $this->vName = $vName;
    }

    function setVEmail($vEmail) {
        $this->vEmail = $vEmail;
    }

    function setVISDCode($vISDCode) {
        $this->vISDCode = $vISDCode;
    }

    function setVMobileNumber($vMobileNumber) {
        $this->vMobileNumber = $vMobileNumber;
    }

    function setVNewISDCode($vNewISDCode) {
        $this->vNewISDCode = $vNewISDCode;
    }

    function setVNewMobileNumber($vNewMobileNumber) {
        $this->vNewMobileNumber = $vNewMobileNumber;
    }

    function setVStripeCustomerId($vStripeCustomerId) {
        $this->vStripeCustomerId = $vStripeCustomerId;
    }

    function setVBrainTreeCustomerId($vBrainTreeCustomerId) {
        $this->vBrainTreeCustomerId = $vBrainTreeCustomerId;
    }

    function setTiIsMobileVerified($tiIsMobileVerified) {
        $this->tiIsMobileVerified = $tiIsMobileVerified;
    }

    function setTiAcceptPush($tiAcceptPush) {
        $this->tiAcceptPush = $tiAcceptPush;
    }

    function setTiIsSocialLogin($tiIsSocialLogin) {
        $this->tiIsSocialLogin = $tiIsSocialLogin;
    }

    function setTiIsSetPassword($tiIsSetPassword) {
        $this->tiIsSetPassword = $tiIsSetPassword;
    }

    function setINotiBadgeCount($iNotiBadgeCount) {
        $this->iNotiBadgeCount = $iNotiBadgeCount;
    }

    function setIRegistrationProgress($iRegistrationProgress) {
        $this->iRegistrationProgress = $iRegistrationProgress;
    }

    function setVProfilePic($vProfilePic) {
        $this->vProfilePic = $vProfilePic;
    }

    function setVAuthKey($vAuthKey) {
        $this->vAuthKey = $vAuthKey;
    }

    /**
     * 
     * @param \api\modules\v1\models\UserMaster $model
     */
    public static function withModel($model, $AuthKey = NULL) {
        $instance = new self();
        $instance->setiUserId($model->iUserId);
        $instance->setVName($model->vName);
        $instance->setVEmail($model->vEmail);
        $instance->setVISDCode($model->vISDCode);
        $instance->setVMobileNumber($model->vMobileNumber);
        $instance->setVNewISDCode($model->vNewISDCode);
        $instance->setVNewMobileNumber($model->vNewMobileNumber);
        $instance->setVStripeCustomerId($model->vStripeCustomerId);
        $instance->setVBrainTreeCustomerId($model->vBrainTreeCustomerId);
        $instance->setVAuthKey($AuthKey ?? $model->vAuthKey);
        $instance->setTiIsMobileVerified($model->tiIsMobileVerified);
        $instance->setTiAcceptPush($model->tiAcceptPush);
        $instance->setTiIsSocialLogin($model->tiIsSocialLogin);
        $instance->setINotiBadgeCount($model->iNotiBadgeCount);
        $instance->setTiIsSetPassword(!empty($model->vPassword) ? 1 : 0);
        $instance->setIRegistrationProgress($model->iRegistrationProgress);
        $vProfilePic = NULL;
        if (!empty($model->vProfilePic)) {
            $vProfilePic = Yii::$app->params['USERS_PROFILE_URLS'] . $model->iUserId . '/' . $model->vProfilePic;
        } else if ($model->tiIsSocialLogin == 1) {
            $socialAccount = $model->userSocialAccounts[0] ?? NULL;
            $vProfilePic = $socialAccount->vImageUrl ?? NULL;
        } else {
            $vProfilePic = Yii::$app->params['DEFAULT_IMAGE_URL'];
        }
        $instance->setVProfilePic($vProfilePic);
        return $instance;
    }

    public function showEverything() {
        return get_object_vars($this);
    }

}
