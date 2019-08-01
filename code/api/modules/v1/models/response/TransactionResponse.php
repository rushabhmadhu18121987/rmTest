<?php

namespace api\modules\v1\models\response;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FinalResponse
 *
 * @author sotsys236
 */

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="FinalResponse"))
 */
class TransactionResponse {

    /**
     * @SWG\Property(format="int64")
     * @var int
     */
    private $responseCode;

    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $responseMessage;

    /**
     * @var responseModel
     * @SWG\Property(format="array")
     */
    private $responseModel = [];
    
    function getResponseCode() {
        return $this->responseCode;
    }

    function getResponseMessage() {
        return $this->responseMessage;
    }

    function getResponseModel() {
        return $this->responseModel;
    }

    function setResponseCode($responseCode) {
        $this->responseCode = $responseCode;
    }

    function setResponseMessage($responseMessage) {
        $this->responseMessage = $responseMessage;
    }

    function setResponseModel($responseModel) {
        $this->responseModel = $responseModel;
    }

    
    public static function withData($responseCode, $responseMessage, $responseModel = NULL) {
        $instance = new self();
        $instance->setResponseCode($responseCode);
        $instance->setResponseMessage($responseMessage);
        $instance->setresponseModel($responseModel);
        return $instance;
    }

    //put your code here

    public function showEverything() {
        return get_object_vars($this);
    }

}
