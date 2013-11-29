<div class="ui-layout-north">
    <div class="pulsantiera ui-widget-header ui-corner-all" style="padding-left: 0px;">
        <a data-icona='customIconHome' data-tv='false' href='index.php?template=menuHome.tpl&cache=0' class="mc">Home</a>
        <a data-icona='customIconContabile' data-tv='true' href='index.php?template=menuContabilita.tpl&cache=0' class="mc" title="Accedi al menu contabile" >Contabilit&agrave;</a>
        <a data-icona='customIconOrdini' data-tv='true' href='index.php?template=menuOrdini.tpl&cache=0' class="mc">Ordini</a>
        
        <a data-icona='customIconDdt' data-tv='true' href='index.php?template=menuDdt.tpl&cache=0' class="mc" onmouseover='creaMenu("menuDDT",this);'>Ddt</a>        
        
                
        <a data-icona='customIconFatture' data-tv='true' href='index.php?template=segui.tpl&cache=0' class="mc">Segui</a>
        {*callhook hook="menu"*}
    
        {if $admin}
        <input 
            type="checkbox" 
            value="" 
            id="abilitaDebug" 
            name="abilitaDebug" 
            title="Abilita il debug delle query e varie"   
            {if $alertDebugAbilitato}checked="true"{/if}
         /><label for="abilitaDebug">debug</label>
        <script>
            $( "#abilitaDebug" ).button().change(function() {
                alertDebugAbilitato=$( "#abilitaDebug" ).is(":checked");
                setVariabileDiSessione("alertDebugAbilitato",alertDebugAbilitato);
            });
            
            alertDebugAbilitato={if $alertDebugAbilitato}true{else}false{/if};
            
        </script>

        {/if}
        
        
        
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
