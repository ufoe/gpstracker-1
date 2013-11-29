<?php

include_once 'login.php';
include_once 'include_smarty.php';

foreach ($_GET as $key=>$value) {
    $smarty->assign($key, getGet($key));
}
foreach ($_POST as $key=>$value) {
    $smarty->assign($key, getGet($key));
}

//$smarty->assign("user", $_SESSION["userData"]);


// controller opzionale
if (getGet('controller',null)!=null) {
    $mvcF='mvc/'.  getGet('controller').".php";
    if (file_exists($mvcF)){
        include_once $mvcF;
    }    
}

// controller opzionale
if (getGet('template',null)!=null) {
    
    $nomeTemplateSenzaTpl_=getGet('template');
    $nomeTemplateSenzaTpl=substr($nomeTemplateSenzaTpl_, 0, strrpos($nomeTemplateSenzaTpl_, '.'));  
    
    
    $mvcF="mvc/$nomeTemplateSenzaTpl.php";
    if (file_exists($mvcF)){
        include_once $mvcF;
    }    
}



$smarty->assign("alertDebugAbilitato", getOrEmpty($_SESSION, "alertDebugAbilitato","false")=="true");

$smarty->assign("template", getGet("template", "index.tpl"));
$smarty->display($smarty->getVariable("template")->value);


