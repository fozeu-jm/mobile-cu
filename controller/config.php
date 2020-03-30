<?php

if(isset($_GET['lang'])){
    if(in_array($_GET['lang'], array('fr','en','ch'))){
        $_SESSION['lang']= $_GET['lang'];
    }else{
        $_SESSION['lang']= 'fr';
    }
}

if(!isset($_SESSION['lang'])){
    $_SESSION['lang']= 'fr';
}

include ($_SESSION['lang'] . '.php');

