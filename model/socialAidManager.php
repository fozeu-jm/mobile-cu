<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of socialAidManager
 *
 * @author ZE-KAIZER
 */
require 'socialAid.class.php';

class socialAidManager extends Manager {

    private $db;

    function __construct() {
        
    }

    public function all_aid() {
        $this->db = parent::getconnect();
        $query = $this->db->query('SELECT member.fullname, said,amount,chequesno,date,reason,'
                . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                . ' FROM socialaid INNER JOIN member ON socialaid.memid = member.memid INNER JOIN cycles ON socialaid.cycid=cycles.cycid WHERE Cycles.status="Active" LIMIT 0,10');
        $list = array();

        while ($data = $query->fetch()) {
            $list[] = new socialAid($data);
        }
        $query1 = $this->db->query('SELECT COUNT(*) AS aidcount FROM socialaid INNER JOIN cycles ON socialaid.cycid = cycles.cycid WHERE Cycles.status="Active"');
        $data = $query1->fetch();
        $count = $data['aidcount'];
        $final = array(
            'list' => $list,
            'count' => $count
        );
        return $final;
    }

    public function insert($par) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("INSERT INTO `socialaid` (`said`, `memid`, `cycid`, `amount`, `chequesno`, `date`, `reason`) VALUES (NULL, ?, ?, ?, ?, ?, ?)");
        $append = array($par['member'], $par['active'], $par['amount'], $par['check'], $par['date'], $par['reason']);
        if ($query->execute($append)) {
            $id = $this->max_id();
            if ($_SESSION['online']->getmemid() > 1) {
                $mem = $this->return_help($id);
                $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Ajout Sortie-FS', NOW(), CONCAT('Aide ==> ',?))");
                $query1->execute(array($_SESSION['online']->getmemid(), $mem->getfullname() . ' > ' . $mem->getamount() . ' > ' . $mem->getdate() . ' > ' . $mem->getreason()));
            }
            return "$id";
        } else {
            return "problem with the query";
        }
    }

    public function max_id() {
        $this->db = parent::getconnect();
        $query = $this->db->query('SELECT MAX(said) AS maximum FROM socialaid');
        $data = $query->fetch();
        return $data['maximum'];
    }

    public function return_help($id) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare('SELECT member.fullname, said,amount,chequesno,date,reason,'
                . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                . ' FROM socialaid INNER JOIN member ON socialaid.memid = member.memid INNER JOIN cycles ON socialaid.cycid=cycles.cycid WHERE said = ?');
        if ($query->execute(array($id))) {
            $data = $query->fetch();
            $cycle = new socialAid($data);
            return $cycle;
        } else {
            return "problem with the query";
        }
    }

    public function edit($par) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("UPDATE `socialaid` SET `memid` = ?, `amount` = ?, `chequesno` = ?, `date` = ?, `reason` = ? WHERE `socialaid`.`said` = ?");
        $append = array($par['member'], $par['amount'], $par['check'], $par['date'], $par['reason'], $par['ID']);
        if ($query->execute($append)) {
            if ($_SESSION['online']->getmemid() > 1) {
                $mem = $this->return_help($par['ID']);
                $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Modification Sortie-FS', NOW(), CONCAT('Aide ==> ',?))");
                $query1->execute(array($_SESSION['online']->getmemid(), $mem->getfullname() . ' > ' . $mem->getamount() . ' > ' . $mem->getdate() . ' > ' . $mem->getreason()));
            }
            return true;
        } else {
            return 'problem with the query';
        }
    }

    public function delete($id) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("DELETE FROM `socialaid` WHERE `socialaid`.`said` = ? ");
        if ($_SESSION['online']->getmemid() > 1) {
            $mem = $this->return_help($id);
            $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Supression Sortie-FS', NOW(), CONCAT('Aide ==> ',?))");
            $query1->execute(array($_SESSION['online']->getmemid(), $mem->getfullname() . ' > ' . $mem->getamount() . ' > ' . $mem->getdate() . ' > ' . $mem->getreason()));
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
            $query = $this->db->prepare('SELECT member.fullname, said,amount,chequesno,date,reason,'
                    . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                    . ' FROM socialaid INNER JOIN member ON socialaid.memid = member.memid INNER JOIN cycles ON socialaid.cycid=cycles.cycid WHERE fullname LIKE CONCAT ("%",?,"%") AND Cycles.status="Active" ORDER BY fullname ASC');
            $query->execute(array($par['name']));
        } elseif (!$par['month'] == "") {
            $query = $this->db->prepare('SELECT member.fullname, said,amount,chequesno,date,reason,'
                    . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                    . ' FROM socialaid INNER JOIN member ON socialaid.memid = member.memid INNER JOIN cycles ON socialaid.cycid=cycles.cycid WHERE fullname LIKE CONCAT ("%",?,"%") AND CONCAT(MONTH(date),YEAR(date)) = CONCAT(MONTH(?),YEAR(?)) AND Cycles.status="Active" ORDER BY fullname ASC');
            $query->execute(array($par['name'], $par['month'], $par['month']));
        }
        $list = array();
        while ($data = $query->fetch()) {
            $list[] = new socialAid($data);
        }
        return $list;
    }

    public function help_pagination($pagination) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare('SELECT member.fullname, said,amount,chequesno,date,reason,'
                . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                . ' FROM socialaid INNER JOIN member ON socialaid.memid = member.memid INNER JOIN cycles ON socialaid.cycid=cycles.cycid WHERE Cycles.status="Active" LIMIT ?,10');
        $query->execute(array($pagination));
        $list = array();

        while ($data = $query->fetch()) {
            $list[] = new socialAid($data);
        }
        $query1 = $this->db->query('SELECT COUNT(*) AS aidcount FROM socialaid INNER JOIN cycles ON socialaid.cycid = cycles.cycid WHERE Cycles.status="Active"');
        $data = $query1->fetch();
        $count = $data['aidcount'];
        $final = array(
            'list' => $list,
            'count' => $count
        );
        return $final;
    }

    public function cumulative($par) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("SELECT member.fullname, said,chequesno,date,reason,SUM(amount) AS amount"
                . " FROM socialaid INNER JOIN cycles ON socialfond.cycid=cycles.cycid"
                . " INNER JOIN member ON socialaid.memid=member.memid WHERE Cycles.status='Active' AND fullname LIKE CONCAT ('%',?,'%')"
                . " AND "
                . " GROUP BY fullname ORDER BY fullname ASC");
        $query->execute(array($par['name'],$par['month']));
        $list = array();
        while ($data = $query->fetch()) {
            $list[] = new social($data);
        }
        return $list;
    }

}
