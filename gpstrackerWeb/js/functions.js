/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


function fbLog(messaggio, oggetto) {
    try {
        console.debug(messaggio, oggetto);
    }
    catch (e) {
    }
    finally {
        return;
    }
}


// salta sul prossimo elemento
$.fn.focusNextInputField = function() {
    return this.each(function() {
        var fields = $(this).parents('form:eq(0),body').find('button,input,textarea,select');
        var index = fields.index(this);
        if (index > -1 && (index + 1) < fields.length) {
            fields.eq(index + 1).focus();
        }
        return false;
    });
};


//variabile.formatMoney(numero_decimali,carattere_separatore_decimale,carattere_separator_emigliaia)
Number.prototype.formatMoney = function(c, d, t) {
    var n = this, c = isNaN(c = Math.abs(c)) ? 2 : c, d = d === undefined ? "," : d, t = t === undefined ? "." : t, s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

function daStringAFloat(valore) {
    if ($.isNumeric(valore)) {
        return parseFLoat(valore);
    }

    return 0.0;
}


var opzioniFormattazioniCurrency={
    colorize: true
    , negativeFormat: '-%s%n'
    , roundToDecimalPlace: 2
    , decimalSymbol: '.'
    , digitGroupSymbol: "'"
    , symbol: "€ "
};

$.fn.formattaInputTextComeCurrency = function() {
    return this.each(function() {

        var fo = function() {
            $(this).html(null);
            $(this).formatCurrency(opzioniFormattazioniCurrency);

            valore = $(this).asNumber();
            if (valore < 0) {
                $(this).val(0);
                fo();
            }

        };
        
        $(this).formatCurrency(opzioniFormattazioniCurrency);

        $(this)
                .blur(fo)
                .keyup(function(e) {
            var e = window.event || e;
            var keyUnicode = e.charCode || e.keyCode;
            if (e !== undefined) {
                switch (keyUnicode) {
                    case 16:
                        break; // Shift
                    case 17:
                        break; // Ctrl
                    case 18:
                        break; // Alt
                    case 27:
                        this.value = '';
                        break; // Esc: clear entry
                    case 35:
                        break; // End
                    case 36:
                        break; // Home
                    case 37:
                        break; // cursor left
                    case 38:
                        break; // cursor up
                    case 39:
                        break; // cursor right
                    case 40:
                        break; // cursor down
                    case 78:
                        break; // N (Opera 9.63+ maps the "." from the number key section to the "N" key too!) (See: http://unixpapa.com/js/key.html search for ". Del")
                    case 110:
                        break; // . number block (Opera 9.63+ maps the "." from the number block to the "N" key (78) !!!)
                    case 190:
                        break; // .
                    default:
                        $(this).formatCurrency({
                            colorize: true
                            , negativeFormat: '-%s%n'
                            , roundToDecimalPlace: -1
                            , eventOnDecimalsEntered: true
                            , decimalSymbol: '.'
                            , digitGroupSymbol: "'"
                            , symbol: "€ "

                        });
                }
            }
        })
                .bind('decimalsEntered', function(e, cents) {
            if (String(cents).length > 2) {
                var errorMsg = 'Per favore non inserire millesimi (0.' + cents + ')';
                $(this).html(errorMsg);
            }
        }).focus(function() {            
            $(this).select();
        }).mouseup(function(e){
            e.preventDefault();
        });
    });
};


$.fn.selectRange = function(start, end) {
    if(!end) end = start; 
    return this.each(function() {
        if (this.setSelectionRange) {
            this.focus();
            this.setSelectionRange(start, end);
        } else if (this.createTextRange) {
            var range = this.createTextRange();
            range.collapse(true);
            range.moveEnd('character', end);
            range.moveStart('character', start);
            range.select();
        }
    });
};

var opzioniFormattazioniPercentuale={
    colorize: true
    , positiveFormat: '%n%s'
    , negativeFormat: '-%n%s'
    , roundToDecimalPlace: 2
    , decimalSymbol: '.'
    , digitGroupSymbol: "'"
    , symbol: " %"
};

$.fn.formattaInputTextComePercentuale = function() {
    return this.each(function() {

        var fo = function() {
            $(this).html(null);
            $(this).formatCurrency(opzioniFormattazioniPercentuale);

            valore = $(this).asNumber();
            if (valore < 0) {
                $(this).val(0);
                fo();
            }

        };
        
        $(this).formatCurrency(opzioniFormattazioniPercentuale);

        $(this)
                .blur(fo)
                .keyup(function(e) {
            var e = window.event || e;
            var keyUnicode = e.charCode || e.keyCode;
            if (e !== undefined) {
                switch (keyUnicode) {
                    case 16:
                        break; // Shift
                    case 17:
                        break; // Ctrl
                    case 18:
                        break; // Alt
                    case 27:
                        this.value = '';
                        break; // Esc: clear entry
                    case 35:
                        break; // End
                    case 36:
                        break; // Home
                    case 37:
                        break; // cursor left
                    case 38:
                        break; // cursor up
                    case 39:
                        break; // cursor right
                    case 40:
                        break; // cursor down
                    case 78:
                        break; // N (Opera 9.63+ maps the "." from the number key section to the "N" key too!) (See: http://unixpapa.com/js/key.html search for ". Del")
                    case 110:
                        break; // . number block (Opera 9.63+ maps the "." from the number block to the "N" key (78) !!!)
                    case 190:
                        break; // .
                    default:
                        $(this).formatCurrency({
                            colorize: true
                            , positiveFormat: '%n%s'
                            , negativeFormat: '-%n%s'
                            , roundToDecimalPlace: -1
                            , eventOnDecimalsEntered: true
                            , decimalSymbol: '.'
                            , digitGroupSymbol: "'"
                            , symbol: " %"

                        }).selectRange($(this).val().length-2);
                }
            }
        })
                .bind('decimalsEntered', function(e, cents) {
            if (String(cents).length > 2) {
                var errorMsg = 'Per favore non inserire millesimi (0.' + cents + ')';
                $(this).html(errorMsg);
            }
        }).focus(function() {
            $(this).select();
        }).mouseup(function(e){
            e.preventDefault();
        });
    });
};



function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
    var regexS = "[\\?&]" + name + "=([^&#]*)";
    var regex = new RegExp(regexS);
    var results = regex.exec(window.location.search);
    if (results === null)
        return "";
    else
        var res = decodeURIComponent(results[1].replace(/\+/g, " "));
    return res;
}


