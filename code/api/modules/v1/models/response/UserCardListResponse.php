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
 *   @SWG\Xml(name="UserCardListResponse")
 * )
 */
class UserCardListResponse {

    /**
     * @SWG\Property(format="int32")
     * @var int
     */
    private $responseCode;

    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $responseMessage;

    /**
     * @SWG\Property(type="array", @SWG\Items(ref="#/definitions/UserCardResponseData"))
     * @var responseData
     */
    private $responseData;

    function getResponseCode() {
        return $this->responseCode;
    }

    function getResponseMessage() {
        return $this->responseMessage;
    }

    function getResponseData() {
        return $this->responseData;
    }

    function setResponseCode($responseCode) {
        $this->responseCode = $responseCode;
    }

    function setResponseMessage($responseMessage) {
        $this->responseMessage = $responseMessage;
    }

    function setResponseData($responseData) {
        $this->responseData = $responseData;
    }

    public static function withData($responseCode, $responseMessage, $responseData = []) {
        $instance = new self();
        $instance->setResponseCode($responseCode);
        $instance->setResponseMessage($responseMessage);
        $instance->setResponseData($responseData);
        return $instance;
    }

    public function showEverything() {
        return get_object_vars($this);
    }
    
}
