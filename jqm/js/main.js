var map;
var infowindow;
var contentString;
var marker;

function initialize() {
	var mapOptions = {
		zoom: 13,
		center: new google.maps.LatLng(51.0500, 3.7167),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	}

	map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
}

function geolocation() {
	if (Modernizr.geolocation) {
		navigator.geolocation.getCurrentPosition(geoSuccess, geoError, { timeout: 10000, enableHighAccuracy:true });
	} else {
		alert('You have an ancient browser. Please upgrade to Chrome.');
	}
}

function geoSuccess(position) {
	var coords = position.coords;
	myGeoMarker = new google.maps.Marker({
		position: new google.maps.LatLng(coords.latitude, coords.longitude),
		map: map,
		title: 'My location',
	});

	var mypos = myGeoMarker.getPosition();
	map.setCenter(mypos);
}

function geoError(error) {
	console.log(error);
}

function getParkings() {
	var parkingimage = 'img/parking.png';

	$.getJSON('http://datatank.gent.be/Mobiliteitsbedrijf/Parkings.json', function(data) {

		infowindow = new google.maps.InfoWindow({
			content: ''
		});

		$.each(data.Parkings.parkings, function(key, val){

		 	if (val.availableCapacity >= 500) {
		 		parkingimage = 'img/4+.png'
		 	} else if (val.availableCapacity >= 200) {
		 		parkingimage = 'img/2+.png'
		 	} else {
		 		parkingimage = 'img/2.png'
		 	}

		 	marker = new google.maps.Marker({
		 		position: new google.maps.LatLng(val.latitude, val.longitude),
				map: map,
				title: val.description,
				icon: parkingimage
		 	});

		 	google.maps.event.addListener(marker, 'click', function() {
		 		var title = val.description;
		 		var address = val.address;
		 		var contact = val.contactInfo;

	 			$('#parking-content h1').html(title);
	 			$('#parking-content p').html(address);
	 			$('#parking-content a').html(contact);

		 	});

		 	bindInfoWindow(marker, map, infowindow, '<h1>' + this.description + '</h1>' +
		 	'<p>Places left: ' + this.availableCapacity + '</p><a href="#parking" data-transition="slide">go</a>');
	    	
	     })
	})
}

function bindInfoWindow(marker, map, infowindow, html){
	google.maps.event.addListener(marker, 'click', function() {
		infowindow.setContent(html);
		infowindow.open(map, marker);
	});
}

//doc ready
$(function(){
	initialize();
	//geolocation();
	getParkings();
})
