<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of vote
 *
 * @author ZE-KAIZER
 */
class vote {

    // **********************
    // ATTRIBUTE DECLARATION
    // **********************

    var $voteid;   // KEY ATTR. WITH AUTOINCREMENT
    var $memid;   // (normal Attribute)
    var $mem_memid;   // (normal Attribute)
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
    function getvoteid() {
        return $this->voteid;
    }

    function getmemid() {
        return $this->memid;
    }

    function getmem_memid() {
        return $this->mem_memid;
    }

    function getfullname() {
        return $this->fullname;
    }

    // **********************
    // SETTER METHODS
    // **********************

    function setvoteid($val) {
        $this->voteid = $val;
    }

    function setmemid($val) {
        $this->memid = $val;
    }

    function setmem_memid($val) {
        $this->mem_memid = $val;
    }
    
    function setfullname($fullname) {
        $this->fullname = $fullname;
    }
    
    /*     * *** Hydrate function ******************** */

    public function hydrate(array $data) {

        foreach ($data as $key => $value) {

            //form name of setter method corresponding to class attribut
            $method = 'set' . $key;

            //check if formed method exist in the class student effectively
            if (method_exists($this, $method)) {

                //call setter using formed named stored in $method variable
                $this->$method($value);
            }
        }
    }
}
