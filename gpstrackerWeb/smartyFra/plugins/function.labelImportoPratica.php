<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.labelImportoPratica.php
 * Type:     function
 * Name:     labelImportoPratica
 * Purpose:  generates a label di un importo pratica
 * -------------------------------------------------------------
 */

function smarty_function_labelImportoPratica($params, &$smarty) {  
    
    if (!isset($params["id"])) {
        $divId = uniqid();
        //$smarty->assign($params['assign'],$divId);
        $params["id"]=$divId;
    } else {
        //$smarty->assign($params['assign'],$params["id"]);
    }
    if (!isset($params["label"])) {
        $params["label"]="";
    } else {
        $params["label"].="&nbsp;";
    }
    if (!isset($params["value"])) {
        $params["value"]="";
    }

    if (!isset($params["classe"])) {
        $params["classe"]="";
    }

    if (!isset($params["compatto"])) {
        $params["compatto"]=true;
    }


//    if (!isset($params["options"])) {
//        $params["options"]="";
//    }
//    if (!isset($params["type"])) {
//        $params["type"]="";
//    }
    
    ?><?php if (!$params["compatto"]) { ?><div data-role="fieldcontain"><?php } ?>
            <?php if ($params["label"]!="") { ?><label><?=$params["label"];?></label><?php } ?>
            <span class="<?=$params["classe"];?>" id="<?=$params["id"];?>"><?=$params["value"];?></span>            
        <?php if (!$params["compatto"]) { ?></div><?php } ?>
    <?php
}
