<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of operationManager
 *
 * @author ZE-KAIZER
 */
require 'operation.class.php';

class operationManager extends Manager {

    private $db;

    function __construct() {
        
    }

    public function all() {
        $this->db = parent::getconnect();
        $query = $this->db->query('SELECT `opid`, `fullname`, `name`, `date`, `target` FROM `operations` INNER JOIN member ON operations.memid = member.memid ORDER BY date DESC LIMIT 0,40;');
        $list = array();

        while ($data = $query->fetch()) {
            $list[] = new operation($data);
        }

        $query1 = $this->db->query('SELECT COUNT(*) AS opcount FROM operations');
        $data = $query1->fetch();
        $count = $data['opcount'];
        $final = array(
            'list' => $list,
            'count' => $count
        );
        return $final;
    }

    public function pagination($pagination) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare('SELECT `opid`, `fullname`, `name`, `date`, `target` FROM `operations` INNER JOIN member ON operations.memid = member.memid ORDER BY date DESC LIMIT ?,40;');
        $query->execute(array($pagination));
        $list = array();

        while ($data = $query->fetch()) {
            $list[] = new operation($data);
        }

        $query1 = $this->db->query('SELECT COUNT(*) AS opcount FROM operations');
        $data = $query1->fetch();
        $count = $data['opcount'];
        $final = array(
            'list' => $list,
            'count' => $count
        );
        return $final;
    }

    public function every() {
        $this->db = parent::getconnect();
        $query = $this->db->query('SELECT `opid`, `fullname`, `name`, `date`, `target` FROM `operations` INNER JOIN member ON operations.memid = member.memid ORDER BY date DESC;');
        $list = array();

        while ($data = $query->fetch()) {
            $list[] = new operation($data);
        }
        
        return $list;
    }

}
