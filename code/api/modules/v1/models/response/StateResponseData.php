<?php

namespace api\modules\v1\models\response;

use Yii;

/**
 * @SWG\Definition(
 *   type="object",
 *   @SWG\Xml(name="StateResponseData")
 * )
 */
class StateResponseData {

    /**
     * @SWG\Property(format="int32")
     * @var int
     */
    private $iStateId;

    /**
     * @SWG\Property(format="int32")
     * @var int
     */
    private $iCountryId;

    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $vStateName;

    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $vCountryName;

    function getIStateId() {
        return $this->iStateId;
    }

    function getICountryId() {
        return $this->iCountryId;
    }

    function getVStateName() {
        return $this->vStateName;
    }

    function getVCountryName() {
        return $this->vCountryName;
    }

    function setIStateId($iStateId) {
        $this->iStateId = $iStateId;
    }

    function setICountryId($iCountryId) {
        $this->iCountryId = $iCountryId;
    }

    function setVStateName($vStateName) {
        $this->vStateName = $vStateName;
    }

    function setVCountryName($vCountryName) {
        $this->vCountryName = $vCountryName;
    }

    /**
     * 
     * @param \api\modules\v1\models\States $model
     * @return \self
     */
    public static function withModel($model) {
        $instance = new self();
        $instance->setIStateId($model->iStateId);
        $instance->setICountryId($model->iCountryId);
        $instance->setVStateName($model->vStateName);
        $instance->setVCountryName($model->iCountry->vCountryName ?? NULL);
        return $instance;
    }

    public function showEverything() {
        return get_object_vars($this);
    }

}
