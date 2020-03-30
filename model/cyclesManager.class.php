<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cyclesManager
 *
 * @author ZE-KAIZER
 */
require 'Cycles.class.php';

class cyclesManager extends Manager {

    private $db;

    function __construct() {
        
    }

    public function all_cycles() {
        $this->db = parent::getconnect();
        $query = $this->db->query('SELECT member.fullname as president, '
                . 'cycles.begindate,'
                . 'cycles.enddate, '
                . 'cycles.status, '
                . 'cycles.cycid, '
                . 'cycles.memid,'
                . 'cycles.intialfond '
                . 'FROM cycles'
                . ' INNER JOIN member ON cycles.memid = member.memid ORDER BY status LIMIT 0, 10');
        $list = array();
        $list2 = array();
        while ($data = $query->fetch()) {
            $list[] = new Cycles($data);
        }
        $query1 = $this->db->query('SELECT count(*) as cycount FROM cycles INNER JOIN member ON cycles.memid = member.memid ');
        $data = $query1->fetch();
        $count = $data['cycount'];


        $final = array(
            'list' => $list,
            'count' => $count
        );
        return $final;
    }

    public function cycle_pagination($pagination) {
        $this->db = parent::getconnect();
        $list = array();

        $query = $this->db->prepare('SELECT member.fullname as president, '
                . 'cycles.begindate,'
                . 'cycles.enddate, '
                . 'cycles.status, '
                . 'cycles.cycid, '
                . 'cycles.memid,'
                . 'cycles.intialfond '
                . 'FROM cycles'
                . ' INNER JOIN member ON cycles.memid = member.memid ORDER BY status ASC LIMIT ?, 10');
        $query->execute(array($pagination));

        while ($data = $query->fetch()) {
            $list[] = new Cycles($data);
        }

        $query1 = $this->db->query('SELECT COUNT(*) as cycount FROM cycles;');
        $data = $query1->fetch();
        $count = $data['cycount'];
        $final = array(
            'list' => $list,
            'count' => $count
        );
        return $final;
    }

    public function max_id() {
        $this->db = parent::getconnect();
        $query = $this->db->query('select max(cycid) as maximum from cycles');
        $result = $query->fetch();
        $answer = $result['maximum'];
        return $answer;
    }

