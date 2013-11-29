function creaButtonSetDaElemento(sottoDiMe) {
    sottoDiMe.find(".mc").each(function() {
        var icona="";
        if ($(this).data("icona")) {
            icona=$(this).data("icona");
        }
        
        if ($(this).data("tv")===undefined) {
            $(this).data("tv",true);
        }
        
        var tv=trueOrfalse($(this).data("tv"));

        $(this).button({            
            icons: {                
                primary: icona
            },
            text: tv
        });
    });          
}
function creaButtonSet() {
    creaButtonSetDaElemento($(".pulsantiera"));
}



var lastMenu=null;
function creaMenu(menuDaCreare,sottoDi) {
    
    if (lastMenu!=menuDaCreare) {

        $(".menuFra").fadeOut("fast").removeClass("menuFra");// faccio sparire altri

        if ($("#"+menuDaCreare).data("posizionato")===undefined) {
            $("#"+menuDaCreare ).position({
                my:        "left top",
                at:        "left bottom",
                of:        $(sottoDi),
                collision: "fit"
            }).fadeIn("fast");
            $("#"+menuDaCreare).data("posizionato","ok");
            $("#"+menuDaCreare ).menu({  }).mouseleave(function() { 
                fbLog("spengo",lastMenu);
                $(this).delay(100).fadeOut("fast");
                lastMenu=null;
            });
        }
        
        $("#"+menuDaCreare ).menu({  }).fadeIn("fast").addClass("menuFra");
        lastMenu=menuDaCreare;
    }
}

$(function() {
    creaButtonSet();        
});
