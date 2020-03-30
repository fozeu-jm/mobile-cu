<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of meal
 *
 * @author ZE-KAIZER
 */
class meal {

    // **********************
    // ATTRIBUTE DECLARATION
    // **********************

    var $mealid;   // KEY ATTR. WITH AUTOINCREMENT
    var $cycid;   // (normal Attribute)
    var $memid;   // (normal Attribute)
    var $amount;   // (normal Attribute)
    var $chequesno;   // (normal Attribute)
    var $date;   // (normal Attribute)
    var $fullname;
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


    function getmealid() {
        return $this->mealid;
    }

    function getcycid() {
        return $this->cycid;
    }

    function getmemid() {
        return $this->memid;
    }

    function getamount() {
        return $this->amount;
    }

    function getchequesno() {
        return $this->chequesno;
    }

    function getdate() {
        return $this->date;
    }

    function getfullname() {
        return $this->fullname;
    }

    function getcycle() {
        return $this->cycle;
    }

    // **********************
    // SETTER METHODS
    // **********************


    function setmealid($val) {
        $this->mealid = $val;
    }

    function setcycid($val) {
        $this->cycid = $val;
    }

    function setmemid($val) {
        $this->memid = $val;
    }

    function setamount($val) {
        $this->amount = $val;
    }

    function setchequesno($val) {
        $this->chequesno = $val;
    }

    function setdate($val) {
        $this->date = $val;
    }
    
    function setfullname($fullname) {
        $this->fullname = $fullname;
    }

    function setcycle($cycle) {
        $this->cycle = $cycle;
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
