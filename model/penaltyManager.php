<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of penaltyManager
 *
 * @author ZE-KAIZER
 */
require 'penalty.class.php';

class penaltyManager extends Manager {

    private $db;

    function __construct() {
        
    }

    public function all_penalty() {
        $this->db = parent::getconnect();
        $query = $this->db->query('SELECT member.fullname, penid,amount,date,labels,'
                . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                . ' FROM penalty INNER JOIN member ON penalty.memid = member.memid INNER JOIN cycles ON penalty.cycid=cycles.cycid WHERE cycles.status="Active" LIMIT 0,10');
        $list = array();

        while ($data = $query->fetch()) {
            $list[] = new penalty($data);
        }
        $query1 = $this->db->query('SELECT COUNT(*) AS pencount FROM penalty INNER JOIN cycles ON penalty.cycid = cycles.cycid WHERE Cycles.status="Active"');
        $data = $query1->fetch();
        $count = $data['pencount'];
        $final = array(
            'list' => $list,
            'count' => $count
        );
        return $final;
    }

    public function insert($par) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("INSERT INTO `penalty` (`penid`, `memid`, `cycid`, `amount`, `date`, `labels`) VALUES (NULL, ?, ?, ?, ?, ?)");
        $append = array($par['member'], $par['active'], $par['amount'], $par['date'], $par['reason']);
        if ($query->execute($append)) {
            $id = $this->max_id();
            if ($_SESSION['online']->getmemid() > 1) {
                    $mem= $this->return_penalty($id);
                    $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Ajout Sanction', NOW(), CONCAT('Sanction ==> ',?))");
                    $query1->execute(array($_SESSION['online']->getmemid(),$mem->getfullname().' > '.$mem->getamount().' > '.$mem->getdate().' > '.$mem->getlabels()));
                }
            return "$id";
        } else {
            return "problem with the query";
        }
    }

    public function max_id() {
        $this->db = parent::getconnect();
        $query = $this->db->query('SELECT MAX(penid) AS maximum FROM penalty');
        $data = $query->fetch();
        return $data['maximum'];
    }

    public function return_penalty($id) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare('SELECT member.fullname, penid,amount,date,labels,'
                . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                . ' FROM penalty INNER JOIN member ON penalty.memid = member.memid INNER JOIN cycles ON penalty.cycid=cycles.cycid WHERE penid = ? AND cycles.status="Active"');
        if ($query->execute(array($id))) {
            $data = $query->fetch();
            $cycle = new penalty($data);
            return $cycle;
        } else {
            return "problem with the query";
        }
    }

    public function edit($par) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("UPDATE `penalty` SET `memid` = ?, `amount` = ?, `date` = ?, `labels` = ? WHERE `penalty`.`penid` = ?");
        $append = array($par['member'], $par['amount'], $par['date'], $par['reason'], $par['ID']);
        if ($query->execute($append)) {
            if ($_SESSION['online']->getmemid() > 1) {
                    $mem= $this->return_penalty($par['ID']);
                    $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Modification Sanction', NOW(), CONCAT('Sanction ==> ',?))");
                    $query1->execute(array($_SESSION['online']->getmemid(),$mem->getfullname().' > '.$mem->getamount().' > '.$mem->getdate().' > '.$mem->getlabels()));
                }
            return true;
        } else {
            return 'problem with the query';
        }
    }

    public function delete($id) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("DELETE FROM `penalty` WHERE `penalty`.`penid` = ? ");
         if ($_SESSION['online']->getmemid() > 1) {
                    $mem= $this->return_penalty($id);
                    $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Suppréssion Sanction', NOW(), CONCAT('Sanction ==> ',?))");
                    $query1->execute(array($_SESSION['online']->getmemid(),$mem->getfullname().' > '.$mem->getamount().' > '.$mem->getdate().' > '.$mem->getlabels()));
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
            $query = $this->db->prepare('SELECT member.fullname, penid,amount,date,labels,'
                    . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                    . ' FROM penalty INNER JOIN member ON penalty.memid = member.memid INNER JOIN cycles ON penalty.cycid=cycles.cycid WHERE fullname LIKE CONCAT ("%",?,"%") AND cycles.status="Active"');
            $query->execute(array($par['name']));
        } elseif ($par['month'] != "") {
            $query = $this->db->prepare('SELECT member.fullname, penid,amount,date,labels,'
                    . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                    . ' FROM penalty INNER JOIN member ON penalty.memid = member.memid INNER JOIN cycles ON penalty.cycid=cycles.cycid WHERE fullname LIKE CONCAT ("%",?,"%") AND CONCAT(MONTH(date),YEAR(date)) = CONCAT(MONTH(?),YEAR(?)) AND cycles.status="Active"');
            $query->execute(array($par['name'], $par['month'],$par['month']));
        }
        $list = array();
        while ($data = $query->fetch()) {
            $list[] = new penalty($data);
        }
        return $list;
    }

    public function pen_pagination($pagination) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare('SELECT member.fullname, penid,amount,date,labels,'
                . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                . ' FROM penalty INNER JOIN member ON penalty.memid = member.memid INNER JOIN cycles ON penalty.cycid=cycles.cycid LIMIT ?,10');
        $query->execute(array($pagination));
        $list = array();

        while ($data = $query->fetch()) {
            $list[] = new penalty($data);
        }
        $query1 = $this->db->query('SELECT COUNT(*) AS pencount FROM penalty');
        $data = $query1->fetch();
        $count = $data['pencount'];
        $final = array(
            'list' => $list,
            'count' => $count
        );
        return $final;
    }
    
     public function sum_pen(){
        $this->db= parent::getconnect();
        $query=$this->db->query("SELECT sum(amount) as penalties FROM penalty INNER JOIN cycles ON penalty.cycid = cycles.cycid WHERE cycles.status= 'Active'");
        $data=$query->fetch();
        return $data['penalties'];
    }
    
    public function pen_month($month){
        $this->db= parent::getconnect();
        $query=$this->db->prepare("SELECT sum(amount) as penalties FROM penalty INNER JOIN cycles ON penalty.cycid = cycles.cycid WHERE CONCAT(MONTH(date),YEAR(date)) = CONCAT(MONTH(?),YEAR(?))");
        $query->execute(array($month,$month));
        $data=$query->fetch();
        return $data['penalties'];
    }

}
