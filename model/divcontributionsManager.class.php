<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of divcontributionsManager
 *
 * @author ZE-KAIZER
 */
require 'model/divcontributions.class.php';

class divcontributionsManager extends Manager {

    private $db;

    function __construct() {
        
    }

    public function all() {
        $this->db = parent::getconnect();
        $query = $this->db->query('SELECT divid,member.fullname,date,amount'
                . ' FROM divcontributions INNER JOIN member ON divcontributions.memid = member.memid INNER JOIN cycles ON divcontributions.cycid = cycles.cycid'
                . ' WHERE cycles.status="Active" ORDER BY date DESC LIMIT 0,10');
        $list = array();
        while ($data = $query->fetch()) {
            $list [] = new divcontributions($data);
        }

        $query1 = $this->db->query('SELECT COUNT(*) AS refcount FROM divcontributions INNER JOIN cycles ON divcontributions.cycid = cycles.cycid WHERE Cycles.status="Active"');
        $data = $query1->fetch();
        $count = $data['refcount'];

        $final = array(
            'list' => $list,
            'count' => $count
        );

        return $final;
    }

    public function return_div($id) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare('SELECT divid,member.fullname,date,amount'
                . ' FROM divcontributions INNER JOIN member ON divcontributions.memid = member.memid INNER JOIN cycles ON divcontributions.cycid = cycles.cycid'
                . ' WHERE cycles.status="Active" AND divid = ? ORDER BY date DESC LIMIT 0,10');
        if ($query->execute(array($id))) {
            $data = $query->fetch();
            $cycle = new divcontributions($data);
            return $cycle;
        } else {
            return "problem with the query";
        }
    }

    public function max_id() {
        $this->db = parent::getconnect();
        $query = $this->db->query('SELECT MAX(divid) AS maximum FROM divcontributions');
        $data = $query->fetch();
        return $data['maximum'];
    }

    public function insert($apr) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("INSERT INTO `divcontributions` (`divid`, `memid`, `cycid`, `amount`, `date`) VALUES (NULL, ?, ?, ?, ?)");
        $append = array($apr['member'], $apr['active'], $apr['amount'], $apr['date']);
        if ($query->execute($append)) {
            $id = $this->max_id();
            if ($_SESSION['online']->getmemid() > 1) {
                $mem = $this->return_div($id);
                $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Ajout diverseContribtuions', NOW(), CONCAT('diverseContribtuions ==> ',?))");
                $query1->execute(array($_SESSION['online']->getmemid(), $mem->getfullname() . ' > ' . $mem->getamount() . ' > ' . $mem->getdate()));
            }
            return "$id";
        } else {
            return "problem with the query";
        }
    }

    public function edit($apr) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("UPDATE `divcontributions` SET  `memid` = ?,  `amount` = ?, `date` = ? WHERE `divcontributions`.`divid` = ?");
        $append = array($apr['member'], $apr['amount'], $apr['date'], $apr['ID']);
        if ($query->execute($append)) {
            if ($_SESSION['online']->getmemid() > 1) {
                $mem = $this->return_div($apr['ID']);
                $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Modification diverseContributions', NOW(), CONCAT('diverseContribtuions ==> ',?))");
                $query1->execute(array($_SESSION['online']->getmemid(), $mem->getfullname() . ' > ' . $mem->getamount() . ' > ' . $mem->getdate()));
            }
            return true;
        } else {
            return 'problem with the query';
        }
    }

    public function delete($id) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("DELETE FROM `divcontributions` WHERE `divcontributions`.`divid` = ?");
        if ($_SESSION['online']->getmemid() > 1) {
            $mem = $this->return_div($id);
            $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Suppression diverseContributions', NOW(), CONCAT('diverseContribtuions ==> ',?))");
            $query1->execute(array($_SESSION['online']->getmemid(), $mem->getfullname() . ' > ' . $mem->getamount() . ' > ' . $mem->getdate()));
        }
        if ($query->execute(array($id))) {
            return true;
        } else {
            return 'problem with the query';
        }
    }

    public function search($par) {
        $this->db = parent::getconnect();
        if ($par['month'] == "") {
            $query = $this->db->prepare("SELECT divid,member.fullname,date,amount"
                    . " FROM divcontributions INNER JOIN member ON divcontributions.memid = member.memid INNER JOIN cycles ON divcontributions.cycid = cycles.cycid"
                    . " WHERE fullname LIKE CONCAT ('%',?,'%') AND cycles.status='Active' ORDER BY date DESC LIMIT 0,10");
            $query->execute(array($par['name']));
        } elseif ($par['month'] != "") {
            $query = $this->db->prepare("SELECT divid,member.fullname,date,amount"
                    . " FROM divcontributions INNER JOIN member ON divcontributions.memid = member.memid INNER JOIN cycles ON divcontributions.cycid = cycles.cycid"
                    . " WHERE fullname LIKE CONCAT ('%',?,'%') AND cycles.status='Active' AND CONCAT(MONTH(date),YEAR(date)) = CONCAT(MONTH(?),YEAR(?)) ORDER BY date DESC");
            $query->execute(array($par['name'], $par['month'], $par['month']));
        }
        $list = array();
        while ($data = $query->fetch()) {
            $list[] = new divcontributions($data);
        }
        return $list;
    }

    public function pagination($pagination) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare('SELECT divid,member.fullname,date,amount'
                . ' FROM divcontributions INNER JOIN member ON divcontributions.memid = member.memid INNER JOIN cycles ON divcontributions.cycid = cycles.cycid'
                . ' WHERE cycles.status="Active" ORDER BY date DESC LIMIT ?,10');
        $query->execute(array($pagination));
        $list = array();
        while ($data = $query->fetch()) {
            $list [] = new divcontributions($data);
        }

        $query1 = $this->db->query('SELECT COUNT(*) AS refcount FROM divcontributions INNER JOIN cycles ON divcontributions.cycid = cycles.cycid WHERE Cycles.status="Active"');
        $data = $query1->fetch();
        $count = $data['refcount'];

        $final = array(
            'list' => $list,
            'count' => $count
        );

        return $final;
    }

    public function total() {
        $this->db = parent::getconnect();
        $query = $this->db->query("SELECT sum(amount) as amount FROM divcontributions INNER JOIN cycles ON divcontributions.cycid = cycles.cycid WHERE cycles.status= 'Active'");
        $data = $query->fetch();
        return $data['amount'];
    }

}
