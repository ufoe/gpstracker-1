<?php
include_once 'functions.php';

if (getGet("action")=="controlloLogin") {
    include_once 'users/checkLogin.php';
    return;
   
}


if (getGet("action")=="logout") {
    // log out
    include_once 'users/logout.php';
    return;
    
}

//include_once 'login.php';
require_once("inclusione.inc.php");
include_once 'include_smarty.php';

//$smarty->assign('name', 'Ned');

if (getGet("action")=="login") {
   //login page   
    $smarty->display('login.tpl');
    //include_once 'users/login.php';    
    return;
}






// controllo session
ob_start();
session_start();

include_once 'users/user_config.php';

//session_regenerate_id();
if (!isset($_SESSION[$user_id_field_session_name]))  {
    // if there is no valid session
    header("Location: login.php?action=login");
    return;
}


// ok, session
$smarty->assign("admin", false);
//if (isSet($_SESSION["userData"])) {
//    if (isset($_SESSION["userData"]["OPE_ADM"]))  {
//        $smarty->assign("admin", $_SESSION["userData"]["OPE_ADM"]>0);
//    }
//}
if (isSet($_SESSION["userData"])) {
    if (isset($_SESSION["userData"]["OPE_ADM"]))  {
        $smarty->assign("admin", $_SESSION["userData"]["OPE_ADM"]>0);
    }
}
