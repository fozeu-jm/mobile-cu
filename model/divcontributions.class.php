<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of divcontributions
 *
 * @author ZE-KAIZER
 */
class divcontributions {

    // **********************
    // ATTRIBUTE DECLARATION
    // **********************

    var $divid;   // KEY ATTR. WITH AUTOINCREMENT
    var $memid;   // (normal Attribute)
    var $cycid;   // (normal Attribute)
    var $amount;   // (normal Attribute)
    var $date;   // (normal Attribute)
    var $fullname;

    // **********************
    // CONSTRUCTOR METHOD
    // **********************

    public function __construct(array $data) {
        $this->hydrate($data);
    }

    // **********************
    // GETTER METHODS
    // **********************


    function getdivid() {
        return $this->divid;
    }

    function getmemid() {
        return $this->memid;
    }

    function getcycid() {
        return $this->cycid;
    }

    function getamount() {
        return $this->amount;
    }

    function getdate() {
        return $this->date;
    }

    function getfullname() {
        return $this->fullname;
    }

    // **********************
    // SETTER METHODS
    // **********************


    function setdivid($val) {
        $this->divid = $val;
    }

    function setmemid($val) {
        $this->memid = $val;
    }

    function setcycid($val) {
        $this->cycid = $val;
    }

    function setamount($val) {
        $this->amount = $val;
    }

    function setdate($val) {
        $this->date = $val;
    }

    function setfullname($fullname) {
        $this->fullname = $fullname;
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
