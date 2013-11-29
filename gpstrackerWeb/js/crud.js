function settati(myClasse,myid,callback) {
    chiamataAjax({
        url: "eseguiAzione.php"
        , type: "POST"
        , data: {
            azione: "crud", classe: myClasse, oper: ""
            , dati: {"id": myid}
        }
        , onSuccess: function(res) {
                fbLog("settati",res);
                callback(res.data);
        },
        onError: function() {

        }
    });    
}

function salva(myClasse,oggetto,callback) {
    chiamataAjax({
        url: "eseguiAzione.php"
        , type: "POST"
        , data: {
            azione: "crud", classe: myClasse, oper: "save"
            , dati: oggetto
        }
        , onSuccess: function(res) {
            fbLog("salva",res);
            if (callback) {
                callback(res.data);
            }
        },
        onError: function() {

        }
    });    
}


function cancella(myClasse,oggetto,callback,callBackError) {
    chiamataAjax({
        url: "eseguiAzione.php"
        , type: "POST"
        , data: {
            azione: "crud", classe: myClasse, oper: "del"
            , dati: oggetto
        }
        , onSuccess: function(res) {
            fbLog("del",res);
            if (callback) {
                callback(res.data);
            }
        },
        onError: function(res) {
            if (callBackError) {
                callBackError(res);
            }
        }
    });    
}


function creaJsonDaElementi(elementi) {
    var dati = {};
    elementi.each(function() {
        //fbLog("$(this)",$(this));
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
        } else {
            //fbLog("type",$(this).attr("type"));
            if ($(this).attr("type") === "checkbox") {
                if ($(this).prop("checked")) {
                    dati[$(this).attr("id")] = 1;//"t"
                } else {
                    dati[$(this).attr("id")] = 0;//"f"
                }

            } else {
                if ($(this).is('ol')) {
                    // OL
                    var elenco=$(this).find(".ui-selected").map(function() {return $(this).attr("id");}).toArray();
                    dati[$(this).attr("id")] =elenco;
                    
                } else {
                    if ($(this).attr("id")) {
                        dati[$(this).attr("id")] = $(this).val();
                    }
                }
                
            }
        }
    });
    return dati;
}

function creaChiamataSalvaF(elementi, nomeClasse, funzione) {
    var dati=creaJsonDaElementi(elementi);

    chiamataAjax({
        url: "eseguiAzione.php"
        , type: "POST"
        , data: {
            azione: "crud", classe: nomeClasse, oper: "save"
            , dati: dati
        }
        , onSuccess: function(res) {
            if (funzione) {
                funzione(res.data);
            }
        },
        onError: function() {

        }
    });
}




function mvc(dati, nomeClasse,azione, funzione,funzioneError) {

    chiamataAjax({
        url: "index.php?controller="+nomeClasse
        , type: "POST"
        , data: {
            a: azione
            , dati: dati
        }
        , onSuccess: function(res) {
            if (funzione) {
                funzione(res);
            }
        },
        onError: function(res) {
            if (funzioneError) {
                funzioneError(res);
            }
        }
    });
}

