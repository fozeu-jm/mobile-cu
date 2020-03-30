<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of memberManager
 *
 * @author ZE-KAIZER
 */
require 'Manager.class.php';
require 'Member.class.php';

class memberManager extends Manager {

    private $db;

    function __construct() {
        
    }

    public function all_members() {
        $this->db = parent::getconnect();
        $list = array();
        $query = $this->db->query('SELECT *  FROM member WHERE memid > 1 ORDER BY fullname ASC LIMIT 0, 10');

        while ($data = $query->fetch()) {
            $list[] = new Member($data);
        }
        $query1 = $this->db->query('SELECT COUNT(*) as memcount FROM member where memid > 1');
        $data = $query1->fetch();
        $result = $data['memcount'];
        $final = array(
            'list' => $list,
            'count' => $result
        );
        return $final;
    }

    public function member_pagination($pagination) {
        $this->db = parent::getconnect();
        $list = array();
        $query = $this->db->prepare('SELECT *  FROM member WHERE memid > 1 ORDER BY fullname ASC LIMIT ?, 10');
        $query->execute(array($pagination));

        while ($data = $query->fetch()) {
            $list[] = new Member($data);
        }

        $query1 = $this->db->query('SELECT COUNT(*) as memcount FROM member where memid > 1');
        $data = $query1->fetch();
        $result = $data['memcount'];
        $final = array(
            'list' => $list,
            'count' => $result
        );
        return $final;
    }

    public function count_mem() {
        $this->db = parent::getconnect();
        $query = $this->db->query('SELECT COUNT(*) as memcount FROM member where memid > 1');
        $data = $query->fetch();
        $result = $data['memcount'];
        return $result;
    }

    public function max_id() {
        $this->db = parent::getconnect();
        $query = $this->db->query('select max(memid) as maximum from member');
        $result = $query->fetch();
        $answer = $result['maximum'];
        return $answer;
    }

    public function insert($params) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("INSERT INTO `member` (`memid`, `fullname`, `familysituation`, `telno`, `adresse`, `role`, `ordinarysharesno`, `specialsharesno`, `username`, `password`) "
                . "VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $hache = sha1($params['pass']);
        $append = array($params['fullname'], $params['family'], $params['tel'], $params['adresse'], $params['role'], $params['to'], $params['ts'], $params['username'], $hache);
        if ($query->execute($append)) {
            $id = $this->max_id();
            if ($_SESSION['online']->getmemid() > 1) {
                    $new= $this->return_std($id);
                    $query = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Insertion Membre', NOW(), CONCAT('Nouveau Membre ==> ',?))");
                    $query->execute(array($_SESSION['online']->getmemid(),$new->getfullname()));
                }
            return "$id";
        } else {
            return 'problem with the query';
        }
    }

