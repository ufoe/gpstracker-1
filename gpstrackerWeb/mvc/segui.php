<?php

include_once 'BfaUtilities.php';
include_once 'classi/PointUltimo.php';

$azione=  getGet("a",null);
$tipoDati = getGet('tipoDati','json');

if ($azione!=null) {
    if ($tipoDati == "json") {
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
    }
    
    $success=true;
    $data=array();
    $messaggio="ok";
    
    
    
    
    if ($azione=="dammiUltimo") {
        
        $dati=  getGet("dati",null);
        

        $point=new PointUltimo();
        $point->PNT_AID= getOrEmpty($dati, "PNT_AID",'e9bbc191771fa0b9') ;
        $point->settati();

        $data["point"]=$point;
        
        
    }
        
    
    
    
    if ($tipoDati == "json") {
        $res=array("success"=>$success,"data"=>$data,"messaggio"=>$messaggio);
        echo json_encode($res);
        exit;
    }
}

$domani =  BfaUtilities::dammiGiornoSeguente(BfaUtilities::dammiDataOdierna());
$smarty->assign("domani",  $domani);

$point=new PointUltimo();
$point->PNT_AID='e9bbc191771fa0b9';
$point->settati();

$smarty->assign("point",  $point);