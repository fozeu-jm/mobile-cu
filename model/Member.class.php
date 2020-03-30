<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Member
 *
 * @author ZE-KAIZER
 */
class Member {

    var $memid;   // KEY ATTR. WITH AUTOINCREMENT
    var $fullname;   // (normal Attribute)
    var $familysituation;   // (normal Attribute)
    var $telno;   // (normal Attribute)
    var $adresse;   // (normal Attribute)
    var $role;   // (normal Attribute)
    var $ordinarysharesno;   // (normal Attribute)
    var $specialsharesno;   // (normal Attribute)
    var $username;   // (normal Attribute)
    var $password;   // (normal Attribute)

// **********************
// CONSTRUCTOR METHOD
// **********************

    public function __construct(array $data) {
        $this->hydrate($data);
    }

// **********************
// GETTER METHODS
// **********************


    function getmemid() {
        return $this->memid;
    }

    function getfullname() {
        return $this->fullname;
    }

    function getfamilysituation() {
        return $this->familysituation;
    }

    function gettelno() {
        return $this->telno;
    }

    function getadresse() {
        return $this->adresse;
    }

    function getrole() {
        return $this->role;
    }

    function getordinarysharesno() {
        return $this->ordinarysharesno;
    }

    function getspecialsharesno() {
        return $this->specialsharesno;
    }

    function getusername() {
        return $this->username;
    }

    function getpassword() {
        return $this->password;
    }

// **********************
// SETTER METHODS
// **********************


    function setmemid($val) {
        $this->memid = $val;
    }

    function setfullname($val) {
        $this->fullname = $val;
    }

    function setfamilysituation($val) {
        $this->familysituation = $val;
    }

    function settelno($val) {
        $this->telno = $val;
    }

    function setadresse($val) {
        $this->adresse = $val;
    }

    function setrole($val) {
        $this->role = $val;
    }

    function setordinarysharesno($val) {
        $this->ordinarysharesno = $val;
    }

    function setspecialsharesno($val) {
        $this->specialsharesno = $val;
    }

    function setusername($val) {
        $this->username = $val;
    }

    function setpassword($val) {
        $this->password = $val;
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
