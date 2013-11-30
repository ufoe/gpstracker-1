
// **********************************
// CREAZIONE AUTOCOMPLETE
// **********************************
$.fn.generaAutoComplete = function(query, dest,callbackF,parametri) {
    return this.each(function() {
        $(this).autocomplete({
            source: "autocompletamento.php?query=" + query
            ,delay: 50
            , minLength: 0
            , select: function(event, ui) {
                if (dest !== null) {
                    dest.val(ui.item ? ui.item.id : "");
                }
            
            
                // usando questa riga faccio in modo che riempo subito la textbox
                // cosi' nella callback l'elemento ha gia' il valore giusto
                if (ui.item) {
                    $(this).val(ui.item.label);

                    if (ui.item.valori) {
                        $(this).data("oggetto",ui.item.valori);
                    } else {
                        $(this).data("oggetto",{ });
                    }
                    //fbLog(callbackF);
                    if ( callbackF !== undefined) {
                        callbackF(this,dest,ui.item ? ui.item.id : "");
                    }
                }
            },
            change: function(event, ui) {
                if (dest !== null) {
                     dest.val(ui.item ? ui.item.id : "");
                }
            
                if (ui.item) {
                    if (ui.item.valori) {
                        $(this).data("oggetto",ui.item.valori);
                    } else {
                        $(this).data("oggetto",{ id: ui.item.id });
                    }
                    if ( callbackF !== undefined) {
                        callbackF(this,dest,ui.item ? ui.item.id : "");
                    }
                }        
            }
            //, open: function(event, ui) {}
            ,autoFocus: true
        }).focus(function() {
            $(this).data("orival", $(this).val());
            if (dest !== null) {                
                dest.data("orival", dest.val());
            }
        }).bind('keypress', function(e) {
            if (e.keyCode === 27) {
                //fbLog("keypress",e);
                $(this).val($(this).data("orival"));
                if (dest !== null) {
                    $(dest).val(dest.data("orival"));
                }
            }
        }).bind('keydown', function(e) {            
            if (e.keyCode===40) {
                // down
                //fbLog("keydown",e);
                if ($(this).val()==="") {
                    $(this).autocomplete( "search", "");
                }
            }
        });
    
        parametri= parametri || {};
    
        $(this).data("parametri",parametri);
        $(this).data("query",query);                
    });
};

$.fn.autoCompleteId=function() {
    if ($(this).data("oggetto")) {
        return $(this).data("oggetto").id;
    }
    return "";
};

$.fn.autoCompleteSetId=function(id,label) {
    $(this).data("oggetto",{ id: id });
    
    if (label) {
        $(this).val(label);
    }
};

$.fn.autoCompleteSetOggettoIdLabel=function(oggetto,id,label) {
    oggetto["id"]=id;
    $(this).data("oggetto",oggetto);
    
    if (label) {
        $(this).val(label);
    }
};


$.fn.autoCompleteParametri = function(parametri) {
    return this.each(function() {
        var p=$(this).data("parametri");
        var np= $.extend(p, parametri); 
        
        $(this).data("parametri",np);
        
        var str = jQuery.param(np);
        
        if (str!=="") {
            str="&"+str;
        }
        
        $(this).autocomplete( "option", "source","autocompletamento.php?query=" + $(this).data("query")+str);
    });
};
