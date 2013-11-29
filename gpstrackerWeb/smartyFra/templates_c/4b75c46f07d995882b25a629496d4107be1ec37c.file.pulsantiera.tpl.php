<?php /* Smarty version Smarty-3.1.12, created on 2013-11-26 10:41:10
         compiled from "smartyFra/templates/pulsantiera.tpl" */ ?>
<?php /*%%SmartyHeaderCode:56874653252946cb6d10862-76663795%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4b75c46f07d995882b25a629496d4107be1ec37c' => 
    array (
      0 => 'smartyFra/templates/pulsantiera.tpl',
      1 => 1385458447,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '56874653252946cb6d10862-76663795',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'admin' => 0,
    'alertDebugAbilitato' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_52946cb6d454b4_70964755',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52946cb6d454b4_70964755')) {function content_52946cb6d454b4_70964755($_smarty_tpl) {?><div class="ui-layout-north">
    <div class="pulsantiera ui-widget-header ui-corner-all" style="padding-left: 0px;">
        <a data-icona='customIconHome' data-tv='false' href='index.php?template=menuHome.tpl&cache=0' class="mc">Home</a>
        <a data-icona='customIconContabile' data-tv='true' href='index.php?template=menuContabilita.tpl&cache=0' class="mc" title="Accedi al menu contabile" >Contabilit&agrave;</a>
        <a data-icona='customIconOrdini' data-tv='true' href='index.php?template=menuOrdini.tpl&cache=0' class="mc">Ordini</a>
        
        <a data-icona='customIconDdt' data-tv='true' href='index.php?template=menuDdt.tpl&cache=0' class="mc" onmouseover='creaMenu("menuDDT",this);'>Ddt</a>        
        
                
        <a data-icona='customIconFatture' data-tv='true' href='index.php?template=segui.tpl&cache=0' class="mc">Segui</a>
        
    
        <?php if ($_smarty_tpl->tpl_vars['admin']->value){?>
        <input 
            type="checkbox" 
            value="" 
            id="abilitaDebug" 
            name="abilitaDebug" 
            title="Abilita il debug delle query e varie"   
            <?php if ($_smarty_tpl->tpl_vars['alertDebugAbilitato']->value){?>checked="true"<?php }?>
         /><label for="abilitaDebug">debug</label>
        <script>
            $( "#abilitaDebug" ).button().change(function() {
                alertDebugAbilitato=$( "#abilitaDebug" ).is(":checked");
                setVariabileDiSessione("alertDebugAbilitato",alertDebugAbilitato);
            });
            
            alertDebugAbilitato=<?php if ($_smarty_tpl->tpl_vars['alertDebugAbilitato']->value){?>true<?php }else{ ?>false<?php }?>;
            
        </script>

        <?php }?>
        
        
        
        <a data-icona='customIconLogOut' data-tv='true' href='login.php?action=logout' class="mc" style="float:right;">Logout</a>
        <a data-icona='customIconTabelle' data-tv='false' href='index.php?template=gestioneOpzioni.tpl&cache=0' class="mc" style="float:right;">Admin</a>            
    </div>

        <style>
            .menuFra {
                margin-top: 10px;
            }
        </style>
    <ul id="menuDDT" class="" style="position:absolute;display:none;">
        <li><a href="index.php?template=menuDdt.tpl&cache=0"><span class="ui-icon customIconNuovo"></span>Nuovo</a></li>
        <li><a href="index.php?template=menuDdt.tpl&cache=0&sm=elenco"><span class="ui-icon ui-icon-search"></span>Elenco ...</a></li>        
    </ul>
        
    <ul id="menu" class="" style="position:absolute;display:none;">
        <li><a href="#"><span class="ui-icon ui-icon-disk"></span>Save</a></li>
        <li><a href="#"><span class="ui-icon ui-icon-zoomin"></span>Zoom In</a></li>
        <li><a href="#"><span class="ui-icon ui-icon-zoomout"></span>Zoom Out</a></li>
        <li class="ui-state-disabled"><a href="#"><span class="ui-icon ui-icon-print"></span>Print...</a></li>
        <li>
            <a href="#">Playback</a>
        <ul>
            <li><a href="#"><span class="ui-icon ui-icon-seek-start"></span>Prev</a></li>
            <li><a href="#"><span class="ui-icon ui-icon-stop"></span>Stop</a></li>
            <li><a href="#"><span class="ui-icon ui-icon-play"></span>Play</a></li>
            <li><a href="#"><span class="ui-icon ui-icon-seek-end"></span>Next</a></li>
        </ul>
        </li>
    </ul>

    <script  src="js/pulsantiera.js"></script>
    
    <script>$( "#menu" ).menu();</script>
</div>
<?php }} ?>