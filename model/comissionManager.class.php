<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of comissionManager
 *
 * @author ZE-KAIZER
 */
require 'comission.class.php';

class comissionManager extends Manager {

    private $db;

    function __construct() {
        
    }

    public function all() {
        $this->db = parent::getconnect();
        $query = $this->db->query('SELECT scomid,amount,rate,'
                . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                . ' FROM specialcomission INNER JOIN cycles ON specialcomission.cycid=cycles.cycid LIMIT 0,10');
        $list = array();

        while ($data = $query->fetch()) {
            $list[] = new comission($data);
        }
        $query1 = $this->db->query('SELECT COUNT(*) AS comcount FROM specialcomission');
        $data = $query1->fetch();
        $count = $data['comcount'];
        $final = array(
            'list' => $list,
            'count' => $count
        );
        return $final;
    }

    public function insert($par) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("INSERT INTO `specialcomission` (`scomid`, `cycid`, `amount`, `rate`) VALUES (NULL, ?, ?, ?)");
        $append = array($par['active'], $par['amount'], $par['rate']);
        if ($query->execute($append)) {
            $id = $this->max_id();
            if ($_SESSION['online']->getmemid() > 1) {
                    $mem= $this->return_com($id);
                    $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Ajout Commission Ts.', NOW(), CONCAT('Commission ==> ',?))");
                    $query1->execute(array($_SESSION['online']->getmemid(),$mem->getamount().' > '.$mem->getrate()));
                }
            return "$id";
        } else {
            return "problem with the query";
        }
    }

    public function max_id() {
        $this->db = parent::getconnect();
        $query = $this->db->query('SELECT MAX(scomid) AS maximum FROM specialcomission');
        $data = $query->fetch();
        return $data['maximum'];
    }

    public function return_com($id) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare('SELECT scomid,amount,rate,'
                . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                . ' FROM specialcomission INNER JOIN cycles ON specialcomission.cycid=cycles.cycid WHERE scomid = ?');
        if ($query->execute(array($id))) {
            $data = $query->fetch();
            $cycle = new comission($data);
            return $cycle;
        } else {
            return "problem with the query";
        }
    }

    public function edit($par) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("UPDATE `specialcomission` SET `amount` = ?, `rate` = ? WHERE `specialcomission`.`scomid` = ?");
        $append = array($par['amount'], $par['rate'], $par['ID']);
        if ($query->execute($append)) {
            if ($_SESSION['online']->getmemid() > 1) {
                    $mem= $this->return_com($par['ID']);
                    $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Modification Commission Ts.', NOW(), CONCAT('Commission ==> ',?))");
                    $query1->execute(array($_SESSION['online']->getmemid(),$mem->getamount().' > '.$mem->getrate()));
                }
            return true;
        } else {
            return 'problem with the query';
        }
    }

    public function delete($id) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("DELETE FROM `specialcomission` WHERE `specialcomission`.`scomid` = ? ");
        if ($_SESSION['online']->getmemid() > 1) {
                    $mem= $this->return_com($id);
                    $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Supression Commission Ts.', NOW(), CONCAT('Commission ==> ',?))");
                    $query1->execute(array($_SESSION['online']->getmemid(),$mem->getamount().' > '.$mem->getrate()));
                }
        if ($query->execute(array($id))) {
            return true;
        } else {
            return 'problem with the query';
        }
    }

    public function search($par) {
        $this->db = parent::getconnect();
        if ($par['cycle'] == "") {
            $query = $this->db->prepare('SELECT scomid,amount,rate,'
                    . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                    . ' FROM specialcomission INNER JOIN cycles ON specialcomission.cycid=cycles.cycid WHERE rate LIKE CONCAT ("%",?,"%")');
            $query->execute(array(""));
        } elseif (!$par['cycle'] == "") {
            $query = $this->db->prepare('SELECT scomid,amount,rate,'
                    . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                    . ' FROM specialcomission INNER JOIN cycles ON specialcomission.cycid=cycles.cycid WHERE specialcomission.cycid = ?');
            $query->execute(array($par['cycle']));
        }
        $list = array();
        while ($data = $query->fetch()) {
            $list[] = new comission($data);
        }
        return $list;
    }

    public function pagination($pagination) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare('SELECT scomid,amount,rate,'
                . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                . ' FROM specialcomission INNER JOIN cycles ON specialcomission.cycid=cycles.cycid LIMIT ?,10');
        $query->execute(array($pagination));
        $list = array();

        while ($data = $query->fetch()) {
            $list[] = new comission($data);
        }
        $query1 = $this->db->query('SELECT COUNT(*) AS comcount FROM specialcomission');
        $data = $query1->fetch();
        $count = $data['comcount'];
        $final = array(
            'list' => $list,
            'count' => $count
        );
        return $final;
    }

    public function sum_comissions() {
        $this->db = parent::getconnect();
        $query = $this->db->query("SELECT sum(amount) as comissions FROM specialcomission INNER JOIN cycles ON specialcomission.cycid = cycles.cycid WHERE cycles.status= 'Active'");
        $data = $query->fetch();
        return $data['comissions'];
    }

}
