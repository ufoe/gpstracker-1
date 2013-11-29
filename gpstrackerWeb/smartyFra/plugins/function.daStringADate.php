<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.daStringADate.php
 * Type:     function
 * Name:     daStringADate
 * Purpose:  da String a data i.e.: 20090131 -> 31/01/2009
 * -------------------------------------------------------------
 */
function smarty_function_daStringADate($params, &$smarty) { 

    if (isset($params["stringa"])) {
        $stringa=$params["stringa"];
    }

    $esteso=false;
    if (isset($params["esteso"])) {
        $esteso=$params["esteso"];
    }

    $matches = array();
    preg_match( '/(....)(..)(..)/', $stringa, $match );
    //var_dump( $match );
    
    if ($esteso) {
        $anno=$match[1];
        $mese=(int) $match[2];
        $giorno=$match[3];
        
        $mesi=array("Gennaio","Febbraio","Marzo","Aprile","Maggio","Giugno","Luglio","Agosto","Settembre","Ottobre","Novembre","Dicembre");
        $meseTxt=$mesi[$mese-1];
        echo $meseTxt." ".$giorno.",".$anno;
        return;
    }

    $res=$match[3]."/".$match[2]."/".$match[1];
    echo $res;
}
