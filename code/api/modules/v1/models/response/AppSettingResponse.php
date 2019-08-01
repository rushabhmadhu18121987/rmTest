<?php

namespace api\modules\v1\models\response;

use Yii;

/**
 * @SWG\Definition(
 *   type="object",
 *   @SWG\Xml(name="AppSettingResponse")
 * )
 */
class AppSettingResponse {

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
     * @var AppSettingResponseData
     */
    private $responseData; //put your code here

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
