{extends file="layout.tpl"}
{block name=title}Gestione Opzioni{/block}
{block name=body}

   

    <div >
        <div id="bc"  style="padding: 1em;">
            <h3>Configurazioni sistema</h3>
            
            <style>
                .label {
                    padding-right: 1em;
                }

            </style>
            <table border="0" cellspacing="0" cellpadding="0">
                {foreach from=$configs item=config}
                
                <tr class="configC" >
                    <input class="autoFra" id="con_id" value="{$config->con_id}" type="hidden"/>
                    <td class="label">{$config->con_des}</td>
                    <td>
                        {if $config->con_tpo == 'euro'}
                            <input class="autoFra laraCurrency" id="con_val" type="text" value="{$config->con_val}"  />
                        {else}
                            <input class="autoFra" id="con_val" type="text" value="{$config->con_val}"  />
                        {/if}
                    </td>
                </tr>
                {/foreach}
                    
            </table>

            <button id="salva">Salva</button><BR/>
            <hr/>
            {*<BR/>            
            <button id="agg">Aggiorna programma</button><button id="svuotaDebug">Svuota file di debug</button>
            <hr/>
            <BR/>            
            <button id="exp">Esporta db</button>
            <BR/>            
            <button id="expcsv">Esporta db in csv</button>
            <hr/>
            Esecuzione custom query:<BR/>            
            <textarea id="cq" cols="100"></textarea>
            <button id="cqb">Esegui</button>
            *}
            
            {literal}                
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
            {/literal}
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
		
		
{/block}
