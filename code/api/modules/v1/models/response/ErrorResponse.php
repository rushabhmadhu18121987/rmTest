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
 * @SWG\Definition(required={"username", "email"}) 
 */
class ErrorResponse {

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

    public function getResponseCode() {
        return $this->responseCode;
    }

    public function getResponseMessage() {
        return $this->responseMessage;
    }

    public function setResponseCode($responseCode) {
        $this->responseCode = $responseCode;
    }

    public function setResponseMessage($responseMessage) {
        $this->responseMessage = $responseMessage;
    }

    public static function withData($responseCode, $responseMessage) {
        $instance = new self();
        $instance->setResponseCode($responseCode);
        $instance->setResponseMessage($responseMessage);
        return $instance;
    }

    public function showEverything() {
        return get_object_vars($this);
    }

}
