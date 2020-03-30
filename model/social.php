<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of social
 *
 * @author ZE-KAIZER
 */
class social {

    // **********************
    // ATTRIBUTE DECLARATION
    // **********************

    var $sfid;   // KEY ATTR. WITH AUTOINCREMENT
    var $cycid;   // (normal Attribute)
    var $memid;   // (normal Attribute)
    var $amount;   // (normal Attribute)
    var $date;   // (normal Attribute)
    var $fullname; // (normal Attribute)
    var $ordinarysharesno;   // (normal Attribute)
    var $familysituation;   // (normal Attribute)

    // **********************
    // CONSTRUCTOR METHOD
    // **********************

    public function __construct(array $data) {
        $this->hydrate($data);
    }

    // **********************
// GETTER METHODS
// **********************


    function getsfid() {
        return $this->sfid;
    }

    function getcycid() {
        return $this->cycid;
    }

    function getamount() {
        return $this->amtdeposited;
    }

    function getdate() {
        return $this->date;
    }


    function getcycle() {
        return $this->cycle;
    }

    function getmemid() {
        return $this->memid;
    }

    function getfullname() {
        return $this->fullname;
    }

    function getordinarysharesno() {
        return $this->ordinarysharesno;
    }

    function getfamilysituation() {
        return $this->familysituation;
    }

    // **********************
// SETTER METHODS
// **********************


    function setsfid($val) {
        $this->sfid = $val;
    }

    function setcycid($val) {
        $this->cycid = $val;
    }

    function setamount($val) {
        $this->amtdeposited = $val;
    }

    function setdate($val) {
        $this->date = $val;
    }

    function setcycle($cycle) {
        $this->cycle = $cycle;
    }

    function setmemid($memid) {
        $this->memid = $memid;
    }

    function setfullname($fullname) {
        $this->fullname = $fullname;
    }

    function setordinarysharesno($ordinarysharesno) {
        $this->ordinarysharesno = $ordinarysharesno;
    }

    function setfamilysituation($familysituation) {
        $this->familysituation = $familysituation;
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
