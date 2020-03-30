<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of rightsManager
 *
 * @author ZE-KAIZER
 */
require 'rights.class.php';

class rightsManager extends Manager {

    private $db;

    function __construct() {
        
    }

    public function all_rights() {
        $this->db = parent::getconnect();
        $query = $this->db->query('SELECT member.fullname, arid,amount,date,'
                . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                . ' FROM adhesionrights INNER JOIN member ON adhesionrights.memid = member.memid INNER JOIN cycles ON adhesionrights.cycid=cycles.cycid WHERE cycles.status="Active" LIMIT 0,10');
        $list = array();

        while ($data = $query->fetch()) {
            $list[] = new rights($data);
        }
        $query1 = $this->db->query('SELECT COUNT(*) AS rightcount FROM adhesionrights INNER JOIN cycles ON adhesionrights.cycid = cycles.cycid WHERE Cycles.status="Active"');
        $data = $query1->fetch();
        $count = $data['rightcount'];
        $final = array(
            'list' => $list,
            'count' => $count
        );
        return $final;
    }

    public function insert($par) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("INSERT INTO `adhesionrights` (`arid`, `memid`, `cycid`, `amount`, `date`) VALUES (NULL, ?, ?, ?, ?)");
        $append = array($par['member'], $par['active'], $par['amount'], $par['date']);
        if ($query->execute($append)) {
            $id = $this->max_id();
            if ($_SESSION['online']->getmemid() > 1) {
                $mem = $this->return_right($id);
                $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Ajout adhésion', NOW(), CONCAT('Adhésion ==> ',?))");
                $query1->execute(array($_SESSION['online']->getmemid(), $mem->getfullname() . ' > ' . $mem->getamount() . ' > ' . $mem->getdate()));
            }
            return "$id";
        } else {
            return "problem with the query";
        }
    }

    public function max_id() {
        $this->db = parent::getconnect();
        $query = $this->db->query('SELECT MAX(arid) AS maximum FROM adhesionrights');
        $data = $query->fetch();
        return $data['maximum'];
    }

    public function return_right($id) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare('SELECT member.fullname, arid,amount,date,'
                . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                . ' FROM adhesionrights INNER JOIN member ON adhesionrights.memid = member.memid INNER JOIN cycles ON adhesionrights.cycid=cycles.cycid WHERE arid = ? AND cycles.status="Active"');
        if ($query->execute(array($id))) {
            $data = $query->fetch();
            $cycle = new rights($data);
            return $cycle;
        } else {
            return "problem with the query";
        }
    }

    public function edit($par) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("UPDATE `adhesionrights` SET `memid` = ?, `amount` = ?, `date` = ? WHERE `adhesionrights`.`arid` = ?");
        $append = array($par['member'], $par['amount'], $par['date'], $par['ID']);
        if ($query->execute($append)) {
            if ($_SESSION['online']->getmemid() > 1) {
                $mem = $this->return_right($par['ID']);
                $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Modification adhésion', NOW(), CONCAT('Adhésion ==> ',?))");
                $query1->execute(array($_SESSION['online']->getmemid(), $mem->getfullname() . ' > ' . $mem->getamount() . ' > ' . $mem->getdate()));
            }
            return true;
        } else {
            return 'problem with the query';
        }
    }

    public function delete($id) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("DELETE FROM `adhesionrights` WHERE `adhesionrights`.`arid` = ? ");
        if ($_SESSION['online']->getmemid() > 1) {
            $mem = $this->return_right($id);
            $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Supréssion adhésion', NOW(), CONCAT('Adhésion ==> ',?))");
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
            $query = $this->db->prepare('SELECT member.fullname, arid,amount,date,'
                    . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                    . ' FROM adhesionrights INNER JOIN member ON adhesionrights.memid = member.memid INNER JOIN cycles ON adhesionrights.cycid=cycles.cycid WHERE fullname LIKE CONCAT ("%",?,"%") AND Cycles.status="Active"');
            $query->execute(array($par['name']));
        } elseif ($par['month'] != "") {
            $query = $this->db->prepare('SELECT member.fullname, arid,amount,date,'
                    . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                    . ' FROM adhesionrights INNER JOIN member ON adhesionrights.memid = member.memid INNER JOIN cycles ON adhesionrights.cycid=cycles.cycid WHERE fullname LIKE CONCAT ("%",?,"%") AND CONCAT(MONTH(date),YEAR(date)) = CONCAT(MONTH(?),YEAR(?)) AND cycles.status="Active"');
            $query->execute(array($par['name'], $par['month'],$par['month']));
        }
        $list = array();
        while ($data = $query->fetch()) {
            $list[] = new rights($data);
        }
        return $list;
    }

    public function right_pagination($pagination) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare('SELECT member.fullname, arid,amount,date,'
                . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                . ' FROM adhesionrights INNER JOIN member ON adhesionrights.memid = member.memid INNER JOIN cycles ON adhesionrights.cycid=cycles.cycid WHERE cycles.status="Active" LIMIT ?,10');
        $query->execute(array($pagination));
        $list = array();

        while ($data = $query->fetch()) {
            $list[] = new rights($data);
        }
        $query1 = $this->db->query('SELECT COUNT(*) AS rightcount FROM adhesionrights INNER JOIN cycles ON adhesionrights.cycid = cycles.cycid WHERE Cycles.status="Active"');
        $data = $query1->fetch();
        $count = $data['rightcount'];
        $final = array(
            'list' => $list,
            'count' => $count
        );
        return $final;
    }

    public function sum_rights() {
        $this->db = parent::getconnect();
        $query = $this->db->query("SELECT SUM(amount) as rights FROM adhesionrights INNER JOIN cycles ON adhesionrights.cycid = cycles.cycid WHERE cycles.status= 'Active'");
        $data = $query->fetch();
        return $data['rights'];
    }
    
    public function rights_month($month) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("SELECT SUM(amount) as rights FROM adhesionrights INNER JOIN cycles ON adhesionrights.cycid = cycles.cycid WHERE CONCAT(MONTH(date),YEAR(date)) = CONCAT(MONTH(?),YEAR(?))");
        $query->execute(array($month,$month));
        $data = $query->fetch();
        return $data['rights'];
    }
}
