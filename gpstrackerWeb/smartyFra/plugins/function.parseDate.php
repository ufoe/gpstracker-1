<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.parseDate.php
 * Type:     function
 * Name:     parseDate
 * Purpose:  ritorna un timestamp da una data
 * -------------------------------------------------------------
 */
function smarty_function_parseDate($params, &$smarty) { 
    
    $format="d/m/Y";
    if (isset($params["format"])) {
        $format=$params["format"];
    }    
    
    if (! isset($params["data"])) {
        $params["data"]=  BfaUtilities::dammiDataOdierna();
    }    
    
    
    $d= date_create_from_format($format,$params["data"]);
    if (isset($params['assign'])) {
        $res=$d->format('U');
        $smarty->assign($params['assign'],  $res);
    }
    
    
}
