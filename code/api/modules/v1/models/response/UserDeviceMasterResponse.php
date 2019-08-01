<?php

namespace api\modules\v1\models\response;

/**
 * @SWG\Definition(
 *   type="object",
 *   @SWG\Xml(name="UserMasterResponse")
 * )
 */
class UserDeviceMasterResponse {

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
     * @var UserDeviceMasterResponseData
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

    public function showEverything() {
        return get_object_vars($this);
    }

}
