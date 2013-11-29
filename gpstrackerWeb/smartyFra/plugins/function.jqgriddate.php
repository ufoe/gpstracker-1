<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.jqgriddate.php
 * Type:     function
 * Name:     labelCV
 * Purpose:  generates a jqgriddate
 * -------------------------------------------------------------
 */

function smarty_function_jqgriddate($params, &$smarty) {  
    
    $name=  getOrEmpty($params, "name");
    $index=  getOrEmpty($params, "index",$name);
    $label=  getOrEmpty($params, "label",$name);
    $width=  getOrEmpty($params, "width",75);
    
    // mettendo degli spazi vuoti di seguito, posso anche mettere // prima dell'inclusione del plugin
    ?>

name: '<?php echo $name;?>', index: '<?php echo $index;?>',label: '<?php echo $label;?>', width: <?php echo $width;?>, sorttype: "date", align: "center", formatter: "date"

, searchoptions: { dataInit: function(el) { $(el).datepicker({ dateFormat: 'dd/mm/yy'}).change(function() {   
        if ($(this).parents(".ui-jqgrid").find(".ui-jqgrid-btable")[0]) {
            $(this).parents(".ui-jqgrid").find(".ui-jqgrid-btable")[0].triggerToolbar();  
        }
    }) ;}
    }
    
, editoptions: { dataInit: function(el) { $(el).datepicker({showOn: "button", dateFormat: 'dd/mm/yy'});}
    }

 <?php      

    
    
}
