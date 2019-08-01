<?php

namespace api\modules\v1\models\response;

/**
 * @SWG\Definition(
 *   type="object",
 *   @SWG\Xml(name="SuccessResponse")
 * )
 */
class SuccessResponse {

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
    function getResponseCode() {
        return $this->responseCode;
    }

    function getResponseMessage() {
        return $this->responseMessage;
    }

    function setResponseCode($responseCode) {
        $this->responseCode = $responseCode;
    }

    function setResponseMessage($responseMessage) {
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
