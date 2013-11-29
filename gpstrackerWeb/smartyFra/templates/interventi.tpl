{extends file="layout.tpl"}
{block name=body}

    <div class="ui-layout-center" >
    <div id="interventi">          

            <table id="elencoInterventi"></table>       
            <div id="elencoInterventi_pager"></div> 

    </div>
    </div>

    <div class="ui-layout-east" >
        <div id="bc"  style="padding: 1em;">
            <h3>Intervento</h3>
                
            <butto id="nuovo">Nuovo</butto>
            {literal}                
            <script>
                $("#nuovo").button({icons: {primary: "customIconNuovo"},text: true}).click(function() {
                    $(this).parent().find(".autoFra").each(function() {
                        if ($(this).attr("type")==="checkbox") {
                            $(this).prop('checked', false);
                        } else {
                            $(this).val("");
                        }
                    });
                    jQuery("#elencoInterventi").jqGrid('resetSelection');
                });
            </script>
            {/literal}                      

            <input class="autoFra" id="INT_ID" type="hidden"/><!--  -->
            <style>
                .label {
                    margin-right: 1em;
                }

            </style>
            <table border="0" cellspacing="0" cellpadding="0">
                
                 <tr>
                    <td class="label">Data prog.</td>
                    <td><input class="autoFra laraDate" id="INT_PROG_DTA"  value="" size="10" /></td>                    
                </tr>
                 <tr>
                    <td class="label">Stato</td>
                    <td><input class="autoFra selectText" id="INT_STI_ID"  value="" size="10" data-query="stati_interventi_select" data-callback="cb1"/></td>
                 <script>
                     function cb1(io,dest,valore) {
                         {*fbLog("a",io);
                         fbLog("b",dest);
                         fbLog("c",valore);*}
                     }
                     
                 </script>
                 
                    
                </tr>
                <!--tr>
                    <td class="label">cognome</td>
                    <td><input class="autoFra" id="ANA_COGNOME" type="text" value="" size="20" /></td>                    
                </tr>
                <tr>
                    <td class="label">nome</td>
                    <td><input class="autoFra" id="ANA_NOME" type="text" value="" size="20" /></td>                    
                </tr>
                <tr>
                    <td class="label">indirizzo</td>
                    <td><input class="autoFra" id="ANA_INDIRIZZO" type="text" value="" size="20" /></td>                    
                </tr>
                <tr>
                    <td class="label">cap</td>
                    <td><input class="autoFra" id="ANA_CAP" type="text" value="" size="20" /></td>                    
                </tr>
                <tr>
                    <td class="label">prov</td>
                    <td><input class="autoFra" id="ANA_PROVINCIA" type="text" value="" size="20" /></td>                    
                </tr>
                <tr>
                    <td class="label">tel</td>
                    <td><input class="autoFra" id="ANA_TEL" type="text" value="" size="20" /></td>                    
                </tr>
                <tr>
                    <td class="label">cell</td>
                    <td><input class="autoFra" id="ANA_CELL" type="text" value="" size="20" /></td>                    
                </tr>

                <tr>
                    <td class="label">email</td>
                    <td><input class="autoFra" id="ANA_EMAIL" type="email" value="" size="20" /></td>                    
                </tr>
                <!tr>
                    <td class="label">admin</td>
                    <td><input class="autoFra" id="OPE_ADM" type="checkbox" value="0"  /></td>                    
                </tr-->
            </table>
            
            <hr/>

            
            
            <butto id="salva">Salva</butto>
            {literal}                
            <script>
                $("#salva").button({icons: {primary: "customIconSalva"},text: true}).click(function() {
                    var elementi=$("#bc .autoFra");
                    //var e={profili: $("#selectable .ui-selected").map(function() {return this.id;})};
                    //elementi.push(e);
                    
                    fbLog("elementi",elementi);
                    
                    creaChiamataSalva(
                            $("#INT_ID").val()
                            ,elementi // elementi
                            ,"Intervento" // nome classe
                            ,$('#elencoInterventi')// tabella da aggiornare poi
                            ,$("#INT_ID")
                            ,function(data) {
                                if (window.opener) {
                                    window.opener.SetPopUpData(data);
                                    window.close();
                                }
                            }
                    );
                });
            </script>
            {/literal}
                
                
            <butto id="cancella">Cancella</butto>
            {literal}                
            <script>
                $("#cancella").button({icons: {primary: "customIconCancella"},text: true}).click(function() {
                    creaChiamataDel(
                            $("#ANA_ID").val() // id
                            ,"Intervento" // nome classe
                            ,$('#elencoInterventi')// tabella da aggiornare poi
                    );
                });
                
                
            </script>
            {/literal}
                
        </div>
    </div>
    
    <script>
        $(function() {
            $('#content').layout({
                center: {
                    size: "auto"
                    , onresize: function(pname, pelement, pstate, poptions, lame) {
                        aggiustaAltezzaJQGrid("elencoInterventi", pstate.innerHeight);
                        $("#elencoInterventi").jqGrid('setGridWidth', pstate.innerWidth - 3, true);
                    }
                }
                ,east: {
                    size: "300"
                    //closable: false
                    //,resizable : false
                    //,slidable : false
                    //,spacing_open : -1
                }
            });

           {* function apriPreventivi_(ANA_ID) {
                //window.open("getTemplate.php?template=preventivi.tpl&cache=0&ANA_ID="+ANA_ID,"_blank");
            }
            var apriPreventivi =function(cellvalue, options, rowObject) {
                if (rowObject) {
                    return "<a href='getTemplate.php?template=preventivi.tpl&cache=0&ANA_ID="+rowObject.ANA_ID+"' data='"+rowObject.ANA_ID+"'>" + 
                        "<img src='img/icon/ddt.png'/>"
                        + "</a>";//onclick='apriPreventivi_(\"" + rowObject.ANA_ID + "\")'
                }
            };*}
            
     
            jQuery("#elencoInterventi").jqGrid({
                url: 'eseguiQueryJQGrid.php?query=interventi_jqgrid'
                , editurl: "eseguiAzione.php"
                , mtype: 'POST'
                , datatype: "json"
                ,height: 500
                //, height: '100%'
                ,autowidth:true
                //shrinkToFit:true,
                ,jsonReader: {
                    root: "rows",
                    page: "page",
                    total: "total",
                    records: "records",
                    repeatitems: false
                }
                ,rowNum: 100
                ,rowList:[10,100,100000000]
                ,pgbuttons:true,pgtext:true,pginput:false
                
                , colModel: [
                    { name: 'INT_ID', index: 'INT_ID',label: 'id', key: true ,hidden: false, width:"40", sorttype: "text", align: "right",editable: false}
                    ,{ name: 'RagioneSociale', index: 'RagioneSociale',label: 'cliente', sorttype: "text", align: "left",editable: false} 
                    ,{ label: 'sede intervento', name: 'SdSede', sorttype: "text", align: "left",editable: false}
                    ,{ label: 's. indirizzo', name: 'SdIndirizzo', sorttype: "text", align: "left",editable: false}
                    ,{ label: 's. localita\'', name: 'SdLocalita', sorttype: "text", align: "left",editable: false}
                    ,{ label: 'prov', name: 'SdProvincia', width:"50", sorttype: "text", align: "left",editable: false}
                    ,{include file='sub/jqgridSelectBox.tpl' query='manutentore_select' name='SdManutentore' label='manutentore' editable='false'}
                    ,{ label: 'zona', name: 'SdZona', width:"50", sorttype: "text", align: "left",editable: false}
                    ,{ label: 'contratto', name: 'SdTipoContratto', sorttype: "text", align: "left",editable: false}
                    ,{ label: 'mese', name: 'SdDaMese', width:"50", sorttype: "text", align: "right",editable: false}
                    ,{ {jqgriddate label='Data int.' name='INT_PROG_DTA'},editable: true }
                    ,{include file='sub/jqgridSelectBox.tpl' query='stati_interventi_select' name='INT_STI_ID' label='stato'}
                    
                ]
                //,multiselect: true
                , pager: '#elencoInterventi_pager'
                , gridview: true
                , caption: "Elenco Interventi"
                , viewrecords:true
                //, sortname: "data"                    
                   , sortname: "INT_ID"
                , gridComplete: function() { 
                    //$("#elencoInterventi_pager option[value=100000000]").text('All');                
                }
                , loadComplete: function(data) { 
                    $("option[value=100000000]").text('tutti');
                }
                , beforeProcessing: function(data) {
                //, loadComplete: function(data) {
                    //sistemaTrueFalsePerPG(data.rows);
                }
                , onSelectRow: function(id) {
                    var res = jQuery("#elencoInterventi").jqGrid('getRowData', id);
                    fbLog("res",res);
                    
                    $("#bc .autoFra").each(function() {
                        //fbLog("this",this);
                        
                        if ($(this).attr("type")==="checkbox") {
                            $(this).prop('checked', trueOrfalse(res[$(this).attr("id")]));                            
                        } else if ($(this).hasClass("selectText")) {
                            var gsId=$(this).attr("id");
                            var gsValore=res[gsId];
                            var testoT=$("#gs_"+gsId+" option[value='"+gsValore+"']").text();
                            
                            $(this).autoCompleteSetId(gsValore,testoT);
                        } else {
                            $(this).val(res[$(this).attr("id")]);
                        }
                    });
                    
                    //$("#ANA_VEN_ID").find(".ui-selected").removeClass("ui-selected");
                    //$("#profilo_"+res.ANA_VEN_ID).addClass("ui-selected");
                    
                }
                , beforeSelectRow: function(rowid, e) {
                    //jQuery("#elencoInterventi").jqGrid('resetSelection');
                    return(true);
                }

                , search: {
                    caption: "Search...",
                    Find: "Find",
                    Reset: "Reset",                        
                    odata: ['equal', 'not equal', 'less', 'less or equal', 'greater', 'greater or equal', 'begins with', 'does not begin with', 'ends with', 'does not end with', 'contains', 'does not contain']                
                }
            }).navGrid(
                    '#elencoInterventi_pager', { edit: true, add: false, del: true,search:true,refresh:true }
            , {
                closeAfterEdit: true
                , closeOnEscape: true
                , editData: { azione: "crud", classe: "Intervento"}
                //, beforeSubmit: beforeSubmitF
                //,afterSubmit: UploadImage

            } // edit options
            , {
                closeOnEscape: true
                , closeAfterAdd: true
                , editData: { azione: "crud", classe: "Intervento"}
    //            , beforeSubmit: beforeSubmitF
    //            ,afterSubmit: UploadImage
            } // add options
            , {
                closeOnEscape: true
                , delData: { azione: "crud", classe: "Intervento"}
            } // del options

            , {
                multipleSearch: true
                ,overlay:false
                , multipleGroup: false
                , onSearch: function() {
                    beforeJQGridSearch('#elencoInterventi');
                }

            }).data("modifichePrimaDellaRicerca", {
                modifiche: [ 
                    { nome: 'INT_PROG_DTA', tipo: "TIMESTAMP_SOLO_DATA_MYSQL" },
                ]
            });
            jQuery("#elencoInterventi").jqGrid('filterToolbar', { searchOnEnter: false,autosearch: true, beforeSearch: function() {
                beforeJQGridSearch('#elencoInterventi');
            }});    


       });
     </script>

{/block}
