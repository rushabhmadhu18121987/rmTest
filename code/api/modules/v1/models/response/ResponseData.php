<?php

namespace api\modules\v1\models;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserResponse
 *
 * @author sotsys236
 */


/**
 * @SWG\Definition(
 *   type="object",
 *   @SWG\Xml(name="ResponseData")
 * )
 */
class ResponseData {

    //put your code here
    /**
     * @SWG\Property(format="int64")
     * @var int
     */
    private $iUserId;
    
    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $vFirstName;
    
    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $vLastName;
    
    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $vEmail;
    
    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $bSocialType;
    
    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $vAuthKey;
    
    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $imageBaseUrl;
    
    /**
     * @SWG\Property(type="array", @SWG\Items(ref="#/definitions/ProfileURL"))
     * @var profileURL
     */
    private $profileURL = [];
    
    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $social;

    public function __construct() {
        
    }
    
    public static function withModel($model) {
        $instance = new self();

        $instance->setiUserId($model->iUserId);
        $instance->setVFirstName($model->vFirstName);
        $instance->setVLastName($model->vLastName);
        $instance->setVUserName($model->vUserName);
        $instance->setVEmail($model->vEmail);
        $instance->setBSocialType($model->bSocialType == 0 ? 'Normal' : 'Social');
        $instance->setVAuthKey($model->vAuthKey);

        return $instance;
    }

    public function getIUserId() {
        return $this->iUserId;
    }

    public function getVFirstName() {
        return $this->vFirstName;
    }
    public function getVUserName() {
        return $this->vFirstName;
    }

    public function getVLastName() {
        return $this->vLastName;
    }

    public function getVEmail() {
        return $this->vEmail;
    }

    public function getBSocialType() {
        return $this->bSocialType;
    }

    public function getVAuthKey() {
        return $this->vAuthKey;
    }

    public function getImageBaseUrl() {
        return $this->imageBaseUrl;
    }

    public function getProfileURL() {
        return $this->profileURL;
    }

    public function getSocial() {
        return $this->social;
    }

    public function setIUserId($iUserId) {
        $this->iUserId = $iUserId;
    }

    public function setVFirstName($vFirstName) {
        $this->vFirstName = $vFirstName;
    }

    public function setVLastName($vLastName) {
        $this->vLastName = $vLastName;
    }
    public function setVUserName($vLastName) {
        $this->vLastName = $vLastName;
    }

    public function setVEmail($vEmail) {
        $this->vEmail = $vEmail;
    }

    public function setBSocialType($bSocialType) {
        $this->bSocialType = $bSocialType;
    }

    public function setVAuthKey($vAuthKey) {
        $this->vAuthKey = $vAuthKey;
    }

    public function setImageBaseUrl($imageBaseUrl) {
        $this->imageBaseUrl = $imageBaseUrl;
    }

    public function setProfileURL($profileURL) {
        $this->profileURL = $profileURL;
    }

    public function setSocial($social) {
        $this->social = $social;
    }
    
    public function showEverything() {
        return get_object_vars($this);
    } 
}
