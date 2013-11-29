<!DOCTYPE html>
<html>
    <head>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">            
        {include file='javascript_css.tpl' min=''}                    
        <title>{block name=title}Sito{/block}</title>
    </head>
    <body>
        <div id="loader">CARICAMENTO IN CORSO ...</div>
        
        {if $pulsantiera|default==""}
            {include file='pulsantiera.tpl'}
        {/if}

        <div class="ui-layout-center" id="content" style="margin:5px;">
        {block name=body}{/block}
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
{if (isset($debug))}{debug}{/if}
