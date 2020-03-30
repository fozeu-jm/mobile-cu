<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of comission
 *
 * @author ZE-KAIZER
 */
class comission {

    // **********************
    // ATTRIBUTE DECLARATION
    // **********************

    var $scomid;   // KEY ATTR. WITH AUTOINCREMENT
    var $cycid;   // (normal Attribute)
    var $rate;   // (normal Attribute)
    var $amount;   // (normal Attribute)
    var $cycle;

    // **********************
    // CONSTRUCTOR METHOD
    // **********************

    public function __construct(array $data) {
        $this->hydrate($data);
    }

    // **********************
    // GETTER METHODS
    // **********************


    function getscomid() {
        return $this->scomid;
    }

    function getcycid() {
        return $this->cycid;
    }

    function getrate() {
        return $this->rate;
    }

    function getamount() {
        return $this->amount;
    }

    function getcycle() {
        return $this->cycle;
    }

    // **********************
    // SETTER METHODS
    // **********************


    function setscomid($val) {
        $this->scomid = $val;
    }

    function setcycid($val) {
        $this->cycid = $val;
    }

    function setrate($val) {
        $this->rate = $val;
    }

    function setamount($val) {
        $this->amount = $val;
    }

    function setcycle($cycle) {
        $this->cycle = $cycle;
    }

    /*     * *** Hydrate function ******************** */

    public function hydrate(array $data) {

        foreach ($data as $key => $value) {

            //form name of setter method corresponding to class attribut
            $method = 'set' . $key;

            //check if fromed method exist in the class student effectively
            if (method_exists($this, $method)) {

                //call setter using formed named stored in $method variable
                $this->$method($value);
            }
        }
    }

}
