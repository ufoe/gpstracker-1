{extends file="layout.tpl"}
{block name=body}

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
            //marker = new OpenLayers.MyMarker(new OpenLayers.LonLat({$point->PNT_LON},{$point->PNT_LAT}).transform('EPSG:4326', 'EPSG:3857'),icon);
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
            {literal}
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
            {/literal} 


            addMarker({$point->PNT_LON},{$point->PNT_LAT});

            //map.addLayer(layerImpianti);
            
            if ({$point->PNT_LON}<minLon) {
                minLon={$point->PNT_LON};
            }
            if ({$point->PNT_LON}>maxLon) {
                maxLon={$point->PNT_LON};
            }
            if ({$point->PNT_LAT}<minLat) {
                minLat={$point->PNT_LAT};
            }
            if ({$point->PNT_LAT}>maxLat) {
                maxLat={$point->PNT_LAT};
            }


            map = new OpenLayers.Map({
                div: "map", projection: "EPSG:3857",
                layers: [new OpenLayers.Layer.OSM(), layerImpianti ],
                //,center: new OpenLayers.LonLat((maxLon+minLon)/2, (maxLat+minLat)/2), zoom: 15
            });
            
            
            map.setCenter(new OpenLayers.LonLat((maxLon+minLon)/2, (maxLat+minLat)/2).transform( new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject()) , 13);
            

          {*  var myLocation = new OpenLayers.Geometry.Point( {$point->PNT_LON}, {$point->PNT_LAT})
                    .transform('EPSG:4326', 'EPSG:3857')
            ;*}
        
            {literal}
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
        
         
        {/literal}
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

{/block}
