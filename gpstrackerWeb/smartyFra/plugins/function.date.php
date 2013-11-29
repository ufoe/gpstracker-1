<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.date.php
 * Type:     function
 * Name:     date
 * Purpose:  ritorna uan adta
 * -------------------------------------------------------------
 */
function smarty_function_date($params, &$smarty) { 
    
    $format="d/m/Y";
    if (isset($params["format"])) {
        $format=$params["format"];
    }    
    
    $d= date($format);
    if (isset($params['assign'])) {
        $smarty->assign($params['assign'],  $d);    
    }
    
    return $d;    
    
}
