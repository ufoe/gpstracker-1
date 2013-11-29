<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.query.php
 * Type:     function
 * Name:     query
 * Purpose:  esegue una query
 * -------------------------------------------------------------
 */
function smarty_function_query($params, &$smarty) { 
    global $queries;
    
    include_once 'queries.php';
    include_once 'BfaUtilities.php';
    
    
    $query="";
    if (isset($params["query"])) {
        $query=$params["query"];
    }    
    
//    if ($query=="statoPraticheElencoP") {
//        $query=$query;
//    }

    $limit="";
    if (isset($params["limit"])) {
        $limit=$params["limit"];
    }    

    $riga="";
    if (isset($params["riga"])) {
        $riga=$params["riga"];
    }    
    
    //error_log(print_r($queries,true));

    
    $SQL=$queries[$query];
    
    $SQL=  preg_replace("/\n/"," ", $SQL);
    
    //error_log($query);
    //error_log($SQL);

   
    
    $cosaCercare="{(.*?)}";
    while (preg_match("/\\$cosaCercare/",$SQL, $matches)) {
          $ricerca=$matches[1];

          $val=  getOrEmpty($params, $ricerca);
          
          $vFix=BfaUtilities::fixApostrofe($val);
          $SQL=  preg_replace("/\\"."{".$ricerca."}/",  str_replace('\\', '\\\\',  $vFix), $SQL);
    }

    if ($limit!="") {
        $SQL.=" limit ".$limit;
    }

    error_log("*****************************");
    error_log($SQL);
    $responce=dammiArrayListDaQueryAss($SQL);
   
    if ($riga!=="") {
        if (count($responce)>$riga) {
            $responce=$responce[$riga];
        } else {
            $responce=null;
        }
    }
    
    if (isset($params['assign'])){
        $smarty->assign($params['assign'],  $responce);    
    }
}
