<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.get_unique_id.php
 * Type:     function
 * Name:     get_unique_id
 * Purpose:  generates a unique id
 * -------------------------------------------------------------
 */
function smarty_function_get_unique_id($params, &$smarty) { 
 $divId = uniqid();
 $smarty->assign($params['assign'],$divId);
}
