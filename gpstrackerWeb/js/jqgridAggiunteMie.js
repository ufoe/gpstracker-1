var beforeJQGridSearch = function(nomeTabella) {
    var i, l, rules, rule, $grid = $(nomeTabella), postData = $grid.jqGrid('getGridParam', 'postData');

    var mods = $grid.data("modifichePrimaDellaRicerca");

    if (postData.filters) {
        var filters = $.parseJSON(postData.filters);
        if (filters && typeof filters.rules !== 'undefined' && filters.rules.length > 0) {
            rules = filters.rules;
            for (i = 0; i < rules.length; i++) {
                rule = rules[i];


                if (mods) {
                    for (var m = 0; m < mods["modifiche"].length; m++) {
                        var modifica = mods["modifiche"][m];
                        if (modifica["nome"] === rule.field) {
                            rule.data = modifica.tipo + rule.data;
                        }
                    }
                }
            }

            postData.filters = JSON.stringify(filters);
        }

    } else {
        // ricerca da toolbar
        for (key in postData) {
            if (mods) {
                for (var m = 0; m < mods["modifiche"].length; m++) {
                    var modifica = mods["modifiche"][m];
                    if (modifica["nome"] === key) {
                        postData[key] = modifica.tipo + postData[key];
                    }
                }
            }

        }

    }

};


var jqgridSearchoptions = {
    dataInit: function(el) {
        $(el).datepicker({
            showButtonPanel: true
            , dateFormat: 'dd/mm/yy'
            //,onSelect: function(dateText, inst){ //$("#grid_id")[0].triggerToolbar();}
        });
    }
    , attr: {title: 'Seleziona una data'}
};

var customJQGridFatte = {};
var customJQGrid = function(grigliaid, parameters) {

    if (!customJQGridFatte[grigliaid]) {
        if (parameters == undefined) {
            parameters = {};
        }

        var griglia = jQuery(grigliaid);
        var pager = griglia.jqGrid('getGridParam', 'pager');
        //fbLog("pager",pager);

        griglia.jqGrid('navGrid', pager).jqGrid('navButtonAdd', pager, {
             caption: ""
             ,title: "salva in csv"
            , buttonicon: "ui-icon-disk"
            , onClickButton: function() {
                var url=griglia.jqGrid('getGridParam', 'url');

                var cn=griglia.jqGrid('getGridParam', 'colModel');
                var cn2 = cn.slice(0);
                if (cn2.length>1) {
                    cn2.shift();
                }
                
                
                
                //var cn2 = cn.slice(0);
                var cn3 = [];
                for (t=0;t<cn2.length;t++) {
                    cn3.push(cn2[t]["name"]);
                }
                
                
                if (url!="") {
                    chiamataAjax({
                        url: url
                        , type: "POST"
                        , data: {tipoRisultato: "download", fileName: "ddddd.csv",tipoDati:"csv",nomiColonne:cn3}
                        //,dataType:"text"
                        //,data: {template: "beanSpedizione.tpl",cdtab: codice}
                        , onSuccess: function(res) {
                            fbLog("res",res);
                            window.open("downloadFile.php?file=ddddd.csv",'_blank');

                        },
                        onError: function() {

                        }
                    });
                } else {
                    // devo mandare su anche i dati
                    
                }
            }
        });


        if (parameters["colonneVisibili"]) {

            griglia.jqGrid('navGrid', pager).jqGrid('navButtonAdd', pager, {
                caption: ""
                , buttonicon: "ui-icon-gear"
                , onClickButton: function() {
                    griglia.jqGrid("columnChooser", {
                        done: function(perm) {
                            if (perm) {
                                // "OK" button are clicked
                                this.jqGrid("remapColumns", perm, true);
                                // the grid width is probably changed co we can get new width
                                // and adjust the width of other elements on the page
                                //var gwdth = this.jqGrid("getGridParam","width");
                                //this.jqGrid("setGridWidth",gwdth);


                                var cv = this.jqGrid('getGridParam', 'colModel');
                                fbLog("cv", cv);

                                var dati = {
                                    tabella: parameters["tabella"]
                                    , OPE_ID: parameters["OPE_ID"]
                                    , colonne: cv
                                };

                                chiamataAjax({
                                    url: "eseguiAzione.php"
                                    , type: "POST"
                                    , data: {azione: "classe", classe: "ColonneVisibili", "dati": dati}
                                    //,dataType:"text"
                                    //,data: {template: "beanSpedizione.tpl",cdtab: codice}
                                    , onSuccess: function(res) {
                                        //$(".beanAnagrafica").html(res);			

                                    },
                                    onError: function() {

                                    }
                                });

                            } else {
                                // we can do some action in case of "Cancel" button clicked
                            }
                        }
                    });
                }
                , position: "last"
            });
        }

        customJQGridFatte[grigliaid] = 1;
    }

};
//$("#a1").jqGrid('getGridParam','colModel');


function aggiustaAltezzaJQGrid(id, altezza) {
    var h1 = $("#gbox_" + id + " .ui-jqgrid-titlebar").outerHeight();
    var h2 = $("#gbox_" + id + " .ui-jqgrid-hbox").outerHeight();
    var h3 = $("#gbox_" + id + " #" + id + "_pager").outerHeight();

//    fbLog("altezza",altezza);
//    fbLog("h title",h1);
//    fbLog("h hbox",h2);
//    fbLog("h pager",h3);

    jQuery("#" + id).jqGrid(
            'setGridHeight'
            , altezza - (5 + h1 + h2 + h3)
            );

}

