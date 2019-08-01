<?php

namespace api\modules\v1\models;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProfileURL
 *
 * @author sotsys236
 */

/**
 * @SWG\Definition(
 *   type="object",
 *   @SWG\Xml(name="ProfileURL")
 * )
 */
class ProfileURL {

    //put your code here
    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $vMediaName;

    public function setVMediaName($vMediaName) {
        $this->vMediaName = $vMediaName;
    }

    public function getVMediaName() {
        return $this->vMediaName;
    }
    
    public function showEverything() {
        return get_object_vars($this);
    } 
}
