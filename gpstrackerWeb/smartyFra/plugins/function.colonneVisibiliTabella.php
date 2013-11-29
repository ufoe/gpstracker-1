<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.colonneVisibiliTabella.php
 * Type:     function
 * Name:     colonneVisibiliTabella
 * Purpose:  restituisce le colonne visibili di una tabella in base all'utente
 * -------------------------------------------------------------
 */
function smarty_function_colonneVisibiliTabella($params, &$smarty) { 
    
    if (isset($params["OPE_ID"])) {
        $OPE_ID=$params["OPE_ID"];
    }

    if (isset($params["TABELLA"])) {
        $TABELLA=$params["TABELLA"];
    }
    
    if (! isset($params['assign'])) {
        $params['assign']="colonne";
    }
    

    
    //$esitoTemplate=new Esito();
    $colonne=  dammiArrayListDaQueryAss("SELECT * FROM `operatori_tabelle_colonne` WHERE OTC_OPE_ID=$OPE_ID AND OTC_TABELLA='". mysql_real_escape_string($TABELLA) ."'");
    
    
    $arrCE=array();
    foreach ($colonne as $colonna) {
        $arrCE[ $colonna["OTC_COLONNA"] ]=$colonna["OTC_VISIBILE"];
    }
    
    //$smarty->assign($params['assign'],  $esiti);
    $smarty->assign($params['assign'],  $arrCE);
}
