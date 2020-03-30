<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of salesManager
 *
 * @author ZE-KAIZER
 */
require 'sales.class.php';

class salesManager extends Manager {

    private $db;

    function __construct() {
        
    }

    public function all_sales() {
        $this->db = parent::getconnect();
        $query = $this->db->query('SELECT member.fullname, tsid,amount,sellingprice,chequesno,type,date,'
                . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                . ' FROM tontinesales INNER JOIN member ON tontinesales.memid = member.memid INNER JOIN cycles ON tontinesales.cycid=cycles.cycid WHERE cycles.status="Active" ORDER BY date DESC LIMIT 0,10 ');
        $list = array();

        while ($data = $query->fetch()) {
            $list[] = new sales($data);
        }
        $query1 = $this->db->query('SELECT COUNT(*) AS salescount FROM tontinesales INNER JOIN cycles ON tontinesales.cycid = cycles.cycid WHERE Cycles.status="Active"');
        $data = $query1->fetch();
        $count = $data['salescount'];
        $final = array(
            'list' => $list,
            'count' => $count
        );
        return $final;
    }

    public function insert($par) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("INSERT INTO `tontinesales` (`tsid`, `cycid`, `memid`, `sellingprice`, `amount`, `chequesno`, `type`, `date`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)");
        $append = array($par['active'], $par['member'], $par['sell'], $par['amount'], $par['check'], $par['tontine'], $par['date']);
        if ($query->execute($append)) {
            $id = $this->max_id();
            if ($_SESSION['online']->getmemid() > 1) {
                $mem = $this->return_sales($id);
                $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Ajout Ventes', NOW(), CONCAT('Ventes ==> ',?))");
                $query1->execute(array($_SESSION['online']->getmemid(), $mem->getfullname() . ' > ' . $mem->getamount() . ' > ' . $mem->getsellingprice() . ' > ' . $mem->getdate()));
            }
            return "$id";
        } else {
            return "problem with the query";
        }
    }

    public function max_id() {
        $this->db = parent::getconnect();
        $query = $this->db->query('SELECT MAX(tsid) AS maximum FROM tontinesales');
        $data = $query->fetch();
        return $data['maximum'];
    }

    public function return_sales($id) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare('SELECT member.fullname, tsid,amount,sellingprice,chequesno,type,date,'
                . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                . ' FROM tontinesales INNER JOIN member ON tontinesales.memid = member.memid INNER JOIN cycles ON tontinesales.cycid=cycles.cycid WHERE tsid = ? AND cycles.status="Active"');
        if ($query->execute(array($id))) {
            $data = $query->fetch();
            $cycle = new sales($data);
            return $cycle;
        } else {
            return "problem with the query";
        }
    }

    public function edit($par) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("UPDATE `tontinesales` SET `memid` = ?, `sellingprice` = ?, `amount` = ?, `chequesno` = ?, `type` = ?, `date` = ? WHERE `tontinesales`.`tsid` = ?");
        $append = array($par['member'], $par['sell'], $par['amount'], $par['check'], $par['tontine'], $par['date'], $par['ID']);
        if ($query->execute($append)) {
            if ($_SESSION['online']->getmemid() > 1) {
                $mem = $this->return_sales($par['ID']);
                $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Modification Ventes', NOW(), CONCAT('Ventes ==> ',?))");
                $query1->execute(array($_SESSION['online']->getmemid(), $mem->getfullname() . ' > ' . $mem->getamount() . ' > ' . $mem->getsellingprice() . ' > ' . $mem->getdate()));
            }
            return true;
        } else {
            return 'problem with the query';
        }
    }

    public function delete($id) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("DELETE FROM `tontinesales` WHERE `tontinesales`.`tsid` = ? ");
        if ($_SESSION['online']->getmemid() > 1) {
            $mem = $this->return_sales($id);
            $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Supression Ventes', NOW(), CONCAT('Ventes ==> ',?))");
            $query1->execute(array($_SESSION['online']->getmemid(), $mem->getfullname() . ' > ' . $mem->getamount() . ' > ' . $mem->getsellingprice() . ' > ' . $mem->getdate()));
        }
        if ($query->execute(array($id))) {
            return true;
        } else {
            return 'problem with the query';
        }
    }

    public function search($par) {
        $this->db = parent::getconnect();
        if ($par['month'] == "" && $par['tontine'] == "") {
            $query = $this->db->prepare('SELECT member.fullname, tsid,amount,sellingprice,chequesno,type,date,'
                    . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                    . ' FROM tontinesales INNER JOIN member ON tontinesales.memid = member.memid INNER JOIN cycles ON tontinesales.cycid=cycles.cycid WHERE fullname LIKE CONCAT ("%",?,"%") AND cycles.status="Active"');
            $query->execute(array($par['name']));
        } elseif ($par['month'] != "" && $par['tontine'] == "") {
            $query = $this->db->prepare('SELECT member.fullname, tsid,amount,sellingprice,chequesno,type,date,'
                    . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                    . ' FROM tontinesales INNER JOIN member ON tontinesales.memid = member.memid INNER JOIN cycles ON tontinesales.cycid=cycles.cycid WHERE fullname LIKE CONCAT ("%",?,"%") AND CONCAT(MONTH(date),YEAR(date)) = CONCAT(MONTH(?),YEAR(?)) AND cycles.status="Active"');
            $query->execute(array($par['name'], $par['month'], $par['month']));
        } elseif ($par['month'] == "" && $par['tontine'] != "") {
            $query = $this->db->prepare('SELECT member.fullname, tsid,amount,sellingprice,chequesno,type,date,'
                    . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                    . ' FROM tontinesales INNER JOIN member ON tontinesales.memid = member.memid INNER JOIN cycles ON tontinesales.cycid=cycles.cycid WHERE fullname LIKE CONCAT ("%",?,"%") AND tontinesales.type = ? AND cycles.status="Active"');
            $query->execute(array($par['name'], $par['tontine']));
        } elseif (!$par['month'] == "" && !$par['tontine'] == "") {
            $query = $this->db->prepare('SELECT member.fullname, tsid,amount,sellingprice,chequesno,type,date,'
                    . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                    . ' FROM tontinesales INNER JOIN member ON tontinesales.memid = member.memid INNER JOIN cycles ON tontinesales.cycid=cycles.cycid WHERE fullname LIKE CONCAT ("%",?,"%") AND tontinesales.type = ? AND CONCAT(MONTH(date),YEAR(date)) = CONCAT(MONTH(?),YEAR(?)) AND cycles.status="Active"');
            $query->execute(array($par['name'], $par['tontine'], $par['month'], $par['month']));
        }

        $list = array();
        while ($data = $query->fetch()) {
            $list[] = new sales($data);
        }
        return $list;
    }

    public function sales_pagination($pagination) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare('SELECT member.fullname, tsid,amount,sellingprice,chequesno,type,date,'
                . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                . ' FROM tontinesales INNER JOIN member ON tontinesales.memid = member.memid INNER JOIN cycles ON tontinesales.cycid=cycles.cycid WHERE cycles.status="Active" LIMIT ?,10');
        $query->execute(array($pagination));
        $list = array();

        while ($data = $query->fetch()) {
            $list[] = new sales($data);
        }
        $query1 = $this->db->query('SELECT COUNT(*) AS salescount FROM tontinesales INNER JOIN cycles ON tontinesales.cycid = cycles.cycid WHERE Cycles.status="Active"');
        $data = $query1->fetch();
        $count = $data['salescount'];
        $final = array(
            'list' => $list,
            'count' => $count
        );
        return $final;
    }

    public function Ordinarysum_sell() { //ordinary interest
        $this->db = parent::getconnect();
        $query = $this->db->query("SELECT SUM(sellingprice) as sell FROM tontinesales INNER JOIN cycles ON tontinesales.cycid = cycles.cycid where cycles.status= 'Active' AND tontinesales.type='Ordinaire'");
        $data = $query->fetch();
        return $data['sell'];
    }

    public function sum_sales() { // don't use this
        $this->db = parent::getconnect();
        $query = $this->db->query("SELECT sum(amount-sellingprice) as sales FROM tontinesales INNER JOIN cycles ON tontinesales.cycid = cycles.cycid WHERE cycles.status= 'Active'");
        $data = $query->fetch();
        return $data['sales'];
    }

    public function specialsum_sell() { // special interest
        $this->db = parent::getconnect();
        $query = $this->db->query("SELECT SUM(sellingprice) as sell FROM tontinesales INNER JOIN cycles ON tontinesales.cycid = cycles.cycid where cycles.status= 'Active' AND tontinesales.type='Speciale'");
        $data = $query->fetch();
        return $data['sell'];
    }

    public function salesPerMonth() {
        $this->db = parent::getconnect();
        $month = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        $list = array();

        for ($i = 0; $i < count($month); $i++) {
            $query = $this->db->prepare("SELECT SUM(sellingprice) AS jan from tontinesales where MONTHNAME(date) = ? AND YEAR(date) = YEAR(NOW()) AND type ='Ordinaire'");
            $query->execute(array($month[$i]));
            $data = $query->fetch();
            $list += array($month[$i] => $data['jan']);
        }

        return $list;
    }

    public function report($par) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare('SELECT member.fullname, tsid,sum(amount) as amount,sum(sellingprice) as sellingprice,chequesno,type,date,ordinarysharesno as tord,specialsharesno as ts,'
                . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                . ' FROM tontinesales INNER JOIN member ON tontinesales.memid = member.memid INNER JOIN cycles ON tontinesales.cycid=cycles.cycid WHERE cycles.status="Active" AND type = ? '
                . ' GROUP BY fullname ORDER BY date DESC ');
        $query->execute(array($par));
        $list = array();

        while ($data = $query->fetch()) {
            $list[] = new sales($data);
        }

        return $list;
    }

    public function salesmonth($month) { // special exit month
        $this->db = parent::getconnect();
        $query = $this->db->prepare("SELECT sum(amount) as amount FROM tontinesales WHERE CONCAT(MONTH(date),YEAR(date)) = CONCAT(MONTH(?),YEAR(?)) AND type = 'Speciale' ");
        $query->execute(array($month, $month));
        $data = $query->fetch();
        return $data['amount'];
    }

    public function ts_interest($month) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("SELECT sum(sellingprice) as amount FROM tontinesales WHERE CONCAT(MONTH(date),YEAR(date)) = CONCAT(MONTH(?),YEAR(?)) AND type = 'Speciale' ");
        $query->execute(array($month, $month));
        $data = $query->fetch();
        return $data['amount'];
    }

    public function monthordinaire($month) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("SELECT sum(amount) as amount FROM tontinesales WHERE CONCAT(MONTH(date),YEAR(date)) = CONCAT(MONTH(?),YEAR(?)) AND type = 'Ordinaire' ");
        $query->execute(array($month, $month));
        $data = $query->fetch();
        return $data['amount'];
    }

    public function to_interest($month) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("SELECT sum(sellingprice) as amount FROM tontinesales WHERE CONCAT(MONTH(date),YEAR(date)) = CONCAT(MONTH(?),YEAR(?)) AND type = 'Ordinaire' ");
        $query->execute(array($month, $month));
        $data = $query->fetch();
        return $data['amount'];
    }

    public function ordinary_exit() {
        $this->db = parent::getconnect();
        $query = $this->db->query("SELECT sum(amount) as amount FROM tontinesales INNER JOIN cycles ON tontinesales.cycid = cycles.cycid WHERE cycles.status='Active' AND type = 'Ordinaire' ");
        $data = $query->fetch();
        return $data['amount'];
    }

    public function special_exit() {
        $this->db = parent::getconnect();
        $query = $this->db->query("SELECT sum(amount) as amount FROM tontinesales INNER JOIN cycles ON tontinesales.cycid = cycles.cycid WHERE cycles.status='Active' AND type = 'Speciale' ");
        $data = $query->fetch();
        return $data['amount'];
    }

    public function ordinary_sale_interest() {
        $this->db = parent::getconnect();
        $query = $this->db->query("SELECT sum(sellingprice) as amount FROM tontinesales INNER JOIN cycles ON tontinesales.cycid = cycles.cycid WHERE cycles.status='Active' AND type = 'Ordinaire' ");
        $data = $query->fetch();
        return $data['amount'];
    }

    public function special_sale_interest() {
        $this->db = parent::getconnect();
        $query = $this->db->query("SELECT sum(sellingprice) as amount FROM tontinesales INNER JOIN cycles ON tontinesales.cycid = cycles.cycid WHERE cycles.status='Active' AND type = 'Speciale' ");
        $data = $query->fetch();
        return $data['amount'];
    }

}
