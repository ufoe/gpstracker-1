<div data-role="popup" id="popupCA">
    <p><span></span><p>
</div>
{literal}
    <script>
        if (! mostraPopUpCA) {
            var mostraPopUpCA=function(testo) {
                //fbLog("mostraPopUpCA",testo);
                $( "#popupCA span" ).html( testo );                
                $( "#popupCA" ).popup( );
                $( "#popupCA" ).popup( "open" );
            }
        }
    </script>
{/literal}
