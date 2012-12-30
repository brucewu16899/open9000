function initialize() {
	var mapOptions = {
		zoom: 8,
		center: new google.maps.LatLng(51.0500, 3.7167),
		mapTypeId: google.maps.mapTypeId.ROADMAP
	}

	var map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
}



//doc ready
$(function(){

})
