<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of contributionManager
 *
 * @author ZE-KAIZER
 */
require 'contribution.class.php';

class contributionManager extends Manager {

    private $db;

    function __construct() {
        
    }

    public function all_contribution() {
        $this->db = parent::getconnect();
        $query = $this->db->query('SELECT member.fullname, contid,labels,'
                . 'ordinary, special, depositdate,'
                . 'meetingdate, meal,'
                . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle,'
                . 'ordinarysharesno AS tord,specialsharesno As ts'
                . ' FROM contribution INNER JOIN member ON contribution.memid = member.memid'
                . ' INNER JOIN cycles ON contribution.cycid=cycles.cycid WHERE cycles.status="Active" LIMIT 0,10');
        $list = array();

        while ($data = $query->fetch()) {
            $list[] = new contribution($data);
        }
        $query1 = $this->db->query('SELECT COUNT(*) AS contricount FROM contribution INNER JOIN cycles ON contribution.cycid = cycles.cycid WHERE Cycles.status="Active"');
        $data = $query1->fetch();
        $count = $data['contricount'];
        $final = array(
            'list' => $list,
            'count' => $count
        );
        return $final;
    }

    public function max_id() {
        $this->db = parent::getconnect();
        $query = $this->db->query('SELECT MAX(contid) AS maximum FROM contribution');
        $data = $query->fetch();
        return $data['maximum'];
    }

