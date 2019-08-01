<?php

namespace api\modules\v1\models\response;

use Yii;

/**
 * @SWG\Definition(
 *   type="object",
 *   @SWG\Xml(name="StaticPageResponseData")
 * )
 */
class StaticPageResponseData {
    
    /**
     * @SWG\Property(format="int32")
     * @var int
     */
    private $iPageId;
    
    
    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $vPageName;
    
    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $vPageSlug;
    
    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $txContent;
    
    function getIPageId() {
        return $this->iPageId;
    }

    function getVPageName() {
        return $this->vPageName;
    }

    function getVPageSlug() {
        return $this->vPageSlug;
    }

    function getTxContent() {
        return $this->txContent;
    }

    function setIPageId($iPageId) {
        $this->iPageId = $iPageId;
    }

    function setVPageName($vPageName) {
        $this->vPageName = $vPageName;
    }

    function setVPageSlug($vPageSlug) {
        $this->vPageSlug = $vPageSlug;
    }

    function setTxContent($txContent) {
        $this->txContent = $txContent;
    }


    /**
     * 
     * @param \api\modules\v1\models\ContentPages $model
     * @return \self
     */
    public static function withModel($model) {
        $instance = new self();
        $instance->setIPageId($model->iPageId);
        $instance->setVPageName($model->vPageName);
        $instance->setVPageSlug($model->vPageSlug);
        $instance->setTxContent($model->txContent);
        return $instance;
    }

    public function showEverything() {
        return get_object_vars($this);
    }
}
