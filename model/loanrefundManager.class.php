<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of loanrefundManager
 *
 * @author ZE-KAIZER
 */
require 'model/loanrefund.class.php';

class loanrefundManager extends Manager {

    private $db;

    function __construct() {
        
    }

    public function all() {
        $this->db = parent::getconnect();
        $query = $this->db->query("select refid,fullname,loanrefund.date,loanrefund.amount,loanrefund.labels"
                . " from loanrefund inner join loan on loanrefund.loanid = loan.loanid inner join member on member.memid = loan.memid inner join cycles on loanrefund.cycid = cycles.cycid"
                . " WHERE cycles.status='Active' ORDER BY loanrefund.date DESC LIMIT 0,10");
        $list = array();
        while ($data = $query->fetch()) {
            $list [] = new loanrefund($data);
        }

        $query1 = $this->db->query('SELECT COUNT(*) AS refcount FROM loanrefund INNER JOIN cycles ON loanrefund.cycid = cycles.cycid WHERE Cycles.status="Active"');
        $data = $query1->fetch();
        $count = $data['refcount'];

        $final = array(
            'list' => $list,
            'count' => $count
        );

        return $final;
    }

    public function insert($apr) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("INSERT INTO `loanrefund` (`refid`, `cycid`, `loanid`, `amount`, `date`,`labels`) VALUES (NULL, ?, ?, ?, ?, ?)");
        $append = array($apr['active'], $apr['loanid'], $apr['amount'], $apr['date'], $apr['label']);

