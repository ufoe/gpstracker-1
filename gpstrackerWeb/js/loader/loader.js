/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function callLoader() {
    $("#loader").animate(
        { "color":"#008000","font-size":"8"},100
    ).fadeOut(
        "fast"
    ).html(
        "..."
    ).animate(
        { "font-size":"48" },100,"swing"
        ,function() {
           chiamaCodaMessaggi();
        }

    );

    
    $(window).unload(function() {
        //$("#loader").css("display","");
    });
}
