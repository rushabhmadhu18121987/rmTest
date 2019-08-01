<?php

namespace api\modules\v1\models\response;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ResetPinFinalResponse
 *
 * @author sotsys236
 */

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="ResetPinFinalResponse"))
 */
class ResetPinFinalResponse {

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
     * @SWG\Property(format="array")
     * @var ResetPinResponseFields
     */
    private $responseData = [];

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

    function setResponseData(responseData $responseData) {
        $this->responseData = $responseData;
    }



}