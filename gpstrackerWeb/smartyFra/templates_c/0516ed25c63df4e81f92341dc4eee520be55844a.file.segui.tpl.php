<?php /* Smarty version Smarty-3.1.12, created on 2013-11-30 11:16:00
         compiled from "smartyFra/templates/segui.tpl" */ ?>
<?php /*%%SmartyHeaderCode:65423221952946cb6a70098-95265202%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0516ed25c63df4e81f92341dc4eee520be55844a' => 
    array (
      0 => 'smartyFra/templates/segui.tpl',
      1 => 1385806557,
      2 => 'file',
    ),
    'c4fe4647eb994b98c8fe94b41be278b06f5f7032' => 
    array (
      0 => 'smartyFra/templates/layout.tpl',
      1 => 1381853121,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '65423221952946cb6a70098-95265202',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_52946cb6b801c8_58771893',
  'variables' => 
  array (
    'pulsantiera' => 0,
    'debug' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52946cb6b801c8_58771893')) {function content_52946cb6b801c8_58771893($_smarty_tpl) {?><!DOCTYPE html>
<html>
    <head>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">            
        <?php echo $_smarty_tpl->getSubTemplate ('javascript_css.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('min'=>''), 0);?>
                    
        <title>Sito</title>
    </head>
    <body>
        <div id="loader">CARICAMENTO IN CORSO ...</div>
        
        <?php if ((($tmp = @$_smarty_tpl->tpl_vars['pulsantiera']->value)===null||$tmp==='' ? '' : $tmp)==''){?>
            <?php echo $_smarty_tpl->getSubTemplate ('pulsantiera.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

        <?php }?>

        <div class="ui-layout-center" id="content" style="margin:5px;">
        

    <script src="js/distance.js"></script>
    
    <style>
        .smallmap {
            border: 1px solid #ccc;
            width: 100%
;            height: 100%;
        }
        
    </style>
    <script>
        
        
    OpenLayers.MyMarker = OpenLayers.Class(OpenLayers.Marker, {

           impianto: null,

           setImpianto: function(impianto) {
               this.impianto = impianto;
           },
           getImpianto: function() {
               return this.impianto;
           },

           getDivName: function() {
               return this.icon.imageDiv;
           },


           CLASS_NAME: "OpenLayers.MyMarker"
       });

        
        var layerImpiantiSize = new OpenLayers.Size(16,16);
        var layerImpiantiOffset = new OpenLayers.Pixel(-(layerImpiantiSize.w/2), -layerImpiantiSize.h);        
        function addMarker(lon,lat) {
            posIcon='img/expand-16x16.png';
            var icon = new OpenLayers.Icon(posIcon,layerImpiantiSize,layerImpiantiOffset);
            //marker = new OpenLayers.MyMarker(new OpenLayers.LonLat(<?php echo $_smarty_tpl->tpl_vars['point']->value->PNT_LON;?>
,<?php echo $_smarty_tpl->tpl_vars['point']->value->PNT_LAT;?>
).transform('EPSG:4326', 'EPSG:3857'),icon);
            marker = new OpenLayers.MyMarker(new OpenLayers.LonLat(lon,lat).transform('EPSG:4326', 'EPSG:3857'),icon);
            layerImpianti.addMarker(marker);
            //fbLog("marker",marker);
           
       }
        
        var minLon=999;
        var maxLon=0;
        var minLat=999;
        var maxLat=0;

        
        var map,marker,layerImpianti ;
        function init() {
            
            //map = new OpenLayers.Map("map");        
            
            layerImpianti = new OpenLayers.Layer.Markers( "Impianti");
            //var mapnik = new OpenLayers.Layer.OSM();
            //map.addLayer(mapnik);
            
            
            
             
            /*map = new OpenLayers.Map({
                div: "map", projection: "EPSG:3857",
                layers: [new OpenLayers.Layer.OSM(), layerImpianti]
                //,center: myLocation.getBounds().getCenterLonLat(), zoom: 15
            });*/
            //map.addControl(new OpenLayers.Control.LayerSwitcher());
           

            // The overlay layer for our marker, with a simple diamond as symbol
            /*var overlay = new OpenLayers.Layer.Vector('Overlay', {
                styleMap: new OpenLayers.StyleMap({
                    externalGraphic: 'js/openlayers/img/marker.png',
                    graphicWidth: 20, graphicHeight: 24, graphicYOffset: -24,
                    title: "CIAO"
                })
            });*/

            // The location of our marker and popup. We usually think in geographic
            // coordinates ('EPSG:4326'), but the map is projected ('EPSG:3857').
             


            addMarker(<?php echo $_smarty_tpl->tpl_vars['point']->value->PNT_LON;?>
,<?php echo $_smarty_tpl->tpl_vars['point']->value->PNT_LAT;?>
);

            //map.addLayer(layerImpianti);
            
            if (<?php echo $_smarty_tpl->tpl_vars['point']->value->PNT_LON;?>
<minLon) {
                minLon=<?php echo $_smarty_tpl->tpl_vars['point']->value->PNT_LON;?>
;
            }
            if (<?php echo $_smarty_tpl->tpl_vars['point']->value->PNT_LON;?>
>maxLon) {
                maxLon=<?php echo $_smarty_tpl->tpl_vars['point']->value->PNT_LON;?>
;
            }
            if (<?php echo $_smarty_tpl->tpl_vars['point']->value->PNT_LAT;?>
<minLat) {
                minLat=<?php echo $_smarty_tpl->tpl_vars['point']->value->PNT_LAT;?>
;
            }
            if (<?php echo $_smarty_tpl->tpl_vars['point']->value->PNT_LAT;?>
>maxLat) {
                maxLat=<?php echo $_smarty_tpl->tpl_vars['point']->value->PNT_LAT;?>
;
            }


            map = new OpenLayers.Map({
                div: "map", projection: "EPSG:3857",
                layers: [new OpenLayers.Layer.OSM(), layerImpianti ],
                //,center: new OpenLayers.LonLat((maxLon+minLon)/2, (maxLat+minLat)/2), zoom: 15
            });
            
            
            map.setCenter(new OpenLayers.LonLat((maxLon+minLon)/2, (maxLat+minLat)/2).transform( new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject()) , 13);
            

          
        
            
            // We add the marker with a tooltip text to the overlay
            /*overlay.addFeatures([
                new OpenLayers.Feature.Vector(myLocation, {tooltip: 'Fra'})
            ]);*/

            /*// A popup with some information about our location
            var popup = new OpenLayers.Popup.FramedCloud("Popup", 
                myLocation.getBounds().getCenterLonLat(), null,
                '<a target="_blank" href="http://openlayers.org/">We</a> ' +
                'could be here.<br>Or elsewhere.', null,
                true // <-- true if we want a close (X) button, false otherwise
            );*/

            // Finally we create the map
            /*map = new OpenLayers.Map({
                div: "map", projection: "EPSG:3857",
                layers: [new OpenLayers.Layer.OSM(), overlay],
                center: myLocation.getBounds().getCenterLonLat(), zoom: 15
            });*/
            // and add the popup to it.
            //map.addPopup(popup);
            
            
        }
        
         
        
    </script>    
    
    
    <div class="ui-layout-center" >
    <div id="interventi">          
        <div id="map" class="smallmap"></div>
          
        

    </div>
    </div>

    <div class="ui-layout-east" >
        <div id="bc"  style="padding: 1em;">
            <h3>Funzioni</h3>
                
            
                
        </div>
    </div>
    
    <script>
        $(function() {
            $('#content').layout({
                center: {
                    size: "auto"
                    , onresize: function(pname, pelement, pstate, poptions, lame) {
                        $(".smallmap").css( {
                            width: pstate.innerWidth-2,
                            height: pstate.innerHeight-2
                        });
                        
                        init();
                    }
                }
                ,east: {
                    size: "300"
                    //closable: false
                    //,resizable : false
                    //,slidable : false
                    //,spacing_open : -1
                }
            });

            
            
            
           setTimeout(aggiornaPosizione,5000 );

       });
       
       
       var lastPos=null;
        var aggiornaPosizione=function() {
            
            mvc(
                { PNT_AID: 'e9bbc191771fa0b9' }, 
                "segui"
                ,"dammiUltimo"
                ,function(res) {                     
                    var point=res.data.point;
                    
                    fbLog("point",point); 
                  
                    var consenso=(lastPos===null);
                    var newPos=new OpenLayers.LonLat(point.PNT_LON, point.PNT_LAT);
                    var newPosTrasform=new OpenLayers.LonLat(point.PNT_LON, point.PNT_LAT).transform( new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject());
                    if (lastPos!==null) {
                        
                        var distance=getDistanceFromLatLonInKm(newPos.lat,newPos.lon,lastPos.lat,lastPos.lon)*1000;
                        fbLog("distance",distance);
                        if (distance>10) {
                            fbLog("distance",distance);
                            consenso=true;
                        }                        
                    }
                  
                  if (consenso) {
                        map.setCenter(newPosTrasform , 13);

                        layerImpianti.removeMarker(marker);                    
                        addMarker(point.PNT_LON, point.PNT_LAT);
                        
                  }
                  
                  if (consenso || lastPos===null) {
                      lastPos=newPos;
                  }
                    
                    setTimeout(aggiornaPosizione,5000 );
                }
                ,function(res) { 
                    fbLog("res",res); 
                }
            );
           
            
        }
     </script>


        </div>
        
        <script>$(function() { 
            var myLayout=$('body').layout({
                north: {
                    closable: false
                    ,resizable : false
                    ,slidable : false
                    ,spacing_open : -1                    
                }
            });
            myLayout.allowOverflow('north'); 
            
            $(".laraCurrency").formattaInputTextComeCurrency();
            $(".laraDate").datepicker({ dateFormat: 'dd/mm/yy'});
            $(".selectText").each(
                function(i,elemento) {
                    $(elemento).generaAutoComplete( 
                        $(elemento).data("query") 
                        ,null
                        ,function (io,dest,valore) { 
                            executeFunctionByName($(elemento).data("callback"),window,io,dest,valore);
                            //$( "input#selectAllestimento" ).autoCompleteParametri( { all_vet_id: valore} );
                        }
                    );
                }
            );
            
            
            
            
            callLoader(); 
        });</script>        
    </body>
</html>
<?php if ((isset($_smarty_tpl->tpl_vars['debug']->value))){?><?php $_smarty_tpl->smarty->loadPlugin('Smarty_Internal_Debug'); Smarty_Internal_Debug::display_debug($_smarty_tpl); ?><?php }?>
<?php }} ?>