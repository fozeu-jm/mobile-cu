<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of loanManager
 *
 * @author ZE-KAIZER
 */
require 'loan.class.php';

class loanManager extends Manager {

    private $db;

    function __construct() {
        
    }

    public function all_loans() {
        $this->db = parent::getconnect();
        $query = $this->db->query('SELECT member.fullname, loanid,amount,date,chequesno,rate,'
                . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                . ' FROM loan INNER JOIN member ON loan.memid = member.memid INNER JOIN cycles ON loan.cycid=cycles.cycid WHERE Cycles.status="Active" LIMIT 0,10');
        $list = array();

        while ($data = $query->fetch()) {
            $list[] = new loan($data);
        }
        $query1 = $this->db->query('SELECT COUNT(*) AS loancount FROM loan INNER JOIN cycles ON loan.cycid = cycles.cycid WHERE Cycles.status="Active"');
        $data = $query1->fetch();
        $count = $data['loancount'];
        $final = array(
            'list' => $list,
            'count' => $count
        );
        return $final;
    }

    public function loan_pagination($pagination) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare('SELECT member.fullname, loanid,amount,date,chequesno,rate,'
                . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                . ' FROM loan INNER JOIN member ON loan.memid = member.memid INNER JOIN cycles ON loan.cycid=cycles.cycid WHERE Cycles.status="Active" LIMIT ?,10');
        $query->execute(array($pagination));
        $list = array();