function checkboxFormatter(cval, opts, rowObj) {
    cval = cval + "";
    cval = cval.toLowerCase();
    var bchk = cval.search(/(false|0|no|off|n|f)/i) < 0 ? "checked=\"checked\"" : "";
    //onclick=\"ajaxSaveParent('" + opts.rowId + "', this);\"  
    return "<input type='checkbox' " + bchk + " value='" + cval + "' offval='0' onval='1' />";
}


function creaChiamataSalva(id,elementi, nomeClasse, tabellaDaAggiornare,elementoConId,callBackOnSuccess) {
    var oper = "edit";
    
    if (id===null || id==="" || id===0) {
        oper="add";
    }
    
    var dati = {};
    elementi.each(function() {
        fbLog("$(this)",$(this));
        if ($(this).attr("type") === "password") {
            if (
                   ($(this).val().length !== 32) 
                && ($(this).val() !== "******")
            ) {
                fbLog(
                    "converto password: "+$(this).val()
                    ,MD5($(this).val())
                );
                    
                dati[$(this).attr("id")] = MD5($(this).val());
            }
        } else if ($(this).attr("type") === "checkbox") {
            if ($(this).prop("checked")) {
                dati[$(this).attr("id")] = 1;//"t"
            } else {
                dati[$(this).attr("id")] = 0;//"f"
            }

        } else if ($(this).is('ol')) {
            // OL
            var elenco=$(this).find(".ui-selected").map(function() {return $(this).attr("id");}).toArray();
            dati[$(this).attr("id")] =elenco;

            if (elenco.length>0) {
                if ($(this).hasClass("singoloSelect")) {
                    dati[$(this).attr("id")] =  $(this).find(".ui-selected").data("chiave");
                }

            }

        } else if ($(this).hasClass('selectText')) {
            dati[$(this).attr("id")] = $(this).autoCompleteId();
        } else {
            if ($(this).attr("id")) {
                dati[$(this).attr("id")] = $(this).val();
            }
        }
    });

    chiamataAjax({
        url: "eseguiAzione.php"
        , type: "POST"
        , data: {
            azione: "crud", classe: nomeClasse, oper: oper
            , dati: dati
        }
        , onSuccess: function(res) {
            if (tabellaDaAggiornare) {
                if (elementoConId) {
                    elementoConId.attr('value',res.data["_id"]);
                }
                tabellaDaAggiornare.trigger("reloadGrid");
                
                if (callBackOnSuccess) {
                    callBackOnSuccess(res.data);                    
                }
            }

        },
        onError: function() {

        }
    });
}

function creaChiamataDel(id, nomeClasse, tabellaDaAggiornare) {
    var oper = "del";
    var dati = {};
    
    chiamataAjax({
        url: "eseguiAzione.php"
        , type: "POST"
        , data: {
            azione: "crud", classe: nomeClasse, oper: oper
            , dati: dati,id:id
        }
        , onSuccess: function(res) {
            if (tabellaDaAggiornare) {
                tabellaDaAggiornare.trigger("reloadGrid");
            }

        },
        onError: function() {

        }
    });
}


function sistemaTrueFalsePerPG(dati) {
    dati.forEach(function(entry) {
        for (var key in entry) {
            if (entry[key]===0) {entry[key]=0;}//"f"
            if (entry[key]===1) {entry[key]=1;}//"t"
        }                            
    });
}


function trueOrfalse(valore) {
    if (valore===undefined) {
        return false;
    }
    if (valore===null) {
        return false;
    }
    if (valore==="f") {
        return false;
    }
    if (valore==="F") {
        return false;
    }
    if (valore==="n") {
        return false;
    }
    if (valore==="N") {
        return false;
    }
    if (valore==="no") {
        return false;
    }
    if (valore==="NO") {
        return false;
    }
    if (valore==="No") {
        return false;
    }
    if (valore==="") {
        return false;
    }
    if (valore==="0") {
        return false;
    }
    if (valore===0) {
        return false;
    }
    if (valore==="false") {
        return false;
    }
    if (valore===false) {
        return false;
    }
    
    return true;
}



function getGridRowHeight (targetGrid) {
    var height = null; // Default

    try{
        height = jQuery(targetGrid).find('tbody').find('tr:first').outerHeight();
    }
    catch(e){
     //catch and just suppress error
    }

    return height;
}

function scrollToRow (targetGrid, id) {
    var rowHeight = getGridRowHeight(targetGrid) || 23; // Default height
    var index = jQuery(targetGrid).getInd(id);
    jQuery(targetGrid).closest(".ui-jqgrid-bdiv").scrollTop(rowHeight * index);
}


var lastsel2={};
function editaRiga(id,tabella,parametriExtra,afterSaveFunc) {
    
    if (! parametriExtra) {
        parametriExtra=null;
    }
    if (! afterSaveFunc) {
        afterSaveFunc=null;
    }
    
    
    
    fbLog("tabella",tabella);
    
    
    if(id ){//&& id!==lastsel2
        
        if (! lastsel2[tabella.attr("id")]) {
            lastsel2[tabella.attr("id")]=-1;
        }
        
        if (lastsel2[tabella.attr("id")]!=-1) {
            // salvo i contenuti                        
            tabella.jqGrid('saveRow',lastsel2[tabella.attr("id")], false,'clientArray');
            //jQuery(this).restoreRow(lastsel2);
        }

        tabella.editRow(
            id,
            true,
            null,
            null,
            null,//'clientArray',
            parametriExtra,
            afterSaveFunc
        );

        //constrainInput: false, showOn: 'button', buttonText: '...' });

        
        lastsel2[tabella.attr("id")]=id;
    }
}
