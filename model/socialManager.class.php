<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of socialManager
 *
 * @author ZE-KAIZER
 */
require 'social.php';

class socialManager extends Manager {

    private $db;

    function __construct() {
        
    }

    public function all() {
        $this->db = parent::getconnect();
        $query = $this->db->query('SELECT sfid,amount,date,fullname,ordinarysharesno,familysituation,'
                . ' CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                . ' FROM socialfond INNER JOIN cycles ON socialfond.cycid=cycles.cycid '
                . ' INNER JOIN member ON socialfond.memid=member.memid WHERE Cycles.status="Active" LIMIT 0,10');
        $list = array();

        while ($data = $query->fetch()) {
            $list[] = new social($data);
        }
        $query1 = $this->db->query('SELECT COUNT(*) AS socialcount FROM socialfond INNER JOIN cycles ON socialfond.cycid = cycles.cycid WHERE Cycles.status="Active"');
        $data = $query1->fetch();
        $count = $data['socialcount'];
        $final = array(
            'list' => $list,
            'count' => $count
        );
        return $final;
    }

    public function insert($par) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("INSERT INTO `socialfond` (`sfid`, `cycid`, `memid`, `amount`, `date`) VALUES (NULL, ?, ?, ?, ?)");
        $append = array($par['active'], $par['member'], $par['amount'], $par['date']);
        if ($query->execute($append)) {
            $id = $this->max_id();
            if ($_SESSION['online']->getmemid() > 1) {
                $mem = $this->return_depot($id);
                $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Ajout fond-sociale', NOW(), CONCAT('fond-sociale ==> ',?))");
                $query1->execute(array($_SESSION['online']->getmemid(), $mem->getfullname() . ' > ' . $mem->getamount() . ' > ' . $mem->getdate()));
            }
            return "$id";
        } else {
            return "problem with the query";
        }
    }

    public function max_id() {
        $this->db = parent::getconnect();
        $query = $this->db->query('SELECT MAX(sfid) AS maximum FROM socialfond');
        $data = $query->fetch();
        return $data['maximum'];
    }

    public function return_depot($id) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare('SELECT sfid,amount,date,fullname,ordinarysharesno,familysituation,'
                . ' CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                . ' FROM socialfond INNER JOIN cycles ON socialfond.cycid=cycles.cycid '
                . ' INNER JOIN member ON socialfond.memid=member.memid WHERE sfid = ?');
        if ($query->execute(array($id))) {
            $data = $query->fetch();
            $cycle = new social($data);
            return $cycle;
        } else {
            return "problem with the query";
        }
    }

    public function edit($par) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("UPDATE `socialfond` SET `amount` = ?, `date` = ?, `memid` = ? WHERE `socialfond`.`sfid` = ?");
        $append = array($par['amount'], $par['date'], $par['member'], $par['ID']);
        if ($query->execute($append)) {
            if ($_SESSION['online']->getmemid() > 1) {
                $mem = $this->return_depot($par['ID']);
                $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Modifiaction fond-sociale', NOW(), CONCAT('fond-sociale ==> ',?))");
                $query1->execute(array($_SESSION['online']->getmemid(), $mem->getfullname() . ' > ' . $mem->getamount() . ' > ' . $mem->getdate()));
            }
            return true;
        } else {
            return 'problem with the query';
        }
    }

    public function delete($id) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("DELETE FROM `socialfond` WHERE `socialfond`.`sfid` = ? ");
        if ($_SESSION['online']->getmemid() > 1) {
            $mem = $this->return_depot($id);
            $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Supression fond-sociale', NOW(), CONCAT('fond-sociale ==> ',?))");
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
            $query = $this->db->prepare('SELECT sfid,amount,date,fullname,ordinarysharesno,familysituation,'
                    . ' CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                    . ' FROM socialfond INNER JOIN cycles ON socialfond.cycid=cycles.cycid '
                    . 'INNER JOIN member ON socialfond.memid=member.memid WHERE fullname LIKE CONCAT ("%",?,"%") AND Cycles.status="Active" ORDER BY fullname ASC');
            $query->execute(array($par['name']));
        } elseif (!$par['month'] == "") {
            $query = $this->db->prepare('SELECT sfid,amount,date,fullname,ordinarysharesno,familysituation,'
                    . ' CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                    . ' FROM socialfond INNER JOIN cycles ON socialfond.cycid=cycles.cycid '
                    . 'INNER JOIN member ON socialfond.memid=member.memid WHERE fullname LIKE CONCAT ("%",?,"%") AND CONCAT(MONTH(date),YEAR(date)) = CONCAT(MONTH(?),YEAR(?)) AND Cycles.status="Active" ORDER BY fullname ASC');
            $query->execute(array($par['name'], $par['month'], $par['month']));
        }
        $list = array();
        while ($data = $query->fetch()) {
            $list[] = new social($data);
        }
        return $list;
    }

    public function pagination($pagination) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare('SELECT sfid,amount,date,fullname,ordinarysharesno,familysituation,'
                . ' CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                . ' FROM socialfond INNER JOIN cycles ON socialfond.cycid=cycles.cycid '
                . ' INNER JOIN member ON socialfond.memid=member.memid WHERE Cycles.status="Active" LIMIT ?,10');
        $query->execute(array($pagination));
        $list = array();

        while ($data = $query->fetch()) {
            $list[] = new social($data);
        }
        $query1 = $this->db->query('SELECT COUNT(*) AS socialcount FROM socialfond INNER JOIN cycles ON socialfond.cycid = cycles.cycid WHERE Cycles.status="Active"');
        $data = $query1->fetch();
        $count = $data['socialcount'];
        $final = array(
            'list' => $list,
            'count' => $count
        );
        return $final;
    }

    public function sum_social() {
        $this->db = parent::getconnect();
        $query = $this->db->query("SELECT sum(amount) as help FROM socialaid INNER JOIN cycles ON socialaid.cycid = cycles.cycid WHERE cycles.status= 'Active'");
        $data = $query->fetch();
        $help = $data['help'];

        $query1 = $this->db->query("SELECT sum(amount) as fund FROM socialfond INNER JOIN cycles ON socialfond.cycid = cycles.cycid WHERE cycles.status= 'Active'");
        $data1 = $query1->fetch();
        $fund = $data1['fund'];

        return $fund - $help;
    }

    public function cumlative($par) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("SELECT sfid,date,fullname,ordinarysharesno,familysituation,SUM(amount) AS amount"
                . " FROM socialfond INNER JOIN cycles ON socialfond.cycid=cycles.cycid"
                . " INNER JOIN member ON socialfond.memid=member.memid WHERE Cycles.status='Active' AND fullname LIKE CONCAT ('%',?,'%')"
                . " GROUP BY fullname ORDER BY fullname ASC");
        $query->execute(array($par));
        $list = array();
        while ($data = $query->fetch()) {
            $list[] = new social($data);
        }
        return $list;
    }

    public function per_month($par, $months) {
        $this->db = parent::getconnect();
        $final = array();
        $valid = array();
        foreach ($months as $value) {
            $query = $this->db->prepare('SELECT sfid,date,fullname,ordinarysharesno,familysituation,SUM(amount) AS amount,'
                    . ' CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                    . ' FROM socialfond INNER JOIN cycles ON socialfond.cycid=cycles.cycid '
                    . 'INNER JOIN member ON socialfond.memid=member.memid WHERE fullname LIKE CONCAT '
                    . '("%",?,"%") AND CONCAT(MONTH(date),YEAR(date)) = CONCAT(MONTH(?),YEAR(?)) AND Cycles.status="Active" GROUP BY fullname ORDER BY fullname ASC');
            $query->execute(array($par['name'], $value, $value));
            $list = array();
            while ($data = $query->fetch()) {
                $list[] = new social($data);
            }
            if (!empty($list)) {
                $final[] = $list;
                $valid[] = $value;
            }
        }
        $superfinal = array(
            'valid' => $valid,
            'list' => $final
        );
        return $superfinal;
    }

    public function social_month($month) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("SELECT sum(amount) as help FROM socialaid INNER JOIN cycles ON socialaid.cycid = cycles.cycid WHERE CONCAT(MONTH(date),YEAR(date)) = CONCAT(MONTH(?),YEAR(?))");
        $query->execute(array($month, $month));
        $data = $query->fetch();
        $help = $data['help'];

        $query1 = $this->db->prepare("SELECT sum(amount) as fund FROM socialfond INNER JOIN cycles ON socialfond.cycid = cycles.cycid WHERE CONCAT(MONTH(date),YEAR(date)) = CONCAT(MONTH(?),YEAR(?))");
        $query->execute(array($month, $month));
        $data1 = $query1->fetch();
        $fund = $data1['fund'];

        return $fund - $help;
    }

    public function help_month($month) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("SELECT sum(amount) as help FROM socialaid INNER JOIN cycles ON socialaid.cycid = cycles.cycid WHERE CONCAT(MONTH(date),YEAR(date)) = CONCAT(MONTH(?),YEAR(?))");
        $query->execute(array($month, $month));
        $data = $query->fetch();
        $help = $data['help'];
        return $help;
    }

    public function depot_month($month) {
        $this->db = parent::getconnect();
        $query1 = $this->db->prepare("SELECT sum(amount) as fund FROM socialfond INNER JOIN cycles ON socialfond.cycid = cycles.cycid WHERE CONCAT(MONTH(date),YEAR(date)) = CONCAT(MONTH(?),YEAR(?))");
        $query1->execute(array($month, $month));
        $data1 = $query1->fetch();
        $fund = $data1['fund'];

        return $fund;
    }

    public function total_help() {
        $this->db = parent::getconnect();
        $query = $this->db->query("SELECT sum(amount) as help FROM socialaid INNER JOIN cycles ON socialaid.cycid = cycles.cycid WHERE cycles.status='Active'");
        $data = $query->fetch();
        $help = $data['help'];
        return $help;
    }

    public function total_depot() {
        $this->db = parent::getconnect();
        $query1 = $this->db->query("SELECT sum(amount) as fund FROM socialfond INNER JOIN cycles ON socialfond.cycid = cycles.cycid WHERE cycles.status='Active'");
        $data1 = $query1->fetch();
        $fund = $data1['fund'];
        return $fund;
    }

}
