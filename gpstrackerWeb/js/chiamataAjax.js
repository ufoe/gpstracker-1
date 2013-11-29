
// USAGES:
//chiamataAjax({
//    url:"destPage.php"
//    ,type:"GET" // or POST
//    ,dataType:"json" // txt or html
//    ,data:{some:"data I want"}
//    ,onSu: function (res) {}
//    ,onErr: function (res) {}
//    //,controlla:true
//});


function ca(opzioni) {
        this.url=opzioni.url;
        this.data=null;
        this.type="GET";
        this.dataType="json";
        
        this.controlla=null;
        this.raw=false;
        
        this.onSu=function(res) {};
        this.onErr=function(request,error){
            if (error === "timeout") {
               alert("The request timed out, please resubmit");
            } else {
               alert("ERROR: " + error);
            }            
        };
        
        this.c=this;
        
        this.start=function() {
            var myClass = this;

            $.ajax({
                url: myClass.url,
                type: myClass.type,
                dataType: myClass.dataType,
                data: myClass.data,
                timeout: 600000,
                error: function(request,error){
                    if (myClass.onErr!==undefined) {
                        myClass.onErr(request,error);
                    }
                },
                success: function(res){
                    // chiamata a buon fine
                    if (myClass.raw) {
                        myClass.onSu(res);
                        return;
                    }
                    
                    if (res.success) {
                        if (myClass.onSu!==undefined) {
                            myClass.onSu(res);
                        }
                    } else {                        
                        if (myClass.onErr!==undefined) {
                            var errore_="Errore sconosciuto";
                            if (res.error) { 
                                errore_=res.error;
                            } else if (res.messaggio) {
                                errore_=res.messaggio;
                            }
                            myClass.onErr(res,errore_);
                        }
                    }
                }
                

            });            
            
            
            
          
          
          



            this.controlloSchedulato = function(primo) {
                if (primo) {
                    var t_=myClass;
                    this.Timer= window.setTimeout(
                        function() {
                            t_.controlloSchedulato(false);
                        }
                        , 5000
                    );
                } else {
                    $.ajax({
                        url: "getStatoOperazioneInCorso.php?lavId="+myClass.controlla.lavId,
                        type: "GET",
                        dataType: 'json',
                        //data: myClass.controlla.lavId,
                        timeout: 600000,
                        error: function(request,error){

                        },
                        success: function(res){
                            // chiamata a buon fine
                            rescf=myClass.controlla.controllaFunction(res);
                            if (rescf) {                            
                                var t_=myClass;
                                this.Timer= window.setTimeout(
                                    function() {
                                        t_.controlloSchedulato(false);
                                    }
                                    ,3000
                                );
                            }

                        }
                    });                        
                }
            };
        

            if (myClass.controlla!==null) {
                myClass.controlloSchedulato(true);
            }

        
          
        };
    }

    function chiamataAjax(opzioni) {
        chiam=new ca(opzioni);
        chiam["data"]=opzioni.data;
        if (opzioni.onSuccess!==undefined) {
            chiam["onSu"]=opzioni.onSuccess;
        }        
        if (opzioni.raw!==undefined) {
            chiam["raw"]=opzioni.raw;
        }        
        
        if (opzioni.onError!==undefined) {
            chiam["onErr"]=opzioni.onError;
        }

        if (opzioni.type!==undefined) {
            chiam["type"]=opzioni.type;
        }        
        if (opzioni.dataType!==undefined) {
            chiam["dataType"]=opzioni.dataType;
        }        
        
        

        if (opzioni.controlla!==undefined) {
            chiam["controlla"]=opzioni.controlla;
            
            if (opzioni.data) {
                if (opzioni.controlla.lavId) {
                    opzioni.data.lavId=opzioni.controlla.lavId;
                }
            }
            
        }


        chiam.start();
    }




function eseguiAzione(theForm,callbackf) {
    //fbLog("chiamante",this);
        $.mobile.loading( 'show', {
                text: 'attendere',
                textVisible: true,
                theme: 'z',
                html: ""
        });
        
        
        
        var serialized=theForm.serialize();

          chiamataAjax({
            url:"eseguiAzione.php"
            ,type:"POST" // or POST
            ,dataType:"json" // text or html
            ,data:serialized
            ,onSuccess: function (res) {
                //fbLog("onSu",res);
                 $.mobile.loading( 'hide');
                 
                if (res.messaggio) {
                    if (res.messaggio!=="") {
                        if (mostraPopUpCA) {
                            mostraPopUpCA(res.messaggio);
                        }
                        
                        if (theForm.hasClass("autoClear")) {
                            theForm.find("input, select, textarea, checkbox").each(
                                function(index,elemento){
                                    //access to form element via $(this)
                                    //fbLog("elemento",$(elemento));
                                    if ($(elemento).hasClass("autoClear")) {
                                        if ($(elemento).is('textarea')) {
                                            $(elemento).val("");
                                        }
                                        if ($(elemento).is('input:text')) {
                                            $(elemento).val("");
                                        }
                                        if ($(elemento).is('input:checkbox')) {
                                            $(elemento).attr("checked",false).checkboxradio("refresh");
                                        }
                                        if ($(elemento).is('select')) {
                                            //$(elemento).find("option").each(function(i,v) {$(this).attr('selected', false);})
                                            $(elemento).find("option").filter(function() {
                                                return $(this).text() === "";
                                            }).attr('selected', true);
                                            $(elemento).selectmenu("refresh");
                                        }
                                    }
                                }
                            );
                            
                        }
                        
                            if (typeof(callbackf) === "function") {
                                callbackf.apply(theForm);
                            }
                        
                    }
                }
                
            }
            ,onError: function (res) {
                fbLog("onErr",res);
                $.mobile.loading( 'hide');
            }
            //,controlla:true
        });
        
}


$(document).ready(function() {
    $("form.autoSubmit").submit(function(event) {
        event.preventDefault();
        
        var theForm=$(this);
        eseguiAzione(theForm,null);
        
        return false;
      });
});