        if ($query->execute($append)) {
            $id = $this->max_id();
            if ($_SESSION['online']->getmemid() > 1) {
                $mem = $this->return_refund($id);
                $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Ajout Remboursement', NOW(), CONCAT('Remboursements ==> ',?))");
                $query1->execute(array($_SESSION['online']->getmemid(), $mem->getfullname() . ' > ' . $mem->getamount() . ' > ' . $mem->getdate() . ' > ' . $mem->getlabels()));
            }
            return "$id";
        } else {
            return "problem with the query";
        }
    }

    public function max_id() {
        $this->db = parent::getconnect();
        $query = $this->db->query('SELECT MAX(refid) AS maximum FROM loanrefund');
        $data = $query->fetch();
        return $data['maximum'];
    }

    public function bymonth($month) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("select refid,fullname,loanrefund.date,loanrefund.amount,loanrefund.labels"
                . " from loanrefund inner join loan on loanrefund.loanid = loan.loanid inner join member on member.memid = loan.memid inner join cycles on loanrefund.cycid = cycles.cycid"
                . " WHERE CONCAT(MONTH(loanrefund.date),YEAR(loanrefund.date)) = CONCAT(MONTH(?),YEAR(?)) AND cycles.status='Active'");
        $list = array();
        if ($query->execute(array($month, $month))) {
            while ($data = $query->fetch()) {
                $list[] = new loanrefund($data);
            }
            return $list;
        } else {
            return null;
        }
    }

    public function return_refund($id) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("select refid,fullname,loanrefund.date,loanrefund.amount,loanrefund.labels,loan.amount AS l_amount,loan.date AS l_date,loan.rate"
                . " from loanrefund inner join loan on loanrefund.loanid = loan.loanid inner join member on member.memid = loan.memid inner join cycles on loanrefund.cycid = cycles.cycid"
                . " WHERE loanrefund.refid = ?");
        if ($query->execute(array($id))) {
            $data = $query->fetch();
            $cycle = new loanrefund($data);
            return $cycle;
        } else {
            return "problem with the query";
        }
    }

    public function report() {
        $this->db = parent::getconnect();
        $query = $this->db->query("select fullname,loanrefund.date,loanrefund.amount,loanrefund.labels"
                . " from loanrefund inner join loan on loanrefund.loanid = loan.loanid inner join member on member.memid = loan.memid inner join cycles on loanrefund.cycid = cycles.cycid"
                . " WHERE cycles.status='Active' ORDER BY loanrefund.date DESC");
        $list = array();
        while ($data = $query->fetch()) {
            $list [] = new loanrefund($data);
        }
        return $list;
    }

    public function edit($apr) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("UPDATE `loanrefund` SET  `amount` = ?, `date` = ?, `labels` = ? WHERE `loanrefund`.`refid` = ?");
        $append = array($apr['amount'], $apr['date'], $apr['label'], $apr['ID']);
        if ($query->execute($append)) {
            if ($_SESSION['online']->getmemid() > 1) {
                $mem = $this->return_refund($apr['ID']);
                $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Modification remboursements', NOW(), CONCAT('Remboursement ==> ',?))");
                $query1->execute(array($_SESSION['online']->getmemid(), $mem->getfullname() . ' > ' . $mem->getamount() . ' > ' . $mem->getdate() . ' > ' . $mem->getlabels()));
            }
            return true;
        } else {
            return 'problem with the query';
        }
    }

    public function delete($id) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("DELETE FROM `loanrefund` WHERE `loanrefund`.`refid` = ? ");
        if ($_SESSION['online']->getmemid() > 1) {
            $mem = $this->return_refund($id);
            $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Supression Remboursement', NOW(), CONCAT('Remboursements ==> ',?))");
            $query1->execute(array($_SESSION['online']->getmemid(), $mem->getfullname() . ' > ' . $mem->getamount() . ' > ' . $mem->getdate() . ' > ' . $mem->getlabels()));
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
            $query = $this->db->prepare("select refid,fullname,loanrefund.date,loanrefund.amount,loanrefund.labels"
                    . " from loanrefund inner join loan on loanrefund.loanid = loan.loanid inner join member on member.memid = loan.memid inner join cycles on loanrefund.cycid = cycles.cycid"
                    . " WHERE fullname LIKE CONCAT ('%',?,'%') AND Cycles.status='Active'");
            $query->execute(array($par['name']));
        } elseif ($par['month'] != "") {
            $query = $this->db->prepare("select refid,fullname,loanrefund.date,loanrefund.amount,loanrefund.labels"
                    . " from loanrefund inner join loan on loanrefund.loanid = loan.loanid inner join member on member.memid = loan.memid inner join cycles on loanrefund.cycid = cycles.cycid"
                    . " WHERE fullname LIKE CONCAT ('%',?,'%') AND Cycles.status='Active'  AND CONCAT(MONTH(loanrefund.date),YEAR(loanrefund.date)) = CONCAT(MONTH(?),YEAR(?)) ORDER BY loanrefund.date DESC");
            $query->execute(array($par['name'], $par['month'], $par['month']));
        }
        $list = array();
        while ($data = $query->fetch()) {
            $list[] = new loanrefund($data);
        }
        return $list;
    }

    public function pagination($pagination) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("select refid,fullname,loanrefund.date,loanrefund.amount,loanrefund.labels"
                . " from loanrefund inner join loan on loanrefund.loanid = loan.loanid inner join member on member.memid = loan.memid inner join cycles on loanrefund.cycid = cycles.cycid"
                . " WHERE cycles.status='Active' ORDER BY loanrefund.date DESC LIMIT ?,10");
        $query->execute(array($pagination));
        $list = array();
        while ($data = $query->fetch()) {
            $list [] = new loanrefund($data);
        }

        $query1 = $this->db->query('SELECT COUNT(*) AS refcount FROM loanrefund INNER JOIN cycles ON loanrefund.cycid = cycles.cycid WHERE Cycles.status="Active"');
        $data = $query1->fetch();
        $count = $data['refcount'];

        $final = array(
            'list' => $list,
            'count' => $count
        );

        return $final;
    }

    public function refund_category($par) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare('select refid,fullname,loanrefund.date,SUM(loanrefund.amount) AS amount,loanrefund.labels,'
                . ' CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                . ' from loanrefund inner join loan on loanrefund.loanid = loan.loanid inner join member on member.memid = loan.memid inner join cycles on loanrefund.cycid = cycles.cycid'
                . ' WHERE cycles.status="Active" AND loanrefund.labels = ? GROUP BY fullname ORDER BY fullname ASC');
        $query->execute(array($par));
        $list = array();
        while ($data = $query->fetch()) {
            $list [] = new loanrefund($data);
        }
        return $list;
    }

    public function laon_interest() {
        $this->db = parent::getconnect();
        $query = $this->db->query("SELECT sum(amount) as amount FROM loanrefund INNER JOIN cycles on loanrefund.cycid=cycles.cycid WHERE labels='INTERET' AND cycles.cycid='Active'");
        $data = $query->fetch();
        return $data['amount'];
    }

    public function interest_month($month) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("SELECT sum(amount) as amount FROM loanrefund INNER JOIN cycles on loanrefund.cycid=cycles.cycid WHERE labels='INTERET' AND CONCAT(MONTH(date),YEAR(date)) = CONCAT(MONTH(?),YEAR(?))");
        $query->execute(array($month, $month));
        $data = $query->fetch();
        return $data['amount'];
    }

    public function principal_month($month) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("SELECT sum(amount) as amount FROM loanrefund INNER JOIN cycles on loanrefund.cycid=cycles.cycid WHERE labels='PRINCIPALE' AND CONCAT(MONTH(date),YEAR(date)) = CONCAT(MONTH(?),YEAR(?))");
        $query->execute(array($month, $month));
        $data = $query->fetch();
        return $data['amount'];
    }
    
    public function interest() {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("SELECT sum(amount) as amount FROM loanrefund INNER JOIN cycles on loanrefund.cycid=cycles.cycid WHERE labels='INTERET' AND cycles.status='Active'");
        $data = $query->fetch();
        return $data['amount'];
    }
    
    public function total_principal() {
        $this->db = parent::getconnect();
        $query = $this->db->query("SELECT sum(amount) as amount FROM loanrefund INNER JOIN cycles on loanrefund.cycid=cycles.cycid WHERE labels='PRINCIPALE' AND cycles.status='Active'");
        $data = $query->fetch();
        return $data['amount'];
    }

}
