<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of contribution
 *
 * @author ZE-KAIZER
 */
class contribution {

    // **********************
// ATTRIBUTE DECLARATION
// **********************

    var $contid;   // KEY ATTR. WITH AUTOINCREMENT
    var $cycid;   // (normal Attribute)
    var $memid;   // (normal Attribute)
    var $fullname;
    var $cycle;
    var $tord;
    var $ts;
    var $ordinary;
    var $special;
    var $depositdate;   // (normal Attribute)
    var $meetingdate;   // (normal Attribute)
    var $meal;   // (normal Attribute)
    var $labels;

    // **********************
// CONSTRUCTOR METHOD
// **********************

    public function __construct(array $data) {
        $this->hydrate($data);
    }

    // **********************
// GETTER METHODS
// **********************

    function getcontid() {
        return $this->contid;
    }

    function getcycid() {
        return $this->cycid;
    }

    function getmemid() {
        return $this->memid;
    }

    function getdepositdate() {
        return $this->depositdate;
    }

    function getmeetingdate() {
        return $this->meetingdate;
    }

    function getmeal() {
        return $this->meal;
    }

    function getfullname() {
        return $this->fullname;
    }

    function getcycle() {
        return $this->cycle;
    }

    function gettord() {
        return $this->to;
    }

    function getts() {
        return $this->ts;
    }

    function getordinary() {
        return $this->ordinary;
    }

    function getspecial() {
        return $this->special;
    }

    function getlabels() {
        return $this->labels;
    }

// **********************
// SETTER METHODS
// **********************


    function setcontid($val) {
        $this->contid = $val;
    }

    function setcycid($val) {
        $this->cycid = $val;
    }

    function setmemid($val) {
        $this->memid = $val;
    }

    function setdepositdate($val) {
        $this->depositdate = $val;
    }

    function setmeetingdate($val) {
        $this->meetingdate = $val;
    }

    function setmeal($val) {
        $this->meal = $val;
    }

    function setfullname($fullname) {
        $this->fullname = $fullname;
    }

    function setCycle($cycle) {
        $this->cycle = $cycle;
    }

    function settord($to) {
        $this->to = $to;
    }

    function setts($ts) {
        $this->ts = $ts;
    }

    function setordinary($ordinary) {
        $this->ordinary = $ordinary;
    }

    function setspecial($special) {
        $this->special = $special;
    }
    
    function setlabels($labels) {
        $this->labels = $labels;
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
