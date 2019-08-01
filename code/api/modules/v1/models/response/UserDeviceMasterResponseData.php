<?php

namespace api\modules\v1\models\response;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * @SWG\Definition(
 *   type="object",
 *   @SWG\Xml(name="UserDeviceMasterResponseData")
 * )
 */
class UserDeviceMasterResponseData {

    /**
     * @SWG\Property(format="int32")
     * @var int
     */
    private $iUserDeviceId;

    /**
     * @SWG\Property(format="int32")
     * @var int
     */
    private $iUserId;

    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $vAuthKey;

    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $vDeviceToken;

    /**
     * @SWG\Property(format="int32")
     * @var int
     */
    private $tiDeviceType;

    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $vDeviceName;

    public function getIUserDeviceId() {
        return $this->iUserDeviceId;
    }

    public function getIUserId() {
        return $this->iUserId;
    }

    public function getVAuthKey() {
        return $this->vAuthKey;
    }

    public function getVDeviceToken() {
        return $this->vDeviceToken;
    }

    public function getTiDeviceType() {
        return $this->tiDeviceType;
    }

    public function getVDeviceName() {
        return $this->vDeviceName;
    }

    public function setIUserDeviceId($iUserDeviceId) {
        $this->iUserDeviceId = $iUserDeviceId;
    }

    public function setIUserId($iUserId) {
        $this->iUserId = $iUserId;
    }

    public function setVAuthKey($vAuthKey) {
        $this->vAuthKey = $vAuthKey;
    }

    public function setVDeviceToken($vDeviceToken) {
        $this->vDeviceToken = $vDeviceToken;
    }

    public function setTiDeviceType($tiDeviceType) {
        $this->tiDeviceType = $tiDeviceType;
    }

    public function setVDeviceName($vDeviceName) {
        $this->vDeviceName = $vDeviceName;
    }

    public function showEverything() {
        return get_object_vars($this);
    }

    public static function withModel($model) {
        $instance = new self();
        $instance->setIUserDeviceId($model->iUserDeviceId);
        $instance->setiUserId($model->iUserId);
        $instance->setVAuthKey($model->vAuthKey);
        $instance->setVDeviceToken($model->vDeviceToken);
        $instance->setTiDeviceType($model->tiDeviceType);
        $instance->setVDeviceName($model->vDeviceName);
        $responseUser = UserMasterResponseData::withModel($model->iUser, $model->vAuthKey);
        return $instance;
    }

}
