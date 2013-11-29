$(function() {
    $(".lara-content[titolo!='']").each(function () {
        if ($(this).attr("titolo")!=undefined) {
            $(this).prepend("<div class='lara-titolo'>"+$(this).attr("titolo")+"</div><div style='clear:both'></div>");
            $(this).css("margin-top", parseInt($(this).css("margin-top"))+10  );
            $(this).css("padding", "8px 4px 4px");
        }
    });

    $(".lara-content[barra!='']").each(function () {
        if ($(this).attr("barra")!=undefined) {
            $(this).prepend("<div class='ui-widget-header ui-corner-top'>"+$(this).attr("barra")+"</div>");
        }
    });

    $(".lara-content").addClass("ui-widget ui-widget-content");
    
});