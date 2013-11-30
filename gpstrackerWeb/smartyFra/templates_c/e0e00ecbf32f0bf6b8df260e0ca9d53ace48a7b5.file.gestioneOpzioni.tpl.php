<?php /* Smarty version Smarty-3.1.12, created on 2013-11-30 21:09:30
         compiled from "smartyFra/templates/gestioneOpzioni.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1050024979529a45faaca5f1-28658962%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e0e00ecbf32f0bf6b8df260e0ca9d53ace48a7b5' => 
    array (
      0 => 'smartyFra/templates/gestioneOpzioni.tpl',
      1 => 1381244387,
      2 => 'file',
    ),
    'c4fe4647eb994b98c8fe94b41be278b06f5f7032' => 
    array (
      0 => 'smartyFra/templates/layout.tpl',
      1 => 1381853121,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1050024979529a45faaca5f1-28658962',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pulsantiera' => 0,
    'debug' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_529a45fac54f94_13482565',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_529a45fac54f94_13482565')) {function content_529a45fac54f94_13482565($_smarty_tpl) {?><!DOCTYPE html>
<html>
    <head>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">            
        <?php echo $_smarty_tpl->getSubTemplate ('javascript_css.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('min'=>''), 0);?>
                    
        <title>Gestione Opzioni</title>
    </head>
    <body>
        <div id="loader">CARICAMENTO IN CORSO ...</div>
        
        <?php if ((($tmp = @$_smarty_tpl->tpl_vars['pulsantiera']->value)===null||$tmp==='' ? '' : $tmp)==''){?>
            <?php echo $_smarty_tpl->getSubTemplate ('pulsantiera.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

        <?php }?>

        <div class="ui-layout-center" id="content" style="margin:5px;">
        

   

    <div >
        <div id="bc"  style="padding: 1em;">
            <h3>Configurazioni sistema</h3>
            
            <style>
                .label {
                    padding-right: 1em;
                }

            </style>
            <table border="0" cellspacing="0" cellpadding="0">
                <?php  $_smarty_tpl->tpl_vars['config'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['config']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['configs']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['config']->key => $_smarty_tpl->tpl_vars['config']->value){
$_smarty_tpl->tpl_vars['config']->_loop = true;
?>
                
                <tr class="configC" >
                    <input class="autoFra" id="con_id" value="<?php echo $_smarty_tpl->tpl_vars['config']->value->con_id;?>
" type="hidden"/>
                    <td class="label"><?php echo $_smarty_tpl->tpl_vars['config']->value->con_des;?>
</td>
                    <td>
                        <?php if ($_smarty_tpl->tpl_vars['config']->value->con_tpo=='euro'){?>
                            <input class="autoFra laraCurrency" id="con_val" type="text" value="<?php echo $_smarty_tpl->tpl_vars['config']->value->con_val;?>
"  />
                        <?php }else{ ?>
                            <input class="autoFra" id="con_val" type="text" value="<?php echo $_smarty_tpl->tpl_vars['config']->value->con_val;?>
"  />
                        <?php }?>
                    </td>
                </tr>
                <?php } ?>
                    
            </table>

            <button id="salva">Salva</button><BR/>
            <hr/>
            
            
                            
            <script>
                $("#salva").button({icons: {primary: "customIconSalva"},text: true}).click(function() {
                    
                    var dati=[];
                    
        
                    $("#bc .configC").each(function() {
                        
                        var config={
                            classe: "Config"
                            , oper: "edit"
                        };
                        
                        $(this).find(".autoFra").each(function() {
                            if ($(this).attr("type") === "checkbox") {
                                if ($(this).prop("checked")) {
                                    config[$(this).attr("id")] = 1;
                                } else {
                                    config[$(this).attr("id")] = 0;
                                }
                            } else {
                                
                                if ($(this).hasClass("laraCurrency")) {
                                    config[$(this).attr("id")] = $(this).asNumber();
                                } else {
                                    config[$(this).attr("id")] = $(this).val();
                                }
                                
                                
                                
                            }
                        });
                        
                        
                        
                        
                        dati.push(config);
                    });
                    
                    chiamataAjax({
                        url: "eseguiAzione.php"
                        , type: "POST"
                        , data: {
                            azione: "cruds"
                            , dati: dati
                        }
                        , onSuccess: function(res) {
							showDialog();
							
							},
                        onError: function() {}
                    });
               	});
				
				function showDialog() {
						
						$( "#dialog" ).dialog({
					 
				     		modal: true,
							draggable: false,
							resizable: false,
							position: ['center', 'center'],
							show: 'blind',
							hide: 'blind',
							width: 400
							
							});
							
				      }
                      
    
    
                $("#agg").button({icons: {primary: "customIconSalva"},text: true}).click(function() {
                    
                    $('#okDiv').fadeIn();
        
                    chiamataAjax({
                        url: "eseguiAzione.php"
                        , type: "POST"
                        , data: {
                            azione: "updateTutto"                            
                        }
                        , onSuccess: function(res) {
							$('#okDiv').fadeOut("slow");
                            showDialog();							
							},
                        onError: function() {}
                    });
               	});
                
                $("#svuotaDebug").button({icons: {primary: "customIconSalva"},text: true}).click(function() {
                    
                    $('#okDiv').fadeIn();
        
                    chiamataAjax({
                        url: "eseguiAzione.php"
                        , type: "POST"
                        , data: {
                            azione: "svuotaDebug"                            
                        }
                        , onSuccess: function(res) {
							$('#okDiv').fadeOut("slow");
                            showDialog();							
							},
                        onError: function() {}
                    });
               	});
                
                $("#exp").button({icons: {primary: "customIconSalva"},text: true}).click(function() {
                    
                    $('#okExp').fadeIn();
        
                    chiamataAjax({
                        url: "eseguiAzione.php"
                        , type: "POST"
                        , data: {
                            azione: "esportaTutto"                            
                        }
                        , onSuccess: function(res) {
							$('#okExp').fadeOut("slow");
                            //showDialog();							
                            
                            window.open(res.data,'_blank');
        
							},
                        onError: function() {}
                    });
               	});
                
                $("#expcsv").button({icons: {primary: "customIconSalva"},text: true}).click(function() {
                    
                    $('#okExp').fadeIn();
        
                    chiamataAjax({
                        url: "eseguiAzione.php"
                        , type: "POST"
                        , data: {
                            azione: "esportaTuttoCsv"                            
                        }
                        , onSuccess: function(res) {
                            $('#okExp').fadeOut("slow");
                            //showDialog();							
                            
                            window.open(res.data,'_blank');
        
							},
                        onError: function() {}
                    });
               	});
    

                $("#cqb").button({icons: {primary: "customIconSalva"},text: true}).click(function() {
                    
                    $('#okCqb').fadeIn();
        
                    chiamataAjax({
                        url: "eseguiAzione.php"
                        , type: "POST"
                        , data: {
                            azione: "customQuery"                            
                            ,testo: $("#cq").val()
                        }
                        , onSuccess: function(res) {
							$('#okCqb').fadeOut("slow");
                            showDialog();        
                        },
                        onError: function() {}
                    });
               	});
    
                $(".laraCurrency").formattaInputTextComeCurrency();
    
            </script>
            
        </div>

        <div id="dialog" title="Salvataggio" style="display: none;">
              <p>Modifiche ai parametri salvate correttamente</p>
            </div> 
        


        <div id="okDiv" class="ui-widget" style="display: none;">
            <div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;"> 
                <p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
                <!--strong>OK</strong--> Aggiornamento in corso</p>
            </div>
        </div>
        
        <div id="okExp" class="ui-widget" style="display: none;">
            <div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;"> 
                <p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
                Esportazione db in corso</p>
            </div>
        </div>
        
        <div id="okCqb" class="ui-widget" style="display: none;">
            <div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;"> 
                <p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
                Esecuzione in corso</p>
            </div>
        </div>
        
    </div>
		
		

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
<?php if ((isset($_smarty_tpl->tpl_vars['debug']->value))){?><?php $_smarty_tpl->smarty->loadPlugin('Smarty_Internal_Debug'); Smarty_Internal_Debug::display_debug($_smarty_tpl); ?><?php }?>
<?php }} ?>