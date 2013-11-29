var codaMessaggi=[];
var lockCodaMessaggi=false;

function processaMessaggioInCodaLock() {
    if (! lockCodaMessaggi) {
        lockCodaMessaggi=true;
        setTimeout(
            processaMessaggioInCoda
            ,1000
        );
    }
}
function processaMessaggioInCoda() {    
    lockCodaMessaggi=false;
    if (codaMessaggi.length>0) {
        
        var messaggio=codaMessaggi.pop();
        if (messaggio.tipo==="e") {
            alertErrore(messaggio.testo);
        } else if (messaggio.tipo==="ef") {
            alertErroreFisso(messaggio.testo);
        } else if (messaggio.tipo==="q") {
            fbLog("query",messaggio.testo);
        } else {
            alertSuccess(messaggio.testo);
        }
        
        if (codaMessaggi.length>0) {
            processaMessaggioInCodaLock();
        }
    }
    
    
}
function chiamaCodaMessaggi() {
     chiamataAjax({
        url: "eseguiAzione.php?v="+(new Date()).getTime()
        , type: "GET"
        , data: {
            azione: "getCodaMessaggi"                    
        }
        , onSuccess: function(res) {
            if (res.data) {
                codaMessaggi=res.data;
                processaMessaggioInCodaLock();                
            }
        },
        onError: function() { }
    });
}

function aggiungiMessaggio(testo,tipo) {
    codaMessaggi.push({ 
        testo: testo
        ,tipo:tipo
    });
 
    processaMessaggioInCodaLock();    
}