function toTop(id){
	document.getElementById(id).width = "200";
	document.getElementById(id).height = "100";
} 

function toDown(id){
	document.getElementById(id).width = "0";
	document.getElementById(id).height = "0";
} 

function valForm() {
	var nameval1 = document.forms["myForm"]["eventname"].value;
	var nameval2 = document.forms["myForm"]["location"].value;
	if ((/^[0-9a-zA-Z]+$/.test(nameval1)) && (/^[0-9a-zA-Z]+$/.test(nameval2)) == true ) {
		return true;
	}
	else {
		alert("Name and Location should consist of uppercase and/or lowercase characters only");
		return false;
		}
}
		
function myFunction() {
	var text;
	var d = new Date();
	var n = ((d.getDay())-1);
	var x = document.getElementById("myTable").rows[n].cells[1].children[0].innerHTML  
		+ document.getElementById("myTable").rows[n].cells[1].children[1].innerHTML + "   ||~~~||   " 
		+ document.getElementById("myTable").rows[n].cells[2].children[0].innerHTML  
		+ document.getElementById("myTable").rows[n].cells[2].children[1].innerHTML + "   ||~~~||   "
		+ document.getElementById("myTable").rows[n].cells[3].children[0].innerHTML  
		+ document.getElementById("myTable").rows[n].cells[3].children[1].innerHTML +"   ||~~~||   ";
	document.getElementById("demo").innerHTML = x;
}

function NoteOfPointer(id){		    
	document.getElementById(id + "_").children[0].innerHTML + document.getElementById(id + "_").children[1].innerHTML;
}

function myMap() {
	var Location = [
		["Fraser1", 44.97566, -93.237381],
        ["Akerman1", 44.975329, -93.232319],
        ["Tate", 44.975287, -93.234527],
        ["Fraser", 44.97566, -93.237381],
        ["Akerman", 44.975329, -93.232319],
		["Tate1", 44.975287, -93.234527],
		["Alderman", 44.987544, -93.18333],
	    ["Plant", 44.9876, -93.181512],
		["Jones", 44.977902, -93.235323],
		["Hmong", 44.955506, -93.116557],
		["Keller", 44.974686, -93.232074]
	]; 
	var myCenter = new google.maps.LatLng(44.9740,-93.2277);
	var mapCanvas = document.getElementById("googleMap");
	var mapOptions = {center: myCenter, zoom: 14};
	var map_ = new google.maps.Map(mapCanvas, mapOptions);
	var infowindow = []; 
	var maker, i;			
	for( i = 0; i < Location.length; i++ ) {
		var y = Location[i][0] + "_";
		var x = document.getElementById(y).children[0].innerHTML 
			+ document.getElementById(y).children[1].innerHTML;
        var position = new google.maps.LatLng(Location[i][1], Location[i][2]);
        //bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
            map: map_,
            title: Location[i][0],
        });
		marker.setAnimation(google.maps.Animation.BOUNCE);
		setTimeout(function() {
        marker.setAnimation(null)}, 300000);

		google.maps.event.addListener(marker, 'click', function() {
			infowindow[i] = new google.maps.InfoWindow({content: x});
			infowindow[i].open(map, this);
		});
		
    }
  // Zoom to 9 when clicking on marker
	google.maps.event.addListener(marker,'click',function() {
		map_.setZoom(9);
		map_.setCenter(marker.getPosition());
	});

}

var map;
var infowindow;

function initMap() {
	var pyrmont = {lat: 44.9740, lng: -93.2277};
	map = new google.maps.Map(document.getElementById('googleMap'), {
		center: pyrmont, 
		zoom: 14
	});
	infowindow = new google.maps.InfoWindow();
		var service = new google.maps.places.PlacesService(map);
		service.nearbySearch({
			location: pyrmont,
			radius: document.getElementById("raduis").value,
			type: ['restaurant']
        }, callback);
}

function callback(results, status) {
	if (status === google.maps.places.PlacesServiceStatus.OK) {
		for (var i = 0; i < results.length; i++) {
			createMarker(results[i]);
		}
	}
}

function createMarker(place) {
	var placeLoc = place.geometry.location;
	var marker = new google.maps.Marker({
		map: map,
		position: place.geometry.location
	});
	google.maps.event.addListener(marker, 'click', function() {
	infowindow.setContent("Place Name: ".bold() + place.name + "Address: ".bold() + place.vicinity);
	infowindow.open(map, this);
	});
}
	  
function mySearchRaduis(){
	document.getElementById("map").src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyCt1-PgWFonWfvbCqXd93btHzU3BEkJO_g&libraries=places&callback=initMap"
	initMap();
}	