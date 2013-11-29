<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.labelCV.php
 * Type:     function
 * Name:     labelCV
 * Purpose:  generates a label like: key: value
 * -------------------------------------------------------------
 */

function smarty_function_labelCV($params, &$smarty) {  
    
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
        $params["compatto"]=false;
    }
//    if (!isset($params["options"])) {
//        $params["options"]="";
//    }
//    if (!isset($params["type"])) {
//        $params["type"]="";
//    }
    
    ?><?php if (!$params["compatto"]) { ?><div data-role="fieldcontain"><?php } ?>
            <?php if ($params["label"]!="") { ?><label for="search-basic"><?=$params["label"];?></label><?php } ?>            
            <span class="<?=$params["classe"];?>" id="<?=$params["id"];?>"><?=$params["value"];?></span>            
        <?php if (!$params["compatto"]) { ?></div><?php } ?>
    <?php
}
