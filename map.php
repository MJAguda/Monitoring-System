<?php
	session_start();
	//return to login if not logged in
	//if (!isset($_SESSION['user']) ||(trim ($_SESSION['user']) == '')){
	//	header('location:index.php');
//}

//include_once('includes/User.php');

//$user = new User();

//fetch user data
//$sql = "SELECT * FROM account WHERE id = '".$_SESSION['user']."'";
//$row = $user->details($sql);

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <link rel="stylesheet" href="css/leaflet.css">
        <link rel="stylesheet" href="css/qgis2web.css"><link rel="stylesheet" href="css/fontawesome-all.min.css">
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body>
   	
        <div id="map"></div>
        <script src="js/qgis2web_expressions.js"></script>
        <script src="js/leaflet.js"></script>
        <script src="js/leaflet.rotatedMarker.js"></script>
        <script src="js/leaflet.pattern.js"></script>
        <script src="js/leaflet-hash.js"></script>
        <script src="js/Autolinker.min.js"></script>
        <script src="js/rbush.min.js"></script>
        <script src="js/labelgun.min.js"></script>
        <script src="js/labels.js"></script>
        <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.11.3.min.js"></script>
        <script>
            var highlightLayer;
            
            function highlightFeature(e) {
                highlightLayer = e.target;
                highlightLayer.openPopup();
            }
            
            var map = L.map('map', { zoomControl:true, maxZoom:28, minZoom:1 }).fitBounds([[17.60727275603069,121.73544645309428],[17.62152753617413,121.7619037628175]]);
            var hash = new L.Hash(map);
        
            map.attributionControl.setPrefix('<a href="https://github.com/tomchadwin/qgis2web" target="_blank">qgis2web</a> &middot; <a href="https://leafletjs.com" title="A JS library for interactive maps">Leaflet</a> &middot; <a href="https://qgis.org">QGIS</a>');
        
            var bounds_group = new L.featureGroup([]);
        
            function setBounds() {
            }
        
            var layer_OpenStreetMap_0 = L.tileLayer('http://a.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                opacity: 1.0,
                attribution: '',
                minZoom: 1,
                maxZoom: 28,
                minNativeZoom: 0,
                maxNativeZoom: 19
            });
            layer_OpenStreetMap_0;
            map.addLayer(layer_OpenStreetMap_0);
        
            var layer_satellite_1 = L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
                opacity: 1.0,
                attribution: '',
                minZoom: 1,
                maxZoom: 28,
                minNativeZoom: 0,
                maxNativeZoom: 40
            });
            layer_satellite_1;
            map.addLayer(layer_satellite_1);
        
            map.setView([17.6582443, 121.7269442],16); // Set View of Map upon refresh

            var z = 0;
            var location = {};
            var data1;
            var data2;
            window.setInterval(function() {

                ++z;

                $.getJSON("includes/coor.inc.php", function(data)
                {   
                    if (z == 1)
                    {   
                        for (var i = 0; i < data.length; i++) 
                        {
                            var stat = data[i].statCoordinates;

                            data1 = data.length;
                            
                            if(stat == 1){
                                location[i] = new L.marker([data[i].latCoordinates, data[i].longCoordinates]).addTo(map); //add marker    

                                var image = data[i].image_dir;
                                var id = data[i].didCoordinates;
                                var name = data[i].lnHolders + ", " + data[i].fnHolders + ", " + data[i].mnHolders;
                                var address = data[i].addHolders;
                                var cpnum = data[i].cnHolders;

                                var popupContent = '<img style="max-height:100px;max-width:100px; display: block; margin-left: auto; margin-right: auto;" src='+ image +'>';

                                //display popup upon click of the marker  
                                location[i].bindPopup(popupContent + "<ul style=''><li>ID: " + id + " </li><li>Name: " + name + " </li><li>Address: " + address + " </li><li>CP# : " + cpnum + " </li></ul>"); 
                            }
                        }  
                    }
                    else if (z > 1)
                    {   
                        data2 = data.length;
                        if(data1 != data2)
                        {
                            z = 0;

                            for (var j = 0; j < data1; j++) 
                            {
                                map.removeLayer(location[j]);
                                console.log("REMOVE");
                            } 
                        }
                        else
                        {
                            for (var j = 0; j < data.length; j++) 
                            {
                                var stat = data[j].statHolders;

                                if(stat == 1){
                                    location[j].setLatLng([data[j].latHolders, data[j].longHolders]). update(); //update marker    
                                }    
                            }  
                        }
                    }
                });


            },1000);

            window.stop()
            setBounds();
        </script>
    </body>
</html>
