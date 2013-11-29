<?php
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

include_once ("login.php");
include_once ("inclusione.inc.php");
include_once ("queries.php");
include_once ("BfaUtilities.php");
include_once "phpmailer/bfaSendEmail.php";
include_once ("classi/Config.php");



function eseguiCrud($datiDaUsare,$classe,$oper) {
    include_once "classi/$classe.php";
    
    $objInstance = new $classe();
    $data=array();

    if (isset($datiDaUsare["idForzato"])) {        
        $id=$datiDaUsare["idForzato"];
    } else {
        if (isset($datiDaUsare["id"])) {
            $id=$datiDaUsare["id"];
        } else {
            $id=getOrEmpty($datiDaUsare,$objInstance->idField,0);    
        }            
    }
    
    if ($id==="" || $id===0 || $id==="0" || $oper=="add" || $id==null) {
        $objInstance->fromArray($datiDaUsare);
        $objInstance->salvati();
        $data=$objInstance->toArray();
        $data["_id"]=$objInstance->getChiaveUnivocaValue();
        $data["_idName"]=$objInstance->{$objInstance->idField};
        return $data;
    }
            
    if ($oper=="del") {
        if (isset($datiDaUsare["id"])) {
            $id=$datiDaUsare["id"];
        } else {
            $id=getOrEmpty($datiDaUsare,$objInstance->idField,0);    
        }  
        $ids= preg_split("/,/", $id);
        foreach ($ids as $id) {
            $objInstance->{$objInstance->idField} = $id;
            $objInstance->cancellati();
        }
        return $data;
    }
    
    if ($oper=="save" || $oper=="edit") {
        $objInstance->{$objInstance->idField} = $id;
        if ($objInstance->settati()) {
            $objInstance->fromArray($datiDaUsare);
            $objInstance->salvati();
            $data=$objInstance->toArray();
            $data["_id"]=$objInstance->getChiaveUnivocaValue();
        }        
        return $data;        
    }
    
    // read
    $objInstance->{$objInstance->idField} = $id;
    if ($objInstance->settati()) {
        $objInstance->fromArray($datiDaUsare);
        $data=$objInstance->toArray();
    }        
    return $data;        
    
}


//$UTE_ANA_ID=$_SESSION["userData"]["UTE_ANA_ID"];
$azione=getGet("azione");
$lavId=getGet("lavId","lastLavId");

$success=true;
$messaggio="ok";
$responce="";
$data="";
switch ($azione) {
    case "crud":
        if (getGet("dati",false)) {
            $datiDaUsare=getGet("dati");
        } else {
            $datiDaUsare=$_POST;
        }
        
        
        if (getOrEmpty($datiDaUsare,"id",null)===null || getGet("id",null)!=null) {
            $datiDaUsare["id"]=  getGet("id",null);
        }
        
        if ($datiDaUsare["id"]===null) {
            unset($datiDaUsare["id"]);
        }
                
        $data=eseguiCrud($datiDaUsare,getGet("classe"),getGet("oper"));
        break;    
        
        
    case "cruds":
        $elementi=getGet("dati");
        
        foreach ($elementi as $elemento) {
            $data[]=eseguiCrud($elemento,$elemento["classe"],$elemento["oper"]);
        }        
           
        break;            
   
    case "classe":
        $classe=getGet("classe");
                
        $dati=getGet("dati");        
        
        include_once "classi/$classe.php";
        $objInstance = new $classe();
        $data="";
        $messaggio="";
        $success=$objInstance->eseguiAzione($dati,$lavId);
        if (isset($objInstance->lastDataSuEseguiAzione)) {
            $data=$objInstance->lastDataSuEseguiAzione;
        }
        if (isset($objInstance->lastMessaggioSuEseguiAzione)) {
            $messaggio=$objInstance->lastMessaggioSuEseguiAzione;
        }
        
        break;
        
    case "controller":
        $classe=getGet("classe");
                
        $dati=getGet("dati");        
        
        include_once "classi/$classe.php";
        $objInstance = new $classe();
        $data="";
        $messaggio="";
        $success=$objInstance->eseguiAzione($dati,$lavId);
        if (isset($objInstance->lastDataSuEseguiAzione)) {
            $data=$objInstance->lastDataSuEseguiAzione;
        }
        if (isset($objInstance->lastMessaggioSuEseguiAzione)) {
            $messaggio=$objInstance->lastMessaggioSuEseguiAzione;
        }
        
        break;
        
        
    case "stampa":
        $jrxml=getGet("jrxml");

        $dati=getGet("dati");        


        global $mysql_host,$mysql_user,$mysql_pass,$mysql_db;
        
        $nf=uniqid("stampa_").".pdf";
        
        $idRecord=  getOrEmpty($dati,'id',0);
        
        $comando="bash ".$DR."/crea_pdf.sh ".$DR."/$jrxml /tmp/$nf ".$idRecord." ".$mysql_host." ".$mysql_user." ".$mysql_pass." ".$mysql_db;
        $res=array();
        exec($comando,$res);

        if (file_exists("/tmp/$nf")) {
            
            $success=true;
            $data=$nf;
        } else {
            $success=false;
            $data="";            
        }

        break;
   
    case "getJson":
        $classe=getGet("classe");
        $dati=getGet("dati");
        
        include_once "classi/$classe.php";
        $objInstance = new $classe();
        $objInstance->fromArray($dati);
        $objInstance->settati();
        
        $success=true;
        $data=$objInstance ->toJSon();;
        $messaggio="";
        
        break;    
    
    
    case "getCodaMessaggi":
        if (!isset($_SESSION["codaMessaggi"])) {
            $_SESSION["codaMessaggi"]=array();
        }
        
        
        $data=$_SESSION["codaMessaggi"];
        
        // pulisco
        $_SESSION["codaMessaggi"]=array();
        
        break;

case "setVariabileDiSessione":
        $name=getGet("name");
        $value=getGet("value",null);
        
        if ($value==null) {
            unset($_SESSION[$name]);
        } else {
            $_SESSION[$name]=$value;
        }
        
        
        break;

}


$res=array("success"=>$success,"data"=>$data,"messaggio"=>$messaggio);

echo json_encode($res);
