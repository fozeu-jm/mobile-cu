<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of loanrefund
 *
 * @author ZE-KAIZER
 */
class loanrefund {

    // **********************
    // ATTRIBUTE DECLARATION
    // **********************

    var $refid;   // KEY ATTR. WITH AUTOINCREMENT
    var $cycid;   // (normal Attribute)
    var $loanid;   // (normal Attribute)
    var $amount;   // (normal Attribute)
    var $labels;   // (normal Attribute)
    var $date;   // (normal Attribute)
    var $fullname;
    var $l_amount;
    var $l_date;
    var $rate;
    
    
     // **********************
    // CONSTRUCTOR METHOD
    // **********************

    public function __construct(array $data) {
        $this->hydrate($data);
    }

    // **********************
    // GETTER METHODS
    // **********************

    function getrefid() {
        return $this->refid;
    }

    function getcycid() {
        return $this->cycid;
    }

    function getloanid() {
        return $this->loanid;
    }

    function getamount() {
        return $this->amount;
    }

    function getlabels() {
        return $this->labels;
    }

    function getdate() {
        return $this->date;
    }

    function getfullname() {
        return $this->fullname;
    }
    
    function getl_amount() {
        return $this->l_amount;
    }

    function getl_date() {
        return $this->l_date;
    }
    
    function getrate() {
        return $this->rate;
    }





// **********************
// SETTER METHODS
// **********************


    function setrefid($val) {
        $this->refid = $val;
    }

    function setcycid($val) {
        $this->cycid = $val;
    }

    function setloanid($val) {
        $this->loanid = $val;
    }

    function setamount($val) {
        $this->amount = $val;
    }

    function setlabels($val) {
        $this->labels = $val;
    }

    function setdate($val) {
        $this->date = $val;
    }

    function setfullname($fullname) {
        $this->fullname = $fullname;
    }
    
    function setl_amount($l_amount) {
        $this->l_amount = $l_amount;
    }

    function setl_date($l_date) {
        $this->l_date = $l_date;
    }
    
    function setrate($rate) {
        $this->rate = $rate;
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
