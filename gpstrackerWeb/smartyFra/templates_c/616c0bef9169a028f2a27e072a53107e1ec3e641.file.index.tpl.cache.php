<?php /* Smarty version Smarty-3.1.12, created on 2013-11-30 10:40:45
         compiled from "smartyFra/templates/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:147062888752657976c279d1-93009472%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '616c0bef9169a028f2a27e072a53107e1ec3e641' => 
    array (
      0 => 'smartyFra/templates/index.tpl',
      1 => 1381824085,
      2 => 'file',
    ),
    'c4fe4647eb994b98c8fe94b41be278b06f5f7032' => 
    array (
      0 => 'smartyFra/templates/layout.tpl',
      1 => 1381853121,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '147062888752657976c279d1-93009472',
  'function' => 
  array (
  ),
  'cache_lifetime' => 3600,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_52657976ccdfd1_02012083',
  'variables' => 
  array (
    'pulsantiera' => 0,
    'debug' => 0,
  ),
  'has_nocache_code' => true,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52657976ccdfd1_02012083')) {function content_52657976ccdfd1_02012083($_smarty_tpl) {?><!DOCTYPE html>
<html>
    <head>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">            
        <?php echo $_smarty_tpl->getSubTemplate ('javascript_css.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array('min'=>''), 0);?>
                    
        <title>Titolo da sistemare</title>
    </head>
    <body>
        <div id="loader">CARICAMENTO IN CORSO ...</div>
        
        <?php if ((($tmp = @$_smarty_tpl->tpl_vars['pulsantiera']->value)===null||$tmp==='' ? '' : $tmp)==''){?>
            <?php echo $_smarty_tpl->getSubTemplate ('pulsantiera.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

        <?php }?>

        <div class="ui-layout-center" id="content" style="margin:5px;">
        

        </div>
        
        <script>$(function() { 
            var myLayout=$('body').layout({
                north: {
                    closable: false
                    ,resizable : false
                    ,slidable : false
                    ,spacing_open : -1                    
                }
            });
            myLayout.allowOverflow('north'); 
            
            $(".laraCurrency").formattaInputTextComeCurrency();
            $(".laraDate").datepicker({ dateFormat: 'dd/mm/yy'});
            $(".selectText").each(
                function(i,elemento) {
                    $(elemento).generaAutoComplete( 
                        $(elemento).data("query") 
                        ,null
                        ,function (io,dest,valore) { 
                            executeFunctionByName($(elemento).data("callback"),window,io,dest,valore);
                            //$( "input#selectAllestimento" ).autoCompleteParametri( { all_vet_id: valore} );
                        }
                    );
                }
            );
            
            
            
            
            callLoader(); 
        });</script>        
    </body>
</html>
<?php if ((isset($_smarty_tpl->tpl_vars['debug']->value))){?><?php echo '/*%%SmartyNocache:147062888752657976c279d1-93009472%%*/<?php $_smarty_tpl->smarty->loadPlugin(\'Smarty_Internal_Debug\'); Smarty_Internal_Debug::display_debug($_smarty_tpl); ?>/*/%%SmartyNocache:147062888752657976c279d1-93009472%%*/';?>
<?php }?>
<?php }} ?>