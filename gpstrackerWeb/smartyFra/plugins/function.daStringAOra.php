<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.daStringAOra.php
 * Type:     function
 * Name:     daStringAOra
 * Purpose:  da String a Ora i.e.: 151800 -> 15:18:00
 * -------------------------------------------------------------
 */
function smarty_function_daStringAOra($params, &$smarty) { 

    if (isset($params["stringa"])) {
        $stringa=$params["stringa"];
    }

    $mostraSecondi=true;
    if (isset($params["mostraSecondi"])) {
        $mostraSecondi=$params["mostraSecondi"];
    }

    $matches = array();
    preg_match( '/(..)(..)(..)/', $stringa, $match );
    //var_dump( $match );
    
    if (! $mostraSecondi) {
        $res=$match[1].":".$match[2];
        echo $res;
        return;
    }

    $res=$match[1].":".$match[2].":".$match[3];
    echo $res;
}
