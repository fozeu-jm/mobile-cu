<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of voteManager
 *
 * @author ZE-KAIZER
 */
require 'vote.class.php';

class voteManager extends Manager {

    private $db;

    function __construct() {
        
    }

    public function insert($par) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("INSERT INTO `vote` (`voteid`, `memid`, `mem_memid`) VALUES (NULL, ?, ?)");
        if ($query->execute(array($par['voter'], $par['voted']))) {
            return 'Success';
        }
    }

    public function have_voted($id) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare('select count(*) as counted from vote where memid = ?');
        if ($query->execute(array($id))) {
            $data = $query->fetch();
            if ($data['counted'] > 0) {
                return true;
            } else {
                return false;
            }
        }
    }
    
    public function calc_results(){
        $this->db= parent::getconnect();
        $query=$this->db->query('select v.fullname, COUNT(*) as nb_votes from vote inner join member m on vote.memid = m.memid inner join member v on vote.mem_memid = v.memid GROUP BY v.fullname ORDER BY nb_votes DESC');
        $list = array();
        while ($data = $query->fetch()){
            $list += array($data['fullname'] => $data['nb_votes']);
        }
        return $list;
    }

}
