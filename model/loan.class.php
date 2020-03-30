<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of loan
 *
 * @author ZE-KAIZER
 */
class loan {

    // **********************
    // ATTRIBUTE DECLARATION
    // **********************

    var $loanid;   // KEY ATTR. WITH AUTOINCREMENT
    var $cycid;   // (normal Attribute)
    var $memid;   // (normal Attribute)
    var $amount;   // (normal Attribute)
    var $date;   // (normal Attribute)
    var $rate;   // (normal Attribute)
    var $chequesno;   // (normal Attribute)
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
    function getfullname() {
        return $this->fullname;
    }

    function getaccount() {
        return $this->account;
    }

    function getloanid() {
        return $this->loanid;
    }

    function getcycid() {
        return $this->cycid;
    }

    function getcycle() {
        return $this->cycle;
    }

    function getmemid() {
        return $this->memid;
    }

    function getamount() {
        return $this->amount;
    }

    function getdate() {
        return $this->date;
    }

    function getstatus() {
        return $this->status;
    }

    function getrefundamt() {
        return $this->refundamt;
    }

    function getrate() {
        return $this->rate;
    }

    
    function getinterestamt() {
        return $this->interestamt;
    }

    function getchequesno() {
        return $this->chequesno;
    }

// **********************
// SETTER METHODS
// **********************


    function setloanid($val) {
        $this->loanid = $val;
    }

    function setcycid($val) {
        $this->cycid = $val;
    }

    function setaccount($account) {
        $this->account = $account;
    }

    function setmemid($val) {
        $this->memid = $val;
    }

    function setamount($val) {
        $this->amount = $val;
    }

    function setcycle($cycle) {
        $this->cycle = $cycle;
    }

    function setdate($val) {
        $this->date = $val;
    }

    function setstatus($val) {
        $this->status = $val;
    }

    function setrefundamt($val) {
        $this->refundamt = $val;
    }

    function setinterestrate($val) {
        $this->interestrate = $val;
    }

    function setrate($rate) {
        $this->rate = $rate;
    }

    
    function setchequesno($val) {
        $this->chequesno = $val;
    }

    function setFullname($fullname) {
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
