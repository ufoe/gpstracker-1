<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage PluginsModifier
 */

/**
 * Smarty replace modifier plugin
 * 
 * Type:     modifier<br>
 * Name:     replace<br>
 * Purpose:  simple search/replace
 * 
 * @link http://smarty.php.net/manual/en/language.modifier.replace.php replace (Smarty online manual)
 * @author Monte Ohrt <monte at ohrt dot com> 
 * @author Uwe Tews 
 * @param string $string  input string
 * @param string $search  text to search for
 * @param string $replace replacement text
 * @return string 
 */
function smarty_modifier_stringToDate($stringa) {

    $esteso=false;
    if (isset($params["esteso"])) {
        $esteso=$params["esteso"];
    }

    $matches = array();
    preg_match( '/(....)(..)(..)/', $stringa, $match );

	if (count($match)==0) {
		return "";
	}

    $res=$match[3]."/".$match[2]."/".$match[1];
    return $res;	

} 

?>