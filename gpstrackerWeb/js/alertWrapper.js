/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


// SUCCESSI
function alertSuccess(testo) {
    alertify.success(testo);
}

// ERRORI
function alertErrore(testo) {
    alertify.error(testo);
}

function alertErroreFisso(testo) {
    alertify.error(testo,0);
    fbLog("errore:",testo);
}


var alertDebugAbilitato=false;
function alertDebug(testo) {    
    
    if (alertDebugAbilitato) {    
        alertify.log(testo);
    }
}

function alertLog(testo) {
    alertify.log(testo);
}