    public function insert($par) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare('INSERT INTO `contribution` (`contid`, `cycid`, `memid`, `depositdate`, `meetingdate`, `meal`, `ordinary`, `special`,labels) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?,?)');
        $append = array($par['active'], $par['member'], $par['date'], $par['month'], $par['meal'], $par['ordinary'], $par['special'], $par['label']);
        if ($query->execute($append)) {
            $id = $this->max_id();
            if ($_SESSION['online']->getmemid() > 1) {
                $mem = $this->return_contri($id);
                $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Ajout Contribution', NOW(), CONCAT('Contribution ==> ',?))");
                $query1->execute(array($_SESSION['online']->getmemid(), $mem->getfullname() . ' > ' . $mem->getordinary() . ' > ' . $mem->getspecial() . ' > ' . $mem->getdepositdate()));
            }
            return "$id";
        } else {
            return "problem with the query";
        }
    }

    public function return_contri($id) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare('SELECT member.fullname, contid,labels,'
                . 'ordinary, special, depositdate,'
                . 'meetingdate, meal,'
                . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle,'
                . 'ordinarysharesno AS tord,specialsharesno As ts'
                . ' FROM contribution INNER JOIN member ON contribution.memid = member.memid'
                . ' INNER JOIN cycles ON contribution.cycid=cycles.cycid where contribution.contid=? ');
        if ($query->execute(array($id))) {
            $data = $query->fetch();
            $cycle = new contribution($data);
            return $cycle;
        } else {
            return "problem with the query";
        }
    }

    public function edit($par) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("UPDATE `contribution` SET `memid` = ?, `depositdate` = ?, `meetingdate` = ?, `meal` = ?, `ordinary` = ?, `special` = ?, labels = ? WHERE `contribution`.`contid` = ?");
        $append = array($par['member'], $par['date'], $par['month'], $par['meal'], $par['ordinary'], $par['special'], $par['label'], $par['ID']);
        if ($query->execute($append)) {
            if ($_SESSION['online']->getmemid() > 1) {
                $mem = $this->return_contri($par['ID']);
                $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Modifications Contribution', NOW(), CONCAT('Contribution ==> ',?))");
                $query1->execute(array($_SESSION['online']->getmemid(), $mem->getfullname() . ' > ' . $mem->getordinary() . ' > ' . $mem->getspecial() . ' > ' . $mem->getdepositdate()));
            }
            return true;
        } else {
            return 'problem with the query';
        }
    }

    public function delete($id) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("DELETE FROM `contribution` WHERE `contribution`.`contid` =  ?");
        if ($_SESSION['online']->getmemid() > 1) {
            $mem = $this->return_contri($id);
            $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Supression Contribution', NOW(), CONCAT('Contribution ==> ',?))");
            $query1->execute(array($_SESSION['online']->getmemid(), $mem->getfullname() . ' > ' . $mem->getordinary() . ' > ' . $mem->getspecial() . ' > ' . $mem->getdepositdate()));
        }
        if ($query->execute(array($id))) {
            return true;
        } else {
            return 'problem with the query';
        }
    }

    public function search($par) {
        $this->db = parent::getconnect();
        if ($par['month'] == "" && $par['type'] == "") {
            $query = $this->db->prepare('SELECT member.fullname, contid,labels,'
                    . 'ordinary, special, depositdate,'
                    . 'meetingdate, meal,'
                    . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle,'
                    . 'ordinarysharesno AS tord,specialsharesno As ts'
                    . ' FROM contribution INNER JOIN member ON contribution.memid = member.memid'
                    . ' INNER JOIN cycles ON contribution.cycid=cycles.cycid WHERE fullname LIKE CONCAT ("%",?,"%") AND cycles.status="Active"');
            $query->execute(array($par['name']));
        } elseif ($par['month'] != "" && $par['type'] == "") {
            $query = $this->db->prepare('SELECT member.fullname, contid,labels,'
                    . 'ordinary, special, depositdate,'
                    . 'meetingdate, meal,'
                    . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle,'
                    . 'ordinarysharesno AS tord,specialsharesno As ts'
                    . ' FROM contribution INNER JOIN member ON contribution.memid = member.memid'
                    . ' INNER JOIN cycles ON contribution.cycid=cycles.cycid WHERE fullname LIKE CONCAT ("%",?,"%") AND CONCAT(MONTH(meetingdate),YEAR(meetingdate)) = CONCAT(MONTH(?),YEAR(?)) AND cycles.status="Active"');
            $query->execute(array($par['name'], $par['month'], $par['month']));
        } elseif ($par['month'] != "" && $par['type'] != "") {
            $query = $this->db->prepare('SELECT member.fullname, contid,labels,'
                    . 'ordinary, special, depositdate,'
                    . 'meetingdate, meal,'
                    . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle,'
                    . 'ordinarysharesno AS tord,specialsharesno As ts'
                    . ' FROM contribution INNER JOIN member ON contribution.memid = member.memid'
                    . ' INNER JOIN cycles ON contribution.cycid=cycles.cycid WHERE fullname LIKE CONCAT ("%",?,"%") AND CONCAT(MONTH(meetingdate),YEAR(meetingdate)) = CONCAT(MONTH(?),YEAR(?)) AND special > 0 AND cycles.status="Active"');
            $query->execute(array($par['name'], $par['month'], $par['month']));
        } elseif ($par['month'] == "" && !$par['type'] == "") {
            $query = $this->db->prepare('SELECT member.fullname, contid,labels,'
                    . 'ordinary, special, depositdate,'
                    . 'meetingdate, meal,'
                    . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle,'
                    . 'ordinarysharesno AS tord,specialsharesno As ts'
                    . ' FROM contribution INNER JOIN member ON contribution.memid = member.memid'
                    . ' INNER JOIN cycles ON contribution.cycid=cycles.cycid WHERE fullname LIKE CONCAT ("%",?,"%") AND special > 0 AND cycles.status="Active"');
            $query->execute(array($par['name']));

            $query->execute(array($par['name']));
        }
        $list = array();
        while ($data = $query->fetch()) {
            $list[] = new contribution($data);
        }
        return $list;
    }

    public function contri_pagination($pagination) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare('SELECT member.fullname, contid,labels'
                . 'ordinary, special, depositdate,'
                . 'meetingdate, meal,'
                . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle,'
                . 'ordinarysharesno AS tord,specialsharesno As ts'
                . ' FROM contribution INNER JOIN member ON contribution.memid = member.memid'
                . ' INNER JOIN cycles ON contribution.cycid=cycles.cycid WHERE cycles.status="Active" LIMIT ?,10');
        $query->execute(array($pagination));
        $list = array();

        while ($data = $query->fetch()) {
            $list[] = new contribution($data);
        }
        $query1 = $this->db->query('SELECT COUNT(*) AS contricount FROM contribution INNER JOIN cycles ON contribution.cycid = cycles.cycid WHERE Cycles.status="Active"');
        $data = $query1->fetch();
        $count = $data['contricount'];
        $final = array(
            'list' => $list,
            'count' => $count
        );
        return $final;
    }

    public function sum_contributions() {
        $this->db = parent::getconnect();
        $query = $this->db->query("SELECT sum(ordinary+special) as contributions FROM contribution INNER JOIN cycles ON contribution.cycid = cycles.cycid WHERE cycles.status= 'Active'");
        $data = $query->fetch();
        return $data['contributions'];
    }

    public function report() {
        $this->db = parent::getconnect();
        $query = $this->db->query('SELECT member.fullname, contid,labels,'
                . 'sum(ordinary) as ordinary, sum(special) as special, depositdate,'
                . 'meetingdate, sum(meal) as meal,'
                . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle,'
                . 'ordinarysharesno AS tord,specialsharesno As ts'
                . ' FROM contribution INNER JOIN member ON contribution.memid = member.memid'
                . ' INNER JOIN cycles ON contribution.cycid=cycles.cycid WHERE cycles.status="Active" GROUP BY fullname ORDER BY fullname ASC');
        $list = array();

        while ($data = $query->fetch()) {
            $list[] = new contribution($data);
        }
        return $list;
    }

    public function contrimonth($month) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("SELECT sum(special) as amount FROM contribution WHERE CONCAT(MONTH(meetingdate),YEAR(meetingdate)) = CONCAT(MONTH(?),YEAR(?)) ");
        $query->execute(array($month,$month));
        $data = $query->fetch();
        return $data['amount'];
    }
    
    public function ordinarymonth($month) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("SELECT sum(ordinary) as amount FROM contribution WHERE CONCAT(MONTH(meetingdate),YEAR(meetingdate)) = CONCAT(MONTH(?),YEAR(?)) ");
        $query->execute(array($month,$month));
        $data = $query->fetch();
        return $data['amount'];
    }
    
    public function meal_month($month) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("SELECT sum(meal) as amount FROM contribution WHERE CONCAT(MONTH(meetingdate),YEAR(meetingdate)) = CONCAT(MONTH(?),YEAR(?)) ");
        $query->execute(array($month,$month));
        $data = $query->fetch();
        return $data['amount'];
    }
    
    public function meal_sum() {
        $this->db = parent::getconnect();
        $query = $this->db->query("SELECT sum(meal) as amount FROM contribution"
                . " INNER JOIN cycles ON contribution.cycid=cycles.cycid"
                . " WHERE cycles.status= 'Active'");
        $data = $query->fetch();
        return $data['amount'];
    }
    
    public function sum_special_entry() {
        $this->db = parent::getconnect();
        $query = $this->db->query("SELECT sum(special) as contributions FROM contribution INNER JOIN cycles ON contribution.cycid = cycles.cycid WHERE cycles.status='Active'");
        $data = $query->fetch();
        return $data['contributions'];
    }
    
    public function sum_ordinary_entry() {
        $this->db = parent::getconnect();
        $query = $this->db->query("SELECT sum(ordinary) as contributions FROM contribution INNER JOIN cycles ON contribution.cycid = cycles.cycid WHERE cycles.status='Active'");
        $data = $query->fetch();
        return $data['contributions'];
    }
    

}