function jqgrid_stringToDate(cellvalue, options, rowObject) {
    if (cellvalue !== "") {
        return cellvalue.substr(6, 2) + "/" + cellvalue.substr(4, 2) + "/" + cellvalue.substr(0, 4);
    }
    return "";

}

Date.prototype.getWeek = function() {
    var onejan = new Date(this.getFullYear(),0,1);
    return Math.ceil((((this - onejan) / 86400000) + onejan.getDay()+1)/7);
} 


function executeFunctionByName(functionName, context /*, args */) {
    var args = Array.prototype.slice.call(arguments, 2);
    if (functionName !== undefined) {
        var namespaces = functionName.split(".");
        var func = namespaces.pop();
        for (var i = 0; i < namespaces.length; i++) {
            context = context[namespaces[i]];
        }
        return context[func].apply(context, args);
    }
    
};



function isFunction(possibleFunction) {
  return (typeof(possibleFunction) === typeof(Function));
}


$.fn.delay = function(time, callback){
    // Empty function:
    jQuery.fx.step.delay = function(){};
    // Return meaningless animation, (will be added to queue)
    return this.animate({delay:1}, time, callback);
};


if (typeof String.prototype.startsWith !== 'function') {
  // see below for better implementation!
  String.prototype.startsWith = function (str){
    return this.indexOf(str) === 0;
  };
}


function apriConParametri(parametri) {
  location.href= jQuery.param.querystring(window.location.href, parametri)
}
function apriNuovaFinestraConParametri(parametri) {
  window.open(jQuery.param.querystring(window.location.href, parametri),"_blank");
    
}

function setVariabileDiSessione(name,value,callback) {
    chiamataAjax({
        url: "eseguiAzione.php"
        , type: "POST"
        , data: {
            azione: "setVariabileDiSessione", name : name, value: value
        }
        , onSuccess: function(res) {
            if (callback) {
                callback(res);
            }
        },
        onError: function() { }
    });
}

(function ( $ ) {
    $.fn.checkboxValue= function() {
        if (this.is(":checked")) {
            return 1;
        }
        
        return 0;
    };
}( jQuery ));
