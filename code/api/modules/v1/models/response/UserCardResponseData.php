<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace api\modules\v1\models\response;

/**
 * @SWG\Definition(
 *   type="object",
 *   @SWG\Xml(name="UserCardResponseData")
 * )
 */
class UserCardResponseData {

    /**
     * @SWG\Property(format="int32")
     * @var int
     */
    private $iUserCardId;

    /**
     * @SWG\Property(format="int32")
     * @var int
     */
    private $iUserId;

    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $vCardToken;

    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $vCardHolderName;

    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $vCardBrand;

    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $vCardNo;

    /**
     * @SWG\Property(format="int32")
     * @var integer
     */
    private $iExpiryMonth;

    /**
     * @SWG\Property(format="int32")
     * @var integer
     */
    private $iExpiryYear;

    /**
     * @SWG\Property(format="int32")
     * @var int
     */
    private $tiIsDefault;

    function getIUserCardId() {
        return $this->iUserCardId;
    }

    function getIUserId() {
        return $this->iUserId;
    }

    function getVCardToken() {
        return $this->vCardToken;
    }

    function getVCardHolderName() {
        return $this->vCardHolderName;
    }

    function getVCardBrand() {
        return $this->vCardBrand;
    }

    function getVCardNo() {
        return $this->vCardNo;
    }

    function getIExpiryMonth() {
        return $this->iExpiryMonth;
    }

    function getIExpiryYear() {
        return $this->iExpiryYear;
    }

    function getTiIsDefault() {
        return $this->tiIsDefault;
    }

    function setIUserCardId($iUserCardId) {
        $this->iUserCardId = $iUserCardId;
    }

    function setIUserId($iUserId) {
        $this->iUserId = $iUserId;
    }

    function setVCardToken($vCardToken) {
        $this->vCardToken = $vCardToken;
    }

    function setVCardHolderName($vCardHolderName) {
        $this->vCardHolderName = $vCardHolderName;
    }

    function setVCardBrand($vCardBrand) {
        $this->vCardBrand = $vCardBrand;
    }

    function setVCardNo($vCardNo) {
        $this->vCardNo = $vCardNo;
    }

    function setIExpiryMonth($iExpiryMonth) {
        $this->iExpiryMonth = $iExpiryMonth;
    }

    function setIExpiryYear($iExpiryYear) {
        $this->iExpiryYear = $iExpiryYear;
    }

    function setTiIsDefault($tiIsDefault) {
        $this->tiIsDefault = $tiIsDefault;
    }

    /**
     * Create Instance Using Card Model
     * @param \api\modules\v1\models\UserCardDetails $model
     * @return \api\modules\v1\models\response\UserCardresponseData
     */
    public static function withModel($model) {
        $instance = new self();
        $instance->setIUserCardId($model->iUserCardId);
        $instance->setIUserId($model->iUserId);
        $instance->setVCardToken($model->vCardToken);
        $instance->setVCardHolderName($model->vCardHolderName);
        $instance->setVCardBrand($model->vCardBrand);
        $instance->setVCardNo($model->vCardNo);
        $instance->setIExpiryMonth($model->iExpiryMonth);
        $instance->setIExpiryYear($model->iExpiryYear);
        $instance->setTiIsDefault($model->tiIsDefault);
        return $instance;
    }

    public function showEverything() {
        return get_object_vars($this);
    }

}
