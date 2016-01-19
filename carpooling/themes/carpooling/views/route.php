<script src="https://maps.googleapis.com/maps/api/js?sensor=true&libraries=places&language=en"></script>
<script type="text/javascript">
                    function zoomToStart(){
                        map.setCenter(new google.maps.LatLng(<?=$origin?>),16);
                        map.setZoom(17);
                        google.maps.event.trigger(new_marker[0], "click");
                    }
                    
                    function zoomToEnd(){
                        map.setCenter(new google.maps.LatLng(<?=$destination?>),16);    
                        map.setZoom(17);
                        google.maps.event.trigger(new_marker[<?=$last-1?>], "click");
                    }
                    
                    function zoomToRoute(){
                       initialize(map);
                    }
                    </script><span class="tabs" style="padding-top: 10px;display: block;"><a href="javascript:zoomToStart();">Start</a> | <a href="javascript:zoomToEnd();">End</a> | <a href="javascript:zoomToRoute();">Route</a></span><div id="map" style="width:615px; height: 360px; top: 20px;border: 4px solid #c2c2c2;border-radius: 5px;" ></div>
            <script type="text/javascript"> 
                var map;
                var bounds;
                var gdir;
                var gmarkers = [];
                var info_window;
                var i = 0;
                var point = "";
                var marker;
				var waypts = [];
                var side_bar_html = "";
                var new_marker = [];
                var polyline;
                var directionsDisplay;
                var directionsDisplayOptions = {};
				
		
					/*for(i = 0; i < routelatlong.length;i++){
						waypts.push({
						  location: new google.maps.LatLng(routelatlong[i]),
						  stopover:true});
					}*/
                directionsDisplayOptions.polylineOptions = {
                    strokeColor: '#196eee',
                    strokeWeight: 4,
                    strokeOpacity: 0.75
                };
                directionsDisplayOptions.suppressMarkers = true;
            
                // A function to create the marker and set up the event window
                function createMarker(point,name,html) {

                  var marker = new google.maps.Marker({
                    position: point
                  });
                  
                  // save the info we need to use later for the side_bar
                  gmarkers[i] = marker;
                  i++;
                  return marker;
                }

                function initialize() {
                    directionsDisplay = new google.maps.DirectionsRenderer();
                    var options = {
        disableDefaultUI: true,
        zoomControl: true,
        mapTypeControl: true,
        scrollwheel: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        styles: [
          { stylers: [{ saturation: -50 }] },
          {
            featureType: "administrative",
            elementType: "labels.text.fill",
            stylers: [{ "gamma": "0.83" }]
          }
        ]
    };
                    info_window = new google.maps.InfoWindow({max_width: 500});
                    map = new google.maps.Map(document.getElementById("map"), options);
                                    polyline = new google.maps.Polyline({
                    path: [],
                    strokeColor: '#196eee',
                    strokeWeight: 4,
                    strokeOpacity: 0.5
                });
                //alert(waypts);
                var bounds = new google.maps.LatLngBounds();
                gdir = new google.maps.DirectionsService(); 
                var request = { 
                    origin: new google.maps.LatLng(<?=$origin?>), 
                    destination: new google.maps.LatLng(<?=$destination?>), 
                    travelMode: google.maps.DirectionsTravelMode.DRIVING,
                    waypoints: [
					<?php /*$routelat = array(
					'12.2252841,79.0746957','12.9165167,79.13249859999996');*/
					if(!empty($route)){
					foreach($route as $routelat){	
					?>
					{location: new google.maps.LatLng(<?=$routelat?>)} <?=','?> //waypoints:waypts,
					<? } }?>
					],
                    durationInTraffic: false
                };
                
                gdir.route(request, function(result, status) { 
                    if (status == google.maps.DirectionsStatus.OK) {
                        directionsDisplay.setDirections(result);
                    }
                });

        var mfgIcon = new google.maps.Marker();
        var marker_icon = new google.maps.MarkerImage("<?php echo theme_img('map-marker-ico.png') ?>", new google.maps.Size(32, 43), new google.maps.Point(0, 0), new google.maps.Point(14, 43));
        var marker_shadow = new google.maps.MarkerImage("<?php echo theme_img('marker-shadow.png') ?>", new google.maps.Size(35, 25), new google.maps.Point(0, 0), new google.maps.Point(4, 28));
        new_marker = new_marker || [];
        mfgIcon.setIcon(marker_icon);
        mfgIcon.setShadow(marker_shadow);
		
		
		/*for(i = 0; i < latlong.length; i++){
			//alert(latlong[i]);*/
		<?php /*$latlong = array('13.081604,80.27518280000004',
					'12.2252841,79.0746957','12.9165167,79.13249859999996','12.9715987,77.59456269999998');
					*/$i=0;
					if(!empty($latlong)){
					foreach($latlong as $route1){	
					?>	
			new_marker[<?=$i?>] = new google.maps.Marker({
            map: map, 
            position: new google.maps.LatLng(<?=$route1?>),
            icon: marker_icon,
                    shadow: marker_shadow
        	});
			
			google.maps.event.addListener(new_marker[<?=$i?>], "click", function() {
                    info_window.setPosition(this.getPosition());
                    info_window.setContent('<b></b><br>The driver has not set a specific meeting point.<br />It is up to you to work out an appropriate meeting point.');
                    info_window.open(map);
              });
			  new_marker[<?=$i?>].setMap(map);
			
				<? $i++;	} }?>
		//}
        // 
         
                    
					;
					
					directionsDisplay.setMap(map);
                    directionsDisplay.setOptions(directionsDisplayOptions);
                }

                function setDirections(fromAddress, toAddress, locale) {
                  gdir.load("from: " + fromAddress + " to: " + toAddress, {"locale": locale });
                }
            
                function setWaypoints(fromAddress, toAddress, locale) {
                  gdir.load("from: " + fromAddress + " to: " + toAddress, {"locale": locale });
                }

                
            function handleErrors(){
                if (gdir.getStatus().code == G_GEO_UNKNOWN_ADDRESS)
                  alert("No corresponding geographic location could be found for one of the specified addresses. This may be due to the fact that the address is relatively new, or it may be incorrect.\nError code: " + gdir.getStatus().code);
                else if (gdir.getStatus().code == G_GEO_SERVER_ERROR)
                  alert("A geocoding or directions request could not be successfully processed, yet the exact reason for the failure is not known.\n Error code: " + gdir.getStatus().code);
                else if (gdir.getStatus().code == G_GEO_MISSING_QUERY)
                  alert("The HTTP q parameter was either missing or had no value. For geocoder requests, this means that an empty address was specified as input. For directions requests, this means that no query was specified in the input.\n Error code: " + gdir.getStatus().code);
                else if (gdir.getStatus().code == G_GEO_BAD_KEY)
                  alert("The given key is either invalid or does not match the domain for which it was given. \n Error code: " + gdir.getStatus().code);
                else if (gdir.getStatus().code == G_GEO_BAD_REQUEST)
                  alert("A directions request could not be successfully parsed.\n Error code: " + gdir.getStatus().code);
                else alert("An unknown error occurred.");
            }

            </script>
        
        <script type="text/javascript">
$(document).ready( function() {
 
    initialize();
  
});
</script>
