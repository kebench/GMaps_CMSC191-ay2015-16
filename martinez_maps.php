<!DOCTYPE html>
<html>
<head>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAumhPNPmDt0XyO_nRZ_809Q9CK60qdhy8"></script>
<script>
var myUPLB=new google.maps.LatLng(14.167525, 121.243368);
var infoWindow = new google.maps.InfoWindow;
var customIcons = {
     'Auditorium': {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_blue.png'
      },
      'Mall': {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png'
      },
      'Restaurant': {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_green.png'
      },
      'Inn': {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_yellow.png'
      },
      'Bank': {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_orange.png'
      },
      'Municipal Hall': {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_purple.png'
      },
      'Resort': {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_black.png'
      },
      'Amusement Park': {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_brown.png'
      }
    };
function initialize()
{
var mapProp = {
  center:myUPLB,
  zoom: 13,
  mapTypeId:google.maps.MapTypeId.ROADMAP
  };

var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

downloadUrl( "php_xml.php", function(data){
	var malls = [];
	var xml = data.responseXML;
	var markers = xml.documentElement.getElementsByTagName("marker");
	for (var i = 0; i < markers.length; i++) {
		var name = markers[i].getAttribute("name");
		var address = markers[i].getAttribute("address");
		var type = markers[i].getAttribute("type");
		var point = new google.maps.LatLng(
			parseFloat(markers[i].getAttribute("lat")),
			parseFloat(markers[i].getAttribute("lng")));
		var html = "<b>" + name + "</b> <br/>" + address;
		
		console.log( customIcons[type] );
		
		
		if( type == "Mall" )
			malls.push(point);
		
		if( name == "SM City Calamba" ){
		var cityCircle = new google.maps.Circle({
			strokeColor: '#FF0000',
			strokeOpacity: 0.8,
			strokeWeight: 2,
			fillColor: '#FF0000',
			fillOpacity: 0.35,
			map: map,
			center: point,
			radius: 250
		});
		}
		
		var icon = customIcons[type] || {};
		
		var marker = new google.maps.Marker({
		map: map,
		position: point,
		icon: icon.icon
		});
	
    bindInfoWindow(marker, map, infoWindow, html);
	//marker.setMap( map );
  }
  
  var mallPath = new google.maps.Polyline({
	path: malls,
	geodesic: true,
	strokeColor: '#FF0000',
	strokeOpacity: 1.0,
	strokeWeight: 2
	});
	
	mallPath.setMap( map );
}); 

function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
}

/*
var marker=new google.maps.Marker({
  position:myUPLB,
  });

marker.setMap(map);*/
}
function downloadUrl(url,callback) {
 var request = window.ActiveXObject ?
     new ActiveXObject('Microsoft.XMLHTTP') :
     new XMLHttpRequest;

 request.onreadystatechange = function() {
   if (request.readyState == 4) {
     request.onreadystatechange = doNothing;
     callback(request, request.status);
   }
 };

 request.open('GET', url, true);
 request.send(null);
}

function doNothing(){}

google.maps.event.addDomListener(window, 'load', initialize);
</script>
</head>

<body >
<div id="googleMap" style="width:1500px;height:1500px;"></div>
</body>
</html>
