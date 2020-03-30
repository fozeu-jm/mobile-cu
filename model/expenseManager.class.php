<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of expenseManager
 *
 * @author ZE-KAIZER
 */
require 'expense.class.php';

class expenseManager extends Manager {

    private $db;

    function __construct() {
        
    }

    public function all_spend() {
        $this->db = parent::getconnect();
        $query = $this->db->query('SELECT expid,amount,chequesno,date,labels,'
                . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                . ' FROM expenses INNER JOIN cycles ON expenses.cycid=cycles.cycid WHERE cycles.status="Active" ORDER BY date DESC LIMIT 0,10');
        $list = array();

        while ($data = $query->fetch()) {
            $list[] = new expense($data);
        }
        $query1 = $this->db->query('SELECT COUNT(*) AS expcount FROM expenses INNER JOIN cycles ON expenses.cycid = cycles.cycid WHERE Cycles.status="Active"');
        $data = $query1->fetch();
        $count = $data['expcount'];
        $final = array(
            'list' => $list,
            'count' => $count
        );
        return $final;
    }

    public function insert($par) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("INSERT INTO `expenses` (`expid`, `cycid`, `amount`, `chequesno`, `date`, `labels`) VALUES (NULL, ?, ?, ?, ?, ?)");
        $append = array($par['active'], $par['amount'], $par['check'], $par['date'], $par['reason']);
        if ($query->execute($append)) {
            $id = $this->max_id();
            if ($_SESSION['online']->getmemid() > 1) {
                    $mem= $this->return_spend($id);
                    $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Ajout Depenses', NOW(), CONCAT('Depense ==> ',?))");
                    $query1->execute(array($_SESSION['online']->getmemid(),$mem->getamount().' > '.$mem->getdate().' > '.$mem->getlabels()));
                }
            return "$id";
        } else {
            return "problem with the query";
        }
    }

    public function max_id() {
        $this->db = parent::getconnect();
        $query = $this->db->query('SELECT MAX(expid) AS maximum FROM expenses');
        $data = $query->fetch();
        return $data['maximum'];
    }

    public function return_spend($id) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare('SELECT expid,amount,chequesno,date,labels,'
                . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                . ' FROM expenses INNER JOIN cycles ON expenses.cycid=cycles.cycid WHERE expid = ?');
        if ($query->execute(array($id))) {
            $data = $query->fetch();
            $cycle = new expense($data);
            return $cycle;
        } else {
            return "problem with the query";
        }
    }

    public function edit($par) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("UPDATE `expenses` SET `amount` = ?, `chequesno` = ?, `date` = ?, `labels` = ? WHERE `expenses`.`expid` = ?");
        $append = array($par['amount'], $par['check'], $par['date'], $par['reason'], $par['ID']);
        if ($query->execute($append)) {
             if ($_SESSION['online']->getmemid() > 1) {
                    $mem= $this->return_spend($par['ID']);
                    $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Modification Depenses', NOW(), CONCAT('Depense ==> ',?))");
                    $query1->execute(array($_SESSION['online']->getmemid(),$mem->getamount().' > '.$mem->getdate().' > '.$mem->getlabels()));
                }
            return true;
        } else {
            return 'problem with the query';
        }
    }

    public function delete($id) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("DELETE FROM `expenses` WHERE `expenses`.`expid` = ? ");
        if ($_SESSION['online']->getmemid() > 1) {
                    $mem= $this->return_spend($id);
                    $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Supréssion Depenses', NOW(), CONCAT('Depense ==> ',?))");
                    $query1->execute(array($_SESSION['online']->getmemid(),$mem->getamount().' > '.$mem->getdate().' > '.$mem->getlabels()));
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
            $query = $this->db->prepare('SELECT expid,amount,chequesno,date,labels,'
                    . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                    . ' FROM expenses INNER JOIN cycles ON expenses.cycid=cycles.cycid WHERE labels LIKE CONCAT ("%",?,"%") AND cycles.status="Active"');
            $query->execute(array($par['name']));
        } elseif ($par['month'] != "") {
            $query = $this->db->prepare('SELECT expid,amount,chequesno,date,labels,'
                    . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                    . ' FROM expenses INNER JOIN cycles ON expenses.cycid=cycles.cycid WHERE labels LIKE CONCAT ("%",?,"%") AND CONCAT(MONTH(date),YEAR(date)) = CONCAT(MONTH(?),YEAR(?)) AND cycles.status="Active"');
            $query->execute(array($par['name'], $par['month'],$par['month']));
        }
        $list = array();
        while ($data = $query->fetch()) {
            $list[] = new expense($data);
        }
        return $list;
    }

    public function pagination($pagination) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare('SELECT expid,amount,chequesno,date,labels,'
                . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                . ' FROM expenses INNER JOIN cycles ON expenses.cycid=cycles.cycid WHERE cycles.status="Active" LIMIT ?,10');
        $query->execute(array($pagination));
        $list = array();

        while ($data = $query->fetch()) {
            $list[] = new expense($data);
        }
        $query1 = $this->db->query('SELECT COUNT(*) AS expcount FROM expenses INNER JOIN cycles ON expenses.cycid = cycles.cycid WHERE Cycles.status="Active"');
        $data = $query1->fetch();
        $count = $data['expcount'];
        $final = array(
            'list' => $list,
            'count' => $count
        );
        return $final;
    }

    public function sum_exp() {
        $this->db = parent::getconnect();
        $query = $this->db->query("SELECT SUM(amount) as expense FROM expenses INNER JOIN cycles ON expenses.cycid = cycles.cycid WHERE cycles.status= 'Active'");
        $data = $query->fetch();
        return $data['expense'];
    }

    public function exp_month() {
        $this->db = parent::getconnect();
        $month = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        $list = array();

        for ($i = 0; $i < count($month); $i++) {
            $query = $this->db->prepare("SELECT SUM(amount) AS jan from expenses where MONTHNAME(date) = ? AND YEAR(date) = YEAR(NOW())");
            $query->execute(array($month[$i]));
            $data = $query->fetch();
            $list += array($month[$i] => $data['jan']);
        }

        return $list;
    }
    
    public function exppermonth($month) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("SELECT SUM(amount) as expense FROM expenses INNER JOIN cycles ON expenses.cycid = cycles.cycid WHERE CONCAT(MONTH(date),YEAR(date)) = CONCAT(MONTH(?),YEAR(?))");
        $query->execute(array($month,$month));
        $data = $query->fetch();
        return $data['expense'];
    }

}
