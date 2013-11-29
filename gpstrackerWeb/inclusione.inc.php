<?php

    
    //ob_start();
    //session_start();
    require_once("settings.inc.php");
    //require_once($DR."/users/checkLoginLib.php");

    global $DR;
    if ($DR!="") {
        require_once($DR."/functions.php");
    } else {
        require_once("functions.php");
    }
    
    
    require_once( 'log4php/Logger.php' );
    Logger::configure(dirname(__FILE__).'/prg.xml');
    $logger = Logger::getLogger("main");
    
    
   if ($DR!="") {
        include_once ($DR."/ConnessioneDB.php");
    } else {
        include_once ("ConnessioneDB.php");
    }
    
    
   
