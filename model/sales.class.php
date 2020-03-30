<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sales
 *
 * @author ZE-KAIZER
 */
class sales {

    // **********************
    // ATTRIBUTE DECLARATION
    // **********************

    var $tsid;   // KEY ATTR. WITH AUTOINCREMENT
    var $cycid;   // (normal Attribute)
    var $memid;   // (normal Attribute)
    var $sellingprice;   // (normal Attribute)
    var $amount;   // (normal Attribute)
    var $chequesno;   // (normal Attribute)
    var $type;   // (normal Attribute)
    var $date;   // (normal Attribute)
    var $cycle;
    var $fullname;
    var $tord;
    var $ts;

    // **********************
    // CONSTRUCTOR METHOD
    // **********************

    public function __construct(array $data) {
        $this->hydrate($data);
    }

// **********************
// GETTER METHODS
// **********************
    function gettsid() {
        return $this->tsid;
    }

    function getcycid() {
        return $this->cycid;
    }

    function getmemid() {
        return $this->memid;
    }

    function getsellingprice() {
        return $this->sellingprice;
    }

    function getamount() {
        return $this->amount;
    }

    function getchequesno() {
        return $this->chequesno;
    }

    function gettype() {
        return $this->type;
    }

    function getdate() {
        return $this->date;
    }

    function getcycle() {
        return $this->cycle;
    }

    function getfullname() {
        return $this->fullname;
    }

    function gettord() {
        return $this->tord;
    }

    function getts() {
        return $this->ts;
    }

    // **********************
    // SETTER METHODS
    // **********************


    function settsid($val) {
        $this->tsid = $val;
    }

    function setcycid($val) {
        $this->cycid = $val;
    }

    function setmemid($val) {
        $this->memid = $val;
    }

    function setsellingprice($val) {
        $this->sellingprice = $val;
    }

    function setamount($val) {
        $this->amount = $val;
    }

    function setchequesno($val) {
        $this->chequesno = $val;
    }

    function settype($val) {
        $this->type = $val;
    }

    function setdate($val) {
        $this->date = $val;
    }

    function setcycle($cycle) {
        $this->cycle = $cycle;
    }

    function setfullname($fullname) {
        $this->fullname = $fullname;
    }

    function settord($tord) {
        $this->tord = $tord;
    }

    function setts($ts) {
        $this->ts = $ts;
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