    public function insert($params) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("INSERT INTO `cycles` (`cycid`, `memid`, `begindate`, `enddate`, `status`, `intialfond`)"
                . "VALUES (NULL, ?, ?, ?, ?, ?)");
        $append = array($params['president'], $params['begindate'], $params['enddate'], $params['status'], $params['inifond']);
        if ($query->execute($append)) {
            $id = $this->max_id();
            if ($_SESSION['online']->getmemid() > 1) {
                $mem = $this->return_cyc($id);
                $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Création cycle', NOW(), CONCAT('cycle ==> ',?))");
                $query1->execute(array($_SESSION['online']->getmemid(), $mem->getpresident() . ' > ' . $mem->getbegindate() . ' > ' . $mem->getenddate() . ' > ' . $mem->getintialfond() . ' > ' . $mem->getstatus()));
            }
            return "$id";
        } else {
            return 'problem with the query';
        }
    }

    public function is_active() {
        $this->db = parent::getconnect();
        $query1 = $this->db->query('SELECT COUNT(*) as cycount FROM cycles where status="Active"');
        $data = $query1->fetch();
        $count = $data['cycount'];
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function return_cyc($id) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare('SELECT member.fullname as president, '
                . 'cycles.begindate,'
                . 'cycles.enddate, '
                . 'cycles.status, '
                . 'cycles.cycid, '
                . 'cycles.memid,'
                . 'cycles.intialfond '
                . 'FROM cycles'
                . ' INNER JOIN member ON cycles.memid = member.memid WHERE cycles.cycid=?');
        if ($query->execute(array($id))) {
            $data = $query->fetch();
            $cycle = new Cycles($data);
            return $cycle;
        } else {
            return null;
        }
    }

    public function update($params) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("UPDATE `cycles` SET `memid` = ?, `begindate` = ?, `enddate` = ?, `status` = ?, `intialfond` = ? WHERE `cycles`.`cycid` = ?");
        $append = array($params['president'], $params['begindate'], $params['enddate'], $params['status'], $params['inifond'], $params['ID']);
        if ($query->execute($append)) {
            if ($_SESSION['online']->getmemid() > 1) {
                $mem = $this->return_cyc($params['ID']);
                $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Modification cycle', NOW(), CONCAT('cycle ==> ',?))");
                $query1->execute(array($_SESSION['online']->getmemid(), $mem->getpresident() . ' > ' . $mem->getbegindate() . ' > ' . $mem->getenddate() . ' > ' . $mem->getintialfond() . ' > ' . $mem->getstatus()));
            }
            return true;
        } else {
            return 'problem with the query';
        }
    }

    public function delete($id) {
        $this->db = parent::getconnect();
        $req = $this->db->prepare('DELETE FROM `cycles` WHERE `cycles`.`cycid` = ?');
        if ($_SESSION['online']->getmemid() > 1) {
            $mem = $this->return_cyc($id);
            $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Supréssion cycle', NOW(), CONCAT('cycle ==> ',?))");
            $query1->execute(array($_SESSION['online']->getmemid(), $mem->getpresident() . ' > ' . $mem->getbegindate() . ' > ' . $mem->getenddate() . ' > ' . $mem->getintialfond() . ' > ' . $mem->getstatus()));
        }
        return $req->execute(array($id));
    }

    public function search_cycle($par) {
        $this->db = parent::getconnect();
        if ($par['year'] == "") {
            $query = $this->db->prepare('SELECT member.fullname as president, '
                    . 'cycles.begindate,'
                    . 'cycles.enddate, '
                    . 'cycles.status, '
                    . 'cycles.cycid, '
                    . 'cycles.memid,'
                    . 'cycles.intialfond '
                    . 'FROM cycles'
                    . ' INNER JOIN member ON cycles.memid = member.memid WHERE fullname LIKE CONCAT ("%",?,"%")');
            $query->execute(array($par['president']));
        } elseif (!$par['year'] == "") {
            $query = $this->db->prepare('SELECT member.fullname as president, '
                    . 'cycles.begindate,'
                    . 'cycles.enddate, '
                    . 'cycles.status, '
                    . 'cycles.cycid, '
                    . 'cycles.memid,'
                    . 'cycles.intialfond '
                    . 'FROM cycles'
                    . ' INNER JOIN member ON cycles.memid = member.memid WHERE fullname LIKE CONCAT ("%",?,"%") AND begindate BETWEEN ? AND ? ');
            $begin = $par['year'] . '-01-01';
            $end = $par['year'] . '-12-31';
            $query->execute(array($par['president'], $begin, $end));
        }
        $list = array();
        while ($data = $query->fetch()) {
            $list[] = new Cycles($data);
        }
        return $list;
    }

    public function all() {
        $this->db = parent::getconnect();
        $query = $this->db->query("select status, cycid, CONCAT(DAY(begindate),'-',MONTHNAME(begindate),'-',YEAR(begindate)) AS begindate, CONCAT( DAY(enddate),'-',MONTHNAME(enddate),'-',YEAR(enddate)) AS enddate from cycles ");
        $list = array();
        while ($data = $query->fetch()) {
            $list[] = new Cycles($data);
        }
        return $list;
    }

    public function return_active() {
        $this->db = parent::getconnect();
        $query = $this->db->query("select cycid, CONCAT(DAY(begindate),'-',MONTHNAME(begindate),'-',YEAR(begindate)) AS begindate, CONCAT( DAY(enddate),'-',MONTHNAME(enddate),'-',YEAR(enddate)) AS enddate from cycles where status='Active';");
        $data = $query->fetch();
        if (is_bool($data)) {
            return false;
        } else {
            $cycle = new Cycles($data);
            return $cycle;
        }
    }

    public function ending() {
        $this->db = parent::getconnect();
        $query = $this->db->query("SELECT DATEDIFF(enddate,NOW()) as nb_jours FROM cycles WHERE status = 'Active'");
        $data = $query->fetch();
        return $data['nb_jours'];
    }
    
    public function lenght() {
        $this->db = parent::getconnect();
        $query = $this->db->query("SELECT DATEDIFF(enddate,begindate) as nb_jours FROM cycles WHERE status = 'Active'");
        $data = $query->fetch();
        return $data['nb_jours'];
    }
    
    public function return_active2() {
        $this->db = parent::getconnect();
        $query = $this->db->query("select * from cycles where status='Active';");
        $data = $query->fetch();
        if (is_bool($data)) {
            return false;
        } else {
            $cycle = new Cycles($data);
            return $cycle;
        }
    }

}
