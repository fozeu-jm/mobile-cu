<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of operation
 *
 * @author ZE-KAIZER
 */
class operation {

    var $opid;   // KEY ATTR. WITH AUTOINCREMENT
    var $memid;   // (normal Attribute)
    var $name;   // (normal Attribute)
    var $date;   // (normal Attribute)
    var $target;   // (normal Attribute)
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


    function getopid() {
        return $this->opid;
    }

    function getmemid() {
        return $this->memid;
    }

    function getname() {
        return $this->name;
    }

    function getdate() {
        return $this->date;
    }

    function gettarget() {
        return $this->target;
    }

    function getfullname() {
        return $this->fullname;
    }

    // **********************
// SETTER METHODS
// **********************


    function setopid($val) {
        $this->opid = $val;
    }

    function setmemid($val) {
        $this->memid = $val;
    }

    function setname($val) {
        $this->name = $val;
    }

    function setdate($val) {
        $this->date = $val;
    }

    function settarget($val) {
        $this->target = $val;
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