    public function return_std($id) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare('SELECT * FROM member where memid = ?');
        if ($query->execute(array($id))) {
            $data = $query->fetch();
            $member = new Member($data);
            return $member;
        } else {
            return null;
        }
    }

    public function edit($params) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare("UPDATE `member` SET `fullname` = ?, `familysituation` = ?, `telno` = ?, `adresse` = ?, "
                . "`role` = ?, `ordinarysharesno` = ?,`specialsharesno` = ?, `username`= ?, `password` = ? "
                . "WHERE `member`.`memid` = ?");
        $hache = sha1($params['pass']);
        $append = array($params['fullname'], $params['family'], $params['tel'], $params['adresse'], $params['role'], $params['to'], $params['ts'], $params['username'], $hache, $params['ID']);
        if ($_SESSION['online']->getmemid() > 1) {
                    $mem= $this->return_std($params['ID']);
                    $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Modification membre', NOW(), CONCAT('Modification ==> ',?))");
                    $query1->execute(array($_SESSION['online']->getmemid(),$mem->getfullname()));
                }
        return $query->execute($append);
    }

    public function delete($id) {
        $this->db = parent::getconnect();
        $req = $this->db->prepare('DELETE FROM member WHERE memid=?');
        if ($_SESSION['online']->getmemid() > 1) {
                    $mem= $this->return_std($id);
                    $query1 = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Suppression membre', NOW(), CONCAT('Supprimé ==> ',?))");
                    $query1->execute(array($_SESSION['online']->getmemid(),$mem->getfullname()));
                }
        return $req->execute(array($id));
    }

    public function searchName($par) {
        $this->db = parent::getconnect();
        if ($par['to'] == "" && $par['ts'] == "") {
            $query = $this->db->prepare('SELECT * FROM member WHERE fullname LIKE CONCAT ("%",?,"%") AND memid > 1 ORDER BY fullname ASC');
            $query->execute(array($par['name']));
        } elseif (!$par['to'] == "" && $par['ts'] == "") {
            $query = $this->db->prepare('SELECT * FROM member WHERE fullname LIKE CONCAT ("%",?,"%") AND ordinarysharesno > ? ORDER BY fullname ASC');
            $query->execute(array($par['name'], $par['to']));
        } elseif ($par['to'] == "" && !$par['ts'] == "") {
            $query = $this->db->prepare('SELECT * FROM member WHERE fullname LIKE CONCAT ("%",?,"%") AND specialsharesno > ? ORDER BY fullname ASC');
            $query->execute(array($par['name'], $par['ts']));
        } elseif (!$par['to'] == "" && !$par['ts'] == "") {
            $query = $this->db->prepare('SELECT * FROM member WHERE fullname LIKE CONCAT ("%",?,"%") AND ordinarysharesno > ? AND specialsharesno > ? ORDER BY fullname ASC');
            $query->execute(array($par['name'], $par['to'], $par['ts']));
        } else if ($par['to'] == "0" && $par['ts'] == "") {
            $query = $this->db->prepare('SELECT * FROM member WHERE fullname LIKE CONCAT ("%",?,"%") AND ordinarysharesno > 0 ORDER BY fullname ASC');
            $query->execute(array($par['name']));
        } elseif ($par['to'] == "" && $par['ts'] == "0") {
            $query = $this->db->prepare('SELECT * FROM member WHERE fullname LIKE CONCAT ("%",?,"%") AND specialsharesno > 0 ORDER BY fullname ASC');
            $query->execute(array($par['name']));
        } elseif ($par['to'] == "0" && $par['ts'] == "0") {
            $query = $this->db->prepare('SELECT * FROM member WHERE fullname LIKE CONCAT ("%",?,"%") AND ordinarysharesno > ? AND specialsharesno > ? ORDER BY fullname ASC');
            $query->execute(array($par['name'], 0, 0));
        }

        $list = array();
        while ($data = $query->fetch()) {
            $list[] = new Member($data);
        }
        return $list;
    }

    public function all() {
        $this->db = parent::getconnect();
        $query = $this->db->query('SELECT * FROM member WHERE memid > 1 ORDER BY fullname ASC');
        $list = array();
        while ($data = $query->fetch()) {
            $list[] = new Member($data);
        }
        return $list;
    }

    public function ordinaryshare_no() {
        $this->db = parent::getconnect();
        $query = $this->db->query('SELECT  SUM(ordinarysharesno) AS ordinary from member');
        $data = $query->fetch();
        return $data['ordinary'];
    }

    public function specialshare_no() {
        $this->db = parent::getconnect();
        $query = $this->db->query('SELECT  SUM(specialsharesno) AS special from member');
        $data = $query->fetch();
        return $data['special'];
    }
    
    public function sf_no() {
        $this->db = parent::getconnect();
        $query = $this->db->query('SELECT  SUM(familysituation) AS special from member');
        $data = $query->fetch();
        return $data['special'];
    }

    public function log($par) {
        $this->db = parent::getconnect();
        $query = $this->db->prepare('SELECT * FROM member WHERE  username = ? AND password = ?');
        $append = array($par['user'], $par['pass']);

        if ($query->execute($append)) {
            if ($data = $query->fetch()) {
                $member = new Member($data);
                if ($member->getmemid() > 1) {
                    $query = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Connexion', NOW(), 'Systéme')");
                    $query->execute(array($member->getmemid()));
                }
                return $member;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public function spy_logout($member) {
        $this->db = parent::getconnect();
        if ($member->getmemid() > 1) {
            $query = $this->db->prepare("INSERT INTO `operations` (`opid`, `memid`, `name`, `date`, `target`) VALUES (NULL, ?,'Déconnexion', NOW(), 'Systéme')");
            $query->execute(array($member->getmemid()));
        }
        
    }
    
    public function candidates() {
        $this->db = parent::getconnect();
        $list = array();
        $query = $this->db->query('SELECT *  FROM member WHERE memid > 1 ORDER BY fullname ASC LIMIT 0, 20');

        while ($data = $query->fetch()) {
            $list[] = new Member($data);
        }
        return $list;
    }
    
    public function all_social() {
        $this->db = parent::getconnect();
        $query = $this->db->query('SELECT * FROM member ORDER BY fullname ASC');
        $list = array();
        while ($data = $query->fetch()) {
            $list[] = new Member($data);
        }
        return $list;
    }

}
