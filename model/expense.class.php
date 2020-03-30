<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of expense
 *
 * @author ZE-KAIZER
 */
class expense {

    // **********************
    // ATTRIBUTE DECLARATION
    // **********************

    var $expid;   // KEY ATTR. WITH AUTOINCREMENT
    var $cycid;   // (normal Attribute)
    var $amount;   // (normal Attribute)
    var $labels;   // (normal Attribute)
    var $chequesno;   // (normal Attribute)
    var $date;   // (normal Attribute)
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


    function getexpid() {
        return $this->expid;
    }

    function getcycid() {
        return $this->cycid;
    }

    function getamount() {
        return $this->amount;
    }

    function getlabels() {
        return $this->labels;
    }

    function getchequesno() {
        return $this->chequesno;
    }

    function getdate() {
        return $this->date;
    }

    function getcycle() {
        return $this->cycle;
    }

    // **********************
    // SETTER METHODS
    // **********************


    function setexpid($val) {
        $this->expid = $val;
    }

    function setcycid($val) {
        $this->cycid = $val;
    }

    function setamount($val) {
        $this->amount = $val;
    }

    function setlabels($val) {
        $this->labels = $val;
    }

    function setchequesno($val) {
        $this->chequesno = $val;
    }

    function setdate($val) {
        $this->date = $val;
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
