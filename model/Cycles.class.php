<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cycles
 *
 * @author ZE-KAIZER
 */
class Cycles {
    var $cycid;   // KEY ATTR. WITH AUTOINCREMENT
    var $memid;   // (normal Attribute)
    var $begindate;   // (normal Attribute)
    var $enddate;   // (normal Attribute)
    var $status;   // (normal Attribute)
    var $intialfond;   // (normal Attribute)
    var $president;

// **********************
// CONSTRUCTOR METHOD
// **********************

    public function __construct(array $data) {
        $this->hydrate($data);
    }


// **********************
// GETTER METHODS
// **********************


    function getcycid()
    {
        return $this->cycid;
    }

    function getmemid()
    {
        return $this->memid;
    }

    function getbegindate()
    {
        return $this->begindate;
    }

    function getenddate()
    {
        return $this->enddate;
    }

    function getstatus()
    {
        return $this->status;
    }

    function getintialfond()
    {
        return $this->intialfond;
    }
    function getpresident() {
        return $this->president;
    }


// **********************
// SETTER METHODS
// **********************


    function setcycid($val)
    {
        $this->cycid =  $val;
    }

    function setmemid($val)
    {
        $this->memid =  $val;
    }

    function setbegindate($val)
    {
        $this->begindate =  $val;
    }

    function setenddate($val)
    {
        $this->enddate =  $val;
    }

    function setstatus($val)
    {
        $this->status =  $val;
    }

    function setintialfond($val)
    {
        $this->intialfond =  $val;
    }
    function setpresident($president) {
        $this->president = $president;
    }

        
     /***** Hydrate function *********************/
    
    public function hydrate(array $data){
            
            foreach ($data as $key => $value) {
                
                //form name of setter method corresponding to class attribut
                $method='set'.$key;
                
                //check if fromed method exist in the class student effectively
                if (method_exists($this, $method)) {
                    
                    //call setter using formed named stored in $method variable
                    $this->$method($value);
                }
            }
        }
}