        while ($data = $query->fetch()) {
            $list[] = new loan($data);
        }
        $query1 = $this->db->query('SELECT COUNT(*) AS loancount FROM loan INNER JOIN cycles ON loan.cycid = cycles.cycid WHERE Cycles.status="Active"');
        $data = $query1->fetch();
        $count = $data['loancount'];
        $final = array(
            'list' => $list,
            'count' => $count
        );
        return $final;
    }

    public function insert($apr) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("INSERT INTO `loan` (`loanid`, `cycid`, `memid`, `amount`, `date`,  `rate`,  `chequesno`) VALUES (NULL, ?, ?, ?, ?, ?, ?)");
        $append = array($apr['active'], $apr['member'], $apr['amount'], $apr['date'], $apr['rate'], $apr['check']);

        if ($query->execute($append)) {
            $id = $this->max_id();
            if ($_SESSION['online']->getmemid() > 1) {
                $mem = $this->return_loan($id);
                $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Ajout Prêt', NOW(), CONCAT('Prêt ==> ',?))");
                $query1->execute(array($_SESSION['online']->getmemid(), $mem->getfullname() . ' > ' . $mem->getamount() . ' > ' . $mem->getrate() . ' > ' . $mem->getdate() . ' > ' . $mem->getchequesno()));
            }
            return "$id";
        } else {
            return "problem with the query";
        }
    }

    public function max_id() {
        $this->db = parent::getconnect();
        $query = $this->db->query('SELECT MAX(loanid) AS maximum FROM loan');
        $data = $query->fetch();
        return $data['maximum'];
    }

    public function return_loan($id) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare('SELECT member.fullname, loanid,amount,date,chequesno,rate,'
                . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                . ' FROM loan INNER JOIN member ON loan.memid = member.memid INNER JOIN cycles ON loan.cycid=cycles.cycid where loan.loanid=?');
        if ($query->execute(array($id))) {
            $data = $query->fetch();
            $cycle = new loan($data);
            return $cycle;
        } else {
            return "problem with the query";
        }
    }

    public function edit($apr) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("UPDATE `loan` SET `memid` = ?, `amount` = ?, `date` = ?, `rate` = ?, `chequesno` = ? WHERE `loan`.`loanid` = ?");
        $append = array($apr['member'], $apr['amount'], $apr['date'], $apr['rate'], $apr['check'], $apr['ID']);
        if ($query->execute($append)) {
            if ($_SESSION['online']->getmemid() > 1) {
                $mem = $this->return_loan($apr['ID']);
                $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Modification Prêt', NOW(), CONCAT('Prêt ==> ',?))");
                $query1->execute(array($_SESSION['online']->getmemid(), $mem->getfullname() . ' > ' . $mem->getamount() . ' > ' . $mem->getrate() . ' > ' . $mem->getdate() . ' > ' . $mem->getchequesno()));
            }
            return true;
        } else {
            return 'problem with the query';
        }
    }

    public function delete($id) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("DELETE FROM `loan` WHERE `loan`.`loanid` = ? ");
        if ($_SESSION['online']->getmemid() > 1) {
            $mem = $this->return_loan($id);
            $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Supression Prêt', NOW(), CONCAT('Prêt ==> ',?))");
            $query1->execute(array($_SESSION['online']->getmemid(), $mem->getfullname() . ' > ' . $mem->getamount() . ' > ' . $mem->getrate() . ' > ' . $mem->getdate()));
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
            $query = $this->db->prepare('SELECT member.fullname, loanid,amount,date,chequesno,rate,'
                    . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                    . ' FROM loan INNER JOIN member ON loan.memid = member.memid INNER JOIN cycles ON loan.cycid=cycles.cycid WHERE fullname LIKE CONCAT ("%",?,"%") AND Cycles.status="Active"');
            $query->execute(array($par['name']));
        } elseif ($par['month'] != "") {
            $query = $this->db->prepare('SELECT member.fullname, loanid,amount,date,chequesno,rate,'
                    . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                    . ' FROM loan INNER JOIN member ON loan.memid = member.memid INNER JOIN cycles ON loan.cycid=cycles.cycid WHERE fullname LIKE CONCAT ("%",?,"%") AND CONCAT(MONTH(date),YEAR(date)) = CONCAT(MONTH(?),YEAR(?)) AND Cycles.status="Active" ORDER BY fullname ASC');
            $query->execute(array($par['name'], $par['month'], $par['month']));
        }
        $list = array();
        while ($data = $query->fetch()) {
            $list[] = new loan($data);
        }
        return $list;
    }

    public function loan_int() {
        $this->db = parent::getconnect();
        $query = $this->db->query("SELECT SUM(refundamt-amount) AS interest FROM loan INNER JOIN cycles ON loan.cycid = cycles.cycid WHERE refundamt>100 AND cycles.status= 'Active'");
        $data = $query->fetch();
        return $data['interest'];
    }

    public function non_loan() {
        $this->db = parent::getconnect();
        $query = $this->db->query("SELECT SUM(amount) AS loans FROM loan INNER JOIN cycles ON loan.cycid = cycles.cycid WHERE (refundamt-amount) < interestamt AND cycles.status= 'Active'");
        $data = $query->fetch();
        return $data['loans'];
    }

    public function report() {
        $this->db = parent::getconnect();
        $query = $this->db->query('SELECT member.fullname, loanid,amount,date,chequesno,rate,'
                . 'CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                . ' FROM loan INNER JOIN member ON loan.memid = member.memid INNER JOIN cycles ON loan.cycid=cycles.cycid WHERE Cycles.status="Active" ORDER BY date DESC');
        $list = array();
        while ($data = $query->fetch()) {
            $list [] = new loan($data);
        }
        return $list;
    }

    public function find_all_loans() {
        $this->db = parent::getconnect();
        $query = $this->db->query('SELECT member.fullname, loanid,sum(amount) as amount ,date,chequesno,rate,'
                . ' CONCAT(DAY(begindate),"-",MONTHNAME(begindate),"-",YEAR(begindate)," ==> ",DAY(enddate),"-",MONTHNAME(enddate),"-",YEAR(enddate)) AS cycle'
                . ' FROM loan INNER JOIN member ON loan.memid = member.memid INNER JOIN cycles ON loan.cycid=cycles.cycid WHERE Cycles.status="Active" GROUP BY fullname order by fullname ASC;');
        $list = array();

        while ($data = $query->fetch()) {
            $list[] = new loan($data);
        }
        return $list;
    }

    public function total_loans() {
        $this->db = parent::getconnect();
        $query = $this->db->query("SELECT SUM(amount) as amount FROM loan INNER JOIN cycles ON loan.cycid = cycles.cycid WHERE cycles.status= 'Active'");
        $data = $query->fetch();
        return $data['amount'];
    }
    
    public function loans_month($month) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("SELECT SUM(amount) as amount FROM loan INNER JOIN cycles ON loan.cycid = cycles.cycid WHERE CONCAT(MONTH(date),YEAR(date)) = CONCAT(MONTH(?),YEAR(?))");
        $query->execute(array($month,$month));
        $data = $query->fetch();
        return $data['amount'];
    }

}
