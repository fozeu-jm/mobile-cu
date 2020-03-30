<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Manager
 *
 * @author ZE-KAIZER
 */
class Manager {
    
    protected function getconnect(){
        try {
            $host = '127.0.0.1';
            $db='tontine';
            $user='root';
            $pass='';
            $charset='utf8mb4';
            $dsn="mysql:host=$host;dbname=$db;charset=$charset";
            $opt=[
                PDO::ATTR_ERRMODE          => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE    => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $pdo=new PDO($dsn,$user,$pass,$opt);
        } catch (Exception $exc) {
           echo $exc->getTraceAsString();
        }
        return $pdo;
    } 
}
