<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sessionManager
 *
 * @author ZE-KAIZER
 */
require 'session.class.php';
class sessionManager extends manager {
    private $db;

    function __construct() {
        
    }
    
    public function get_session(){
        $this->db= parent::getconnect();
        $query=$this->db->query("SELECT * FROM `session`");
        $data=$query->fetch();
        $session=new session($data);
        return $session;
    }
    
    public function edit($state){
        $this->db= parent::getconnect();
        $query=$this->db->prepare("UPDATE `session` SET `active` = ? WHERE `session`.`sessionid` = 1;");
        if($query->execute(array($state))){
            return 'success';
        }else{
            return 'failed';
        }
    }
}
