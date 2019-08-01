<?php

namespace api\modules\v1\models\response;

use Yii;
use yii\helpers\ArrayHelper;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @SWG\Definition(
 *   type="object",
 *   @SWG\Xml(name="ResetPinResponseFields")
 * )
 */
class ResetPinResponseFields {

    public function __construct() {
        
    }

    //put your code here
    /**
     * @SWG\Property
     * @var string
     */
    private $vEmail;


    public static function withModel($model) {
        $instance = new self();

        $instance->setvEmail($model);

        return $instance;
    }
    
    function getVEmail() {
        return $this->vEmail;
    }

    function setVEmail($vEmail) {
        $this->vEmail = $vEmail;
    }

            public function showEverything() {
        return get_object_vars($this);
    }

}
