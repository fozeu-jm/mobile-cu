<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of session
 *
 * @author ZE-KAIZER
 */
class session {

    // **********************
    // ATTRIBUTE DECLARATION
    // **********************

    var $sessionid;   // KEY ATTR. WITH AUTOINCREMENT
    var $active;   // (normal Attribute)

    // **********************
    // CONSTRUCTOR METHOD
    // **********************

    public function __construct(array $data) {
        $this->hydrate($data);
    }

    // **********************
    // GETTER METHODS
    // **********************


    function getsessionid() {
        return $this->sessionid;
    }

    function getactive() {
        return $this->active;
    }

    // **********************
    // SETTER METHODS
    // **********************


    function setsessionid($val) {
        $this->sessionid = $val;
    }

    function setactive($val) {
        $this->active = $val;
    }
    
    /* * *** Hydrate function ******************** */

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
