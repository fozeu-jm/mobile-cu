<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mealManager
 *
 * @author ZE-KAIZER
 */
require 'meal.class.php';

class mealManager extends Manager {

    private $db;

    function __construct() {
        
    }

    public function all_meals() {
        $this->db = parent::getconnect();
        $query = $this->db->query('SELECT member.fullname, mealid,amount,chequesno,date,'
                . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                . ' FROM meal INNER JOIN member ON meal.memid = member.memid INNER JOIN cycles ON meal.cycid=cycles.cycid WHERE cycles.status="Active" LIMIT 0,10');
        $list = array();

        while ($data = $query->fetch()) {
            $list[] = new meal($data);
        }
        $query1 = $this->db->query('SELECT COUNT(*) AS mealcount FROM meal INNER JOIN cycles ON meal.cycid = cycles.cycid WHERE Cycles.status="Active"');
        $data = $query1->fetch();
        $count = $data['mealcount'];
        $final = array(
            'list' => $list,
            'count' => $count
        );
        return $final;
    }

    public function insert($par) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("INSERT INTO `meal` (`mealid`, `memid`, `cycid`, `amount`, `chequesno`, `date`) VALUES (NULL, ?, ?, ?, ?, ?)");
        $append = array($par['member'], $par['active'], $par['amount'], $par['check'], $par['date']);
        if ($query->execute($append)) {
            $id = $this->max_id();
            if ($_SESSION['online']->getmemid() > 1) {
                $mem = $this->return_meal($id);
                $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Ajout répas', NOW(), CONCAT('Répas ==> ',?))");
                $query1->execute(array($_SESSION['online']->getmemid(), $mem->getfullname() . ' > ' . $mem->getamount() . ' > ' . $mem->getdate()));
            }
            return "$id";
        } else {
            return "problem with the query";
        }
    }

    public function max_id() {
        $this->db = parent::getconnect();
        $query = $this->db->query('SELECT MAX(mealid) AS maximum FROM meal');
        $data = $query->fetch();
        return $data['maximum'];
    }

    public function return_meal($id) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare('SELECT member.fullname, mealid,amount,chequesno,date,'
                . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                . ' FROM meal INNER JOIN member ON meal.memid = member.memid INNER JOIN cycles ON meal.cycid=cycles.cycid WHERE mealid = ? AND cycles.status="Active"');
        if ($query->execute(array($id))) {
            $data = $query->fetch();
            $cycle = new meal($data);
            return $cycle;
        } else {
            return "problem with the query";
        }
    }

    public function edit($par) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("UPDATE `meal` SET `memid` = ?, `amount` = ?, `chequesno` = ?, `date` = ? WHERE `meal`.`mealid` = ?");
        $append = array($par['member'], $par['amount'], $par['check'], $par['date'], $par['ID']);
        if ($query->execute($append)) {
            if ($_SESSION['online']->getmemid() > 1) {
                $mem = $this->return_meal($par['ID']);
                $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Modification répas', NOW(), CONCAT('Répas ==> ',?))");
                $query1->execute(array($_SESSION['online']->getmemid(), $mem->getfullname() . ' > ' . $mem->getamount() . ' > ' . $mem->getdate()));
            }
            return true;
        } else {
            return 'problem with the query';
        }
    }

    public function delete($id) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("DELETE FROM `meal` WHERE `meal`.`mealid` = ? ");
        if ($_SESSION['online']->getmemid() > 1) {
            $mem = $this->return_meal($id);
            $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Supression répas', NOW(), CONCAT('Répas ==> ',?))");
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
            $query = $this->db->prepare('SELECT member.fullname, mealid,amount,chequesno,date,'
                    . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                    . ' FROM meal INNER JOIN member ON meal.memid = member.memid INNER JOIN cycles ON meal.cycid=cycles.cycid WHERE fullname LIKE CONCAT ("%",?,"%") AND cycles.status="Active"');
            $query->execute(array($par['name']));
        } elseif ($par['month'] != "") {
            $query = $this->db->prepare('SELECT member.fullname, mealid,amount,chequesno,date,'
                    . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                    . ' FROM meal INNER JOIN member ON meal.memid = member.memid INNER JOIN cycles ON meal.cycid=cycles.cycid WHERE fullname LIKE CONCAT ("%",?,"%") AND CONCAT(MONTH(date),YEAR(date)) = CONCAT(MONTH(?),YEAR(?)) AND cycles.status="Active"');
            $query->execute(array($par['name'], $par['month'],$par['month']));
        }
        $list = array();
        while ($data = $query->fetch()) {
            $list[] = new meal($data);
        }
        return $list;
    }

    public function meal_pagination($pagination) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare('SELECT member.fullname, mealid,amount,chequesno,date,'
                . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                . ' FROM meal INNER JOIN member ON meal.memid = member.memid INNER JOIN cycles ON meal.cycid=cycles.cycid WHERE cycles.status="Active" LIMIT ?,10');
        $query->execute(array($pagination));
        $list = array();

        while ($data = $query->fetch()) {
            $list[] = new meal($data);
        }
        $query1 = $this->db->query('SELECT COUNT(*) AS mealcount FROM meal INNER JOIN cycles ON meal.cycid = cycles.cycid WHERE cycles.status="Active"');
        $data = $query1->fetch();
        $count = $data['mealcount'];
        $final = array(
            'list' => $list,
            'count' => $count
        );
        return $final;
    }

    public function sum_meals() {
        $this->db = parent::getconnect();
        $query = $this->db->query("SELECT sum(amount) as meals FROM meal INNER JOIN cycles ON meal.cycid = cycles.cycid WHERE cycles.status = 'Active'");
        $data = $query->fetch();
        return $data['meals'];
    }
    
    public function report(){
        $this->db = parent::getconnect();
        $query = $this->db->query('SELECT member.fullname, mealid,sum(amount) as amount,chequesno,date,'
                . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                . ' FROM meal INNER JOIN member ON meal.memid = member.memid INNER JOIN cycles ON meal.cycid=cycles.cycid WHERE cycles.status="Active" GROUP BY fullname ORDER BY fullname ASC');
        $list = array();

        while ($data = $query->fetch()) {
            $list[] = new meal($data);
        }
        
        Return $list;
    }
    public function meals_exit_month($month) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("SELECT sum(amount) as meals FROM meal INNER JOIN cycles ON meal.cycid = cycles.cycid WHERE CONCAT(MONTH(date),YEAR(date)) = CONCAT(MONTH(?),YEAR(?))");
        $query->execute(array($month,$month));
        $data = $query->fetch();
        return $data['meals'];
    }

}
