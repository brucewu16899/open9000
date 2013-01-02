var map;
var infowindow;

var mcCellen;
var mcApo;
var mcSani;
var mcSchool;

var mParking = [];
var mSport = [];
var mZiek = [];
var mApo = [];
var mBib = [];
var mBios = [];
var mArts = [];
var mSchool = [];
var mSani = [];
var mCellen = [];

// url to datasets
var parkingurl 			   = 'http://datatank.gent.be/Mobiliteitsbedrijf/Parkings.json';
var sportnurl 			   = 'http://data.appsforghent.be/poi/sportgent.json';
var ziekenhuizenurl 	   = 'http://data.appsforghent.be/poi/ziekenhuizen.json';
var apothekenurl	 	   = 'http://data.appsforghent.be/poi/apotheken.json';
var bibliothekenurl 	   = 'http://data.appsforghent.be/poi/bibliotheken.json';
var bioscopenurl	 	   = 'http://data.appsforghent.be/poi/bioscopen.json';
var huisartsenwachtposturl = 'http://data.appsforghent.be/poi/huisartsenwachtposten.json';
var schoolennurl		   = 'http://data.appsforghent.be/poi/secundairescholen.json';
var sanitairurl			   = 'http://data.appsforghent.be/poi/publieksanitair.json';
var telefooncellenurl	   = 'http://data.appsforghent.be/poi/telefooncellen.json';


//make map
function initialize() {
	var mapOptions = {
		zoom: 13,
		center: new google.maps.LatLng(51.0500, 3.7167),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};

	map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);

}

function MVCfun() {
	var distanceWidget = new DistanceWidget(map);

	google.maps.event.addListener(distanceWidget, 'distance_changed', function() {
	  displayInfo(distanceWidget);
	});

	google.maps.event.addListener(distanceWidget, 'position_changed', function() {
	  displayInfo(distanceWidget);
	});
}

function displayInfo(widget) {
	var info = document.getElementById('info');
	info.innerHTML = 'Position: ' + widget.get('position') + ', distance: ' + widget.get('distance');
}

//get current location
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
		title: 'My location'
	});

	centermap();
}

function centermap() {
	var mypos = myGeoMarker.getPosition();
	map.setCenter(mypos);
}

function geoError(error) {
	console.log(error);
}

function getParking() {
	
	$.getJSON(parkingurl, function(data) {
		//console.log(data);
		infowindow = new google.maps.InfoWindow({
			content: ''
		});

		var parkingimage = 'img/parking.png';

		$.each(data.Parkings.parkings, function(key, val){

			//different images
		 	if (val.availableCapacity >= 500) {
		 		parkingimage = 'img/4+.png';
		 	} else if (val.availableCapacity >= 200) {
		 		parkingimage = 'img/2+.png';
		 	} else {
		 		parkingimage = 'img/2.png';
		 	}

		 	//parking markers
		 	marker = new google.maps.Marker({
		 		position: new google.maps.LatLng(val.latitude, val.longitude),
				title: val.description,
				map: map,
				icon: parkingimage
		 	});

		 	mParking.push(marker);

		 	//get info for parking page
		 	google.maps.event.addListener(marker, 'click', function() {
		 		var title = val.description;
		 		var address = val.address;
		 		var contact = val.contactInfo;

	 			$('#parking-content h1').html(title);
	 			$('#parking-content p').html(address);
	 			$('#parking-content a').html(contact);
		 	});

		 	//infowindow
		 	bindInfoWindow(marker, map, infowindow, '<h1>' + this.description + '</h1>' +
		 	'<p>Places left: ' + this.availableCapacity + '</p><a href="#parking" data-transition="slide">go</a>');
	    })
	});
}

function bindInfoWindow(marker, map, infowindow, html){
	google.maps.event.addListener(marker, 'click', function() {
		infowindow.setContent(html);
		infowindow.open(map, marker);
	});
}

function getSport() {
	$.getJSON(sportnurl, function(data) {
		//console.log(data);
		var sportimg = 'img/weights.png'

		$.each(data.sportgent, function(key, val){
			marker = new google.maps.Marker({
				position: new google.maps.LatLng(val.lat, val.long),
				map: map,
				title: 'Sport centra',
				icon: sportimg
			});

			mSport.push(marker);
		});
	});
}

function getCellen() {
	$.getJSON(telefooncellenurl, function(data) {
		//console.log(data);
		var telimg = 'img/telephone.png'

		$.each(data.telefooncellen, function(key, val){
			marker = new google.maps.Marker({
				position: new google.maps.LatLng(val.lat, val.long),
				map: map,
				title: 'Telefoon cellen',
				icon: telimg
			});
			mCellen.push(marker);
		});
		mcCellen = new MarkerClusterer(map, mCellen);
	});
}

function getApotheken() {
	$.getJSON(apothekenurl, function(data) {
		//console.log(data);
		var apoimg = 'img/drugstore.png'

		$.each(data.apotheken, function(key, val){
			marker = new google.maps.Marker({
				position: new google.maps.LatLng(val.lat, val.long),
				map: map,
				title: 'Apotheken',
				icon: apoimg
			});

			mApo.push(marker);
		});

		mcApo = new MarkerClusterer(map, mApo);
	});
}

function getSani() {
	$.getJSON(sanitairurl, function(data) {
		//console.log(data);
		var saniimg = 'img/toilets.png'
		
		$.each(data.publieksanitair, function(key, val){

			var latlng = new google.maps.LatLng(val.lat, val.long);

			marker = new google.maps.Marker({
				position: latlng,
				map: map,
				title: 'Publiek sanitair',
				icon: saniimg
			});

			mSani.push(marker);
		});
		mcSani = new MarkerClusterer(map, mSani);
	});
}

function getBios() {
	$.getJSON(bioscopenurl, function(data) {
		//console.log(data);
		var biosimg = 'img/cinema.png'

		$.each(data.bioscopen, function(key, val){
			marker = new google.maps.Marker({
				position: new google.maps.LatLng(val.lat, val.long),
				map: map,
				title: 'Bioscopen',
				icon: biosimg
			});

			mBios.push(marker);
		});
	});
}

function getBib() {
	$.getJSON(bibliothekenurl, function(data) {
		//console.log(data);
		var bibimg = 'img/book.png'

		$.each(data.bibliotheken, function(key, val){
			marker = new google.maps.Marker({
				position: new google.maps.LatLng(val.lat, val.long),
				map: map,
				title: 'Bibliotheken',
				icon: bibimg
			});

			mBib.push(marker);
		});
	});
}

function getArts() {
	$.getJSON(huisartsenwachtposturl, function(data) {
		//console.log(data);
		var artsimg = 'img/medicine.png'

		$.each(data.huisartsenwachtposten, function(key, val){
			marker = new google.maps.Marker({
				position: new google.maps.LatLng(val.lat, val.long),
				map: map,
				title: 'Huisartsenwachtposten',
				icon: artsimg
			});

			mArts.push(marker);
		});
	});
}

function getSchool() {
	$.getJSON(schoolennurl, function(data) {
		//console.log(data);
		var schoolimg = 'img/cramschool.png'

		$.each(data.secundairescholen, function(key, val){
			marker = new google.maps.Marker({
				position: new google.maps.LatLng(val.lat, val.long),
				map: map,
				title: 'Schoolen',
				icon: schoolimg
			});
			mSchool.push(marker);
		});

		mcSchool = new MarkerClusterer(map, mSchool);
	});
}

function getZiekenhuis() {
	$.getJSON(ziekenhuizenurl, function(data) {
		//console.log(data);
		var ziekimg = 'img/firstaid.png'

		$.each(data.ziekenhuizen, function(key, val){
			marker = new google.maps.Marker({
				position: new google.maps.LatLng(val.lat, val.long),
				map: map,
				title: 'Ziekenhuizen',
				icon: ziekimg
			});
			mZiek.push(marker);
		});
	});
}

function removeMarkers(){
	if (mParking) {
		for (i in mParking) {
			mParking[i].setMap(null)
		}
		mParking.length = 0;
	}
	if (mApo) {
		for (i in mApo) {
			mApo[i].setMap(null)
		}
		mApo.length = 0;
	}
	if (mSchool) {
		for (i in mSchool) {
			mSchool[i].setMap(null)
		}
		mSchool.length = 0;
	}
	if (mSani) {
		for (i in mSani) {
			mSani[i].setMap(null)
		}
		mSani.length = 0;
	}
	if (mSport) {
		for (i in mSport) {
			mSport[i].setMap(null)
		}
		mSport.length = 0;
	}
	if (mZiek) {
		for (i in mZiek) {
			mZiek[i].setMap(null)
		}
		mZiek.length = 0;
	}
	if (mArts) {
		for (i in mArts) {
			mArts[i].setMap(null)
		}
		mArts.length = 0;
	}
	if (mBib) {
		for (i in mBib) {
			mBib[i].setMap(null)
		}
		mBib.length = 0;
	}
	if (mBios) {
		for (i in mBios) {
			mBios[i].setMap(null)
		}
		mBios.length = 0;
	}
	if (mCellen) {
		for (i in mCellen) {
			mCellen[i].setMap(null)
		}
		mCellen.length = 0;
	}
	if (mcSchool) {
		mcSchool.clearMarkers();
	}
	if (mcCellen) {
		mcCellen.clearMarkers();
	}
	if (mcApo) {
		mcApo.clearMarkers();
	}
	if (mcSani) {
		mcSani.clearMarkers();
	}
}

function checkState() {
	if (localStorage.apo === "checked") {
      $("#apo").attr("checked", "checked");
      $(".apo").addClass('ui-checkbox-on');
      $(".apo span").addClass('ui-icon-checkbox-on');
      getApotheken();
    } else {
    	removeMarkers();
    }
    if (localStorage.arts === "checked") {
      $("#arts").attr("checked", "checked");
      $(".arts").addClass('ui-checkbox-on');
      $(".arts span").addClass('ui-icon-checkbox-on');
      getArts();
    } else {
    	removeMarkers();
    }
    if (localStorage.bib === "checked") {
      $("#bib").attr("checked", "checked");
      $(".bib").addClass('ui-checkbox-on');
      $(".bib span").addClass('ui-icon-checkbox-on');
      getBib();
    } else {
    	removeMarkers();
    }
    if (localStorage.bios === "checked") {
      $("#bios").attr("checked", "checked");
      $(".bios").addClass('ui-checkbox-on');
      $(".bios span").addClass('ui-icon-checkbox-on');
      getBios();
    } else {
    	removeMarkers();
    }
    if (localStorage.cellen === "checked") {
      $("#cellen").attr("checked", "checked");
      $(".cellen").addClass('ui-checkbox-on');
      $(".cellen span").addClass('ui-icon-checkbox-on');
      getCellen();
    } else {
    	removeMarkers();
    }
    if (localStorage.school === "checked") {
      $("#school").attr("checked", "checked");
      $(".school").addClass('ui-checkbox-on');
      $(".school span").addClass('ui-icon-checkbox-on');
      getSchool();
    } else {
    	removeMarkers();
    }
    if (localStorage.parking === "checked") {
      $("#parking").attr("checked", "checked");
      $(".parking").addClass('ui-checkbox-on');
      $(".parking span").addClass('ui-icon-checkbox-on');
      getParking();
    } else {
    	removeMarkers();
    }
    if (localStorage.sport === "checked") {
      $("#sport").attr("checked", "checked");
      $(".sport").addClass('ui-checkbox-on');
      $(".sport span").addClass('ui-icon-checkbox-on');
      getSport();
    } else {
    	removeMarkers();
    }
    if (localStorage.sani === "checked") {
      $("#sani").attr("checked", "checked");
      $(".sani").addClass('ui-checkbox-on');
      $(".sani span").addClass('ui-icon-checkbox-on');
      getSani();
    } else {
    	removeMarkers();
    }
    if (localStorage.ziek === "checked") {
      $("#ziek").attr("checked", "checked");
      $(".ziek").addClass('ui-checkbox-on');
      $(".ziek span").addClass('ui-icon-checkbox-on');
      getZiekenhuis();
    } else {
    	removeMarkers();
    }
}

/**
 * A distance widget that will display a circle that can be resized and will
 * provide the radius in km.
 *
 * @param {google.maps.Map} map The map on which to attach the distance widget.
 *
 * @constructor
 */
function DistanceWidget(map) {
	this.set('map', map);
	this.set('position', map.getCenter());

	var marker = new google.maps.Marker({
		draggable: true,
		title: 'Move me!'
	});

	marker.bindTo('map', this);

	marker.bindTo('position', this);

	// Create a new radius widget
	var radiusWidget = new RadiusWidget();

	// Bind the radiusWidget map to the DistanceWidget map
	radiusWidget.bindTo('map', this);

	// Bind the radiusWidget center to the DistanceWidget position
	radiusWidget.bindTo('center', this, 'position');

	// Bind to the radiusWidgets' distance property
	this.bindTo('distance', radiusWidget);

	// Bind to the radiusWidgets' bounds property
	this.bindTo('bounds', radiusWidget);
};

DistanceWidget.prototype = new google.maps.MVCObject();

/**
 * A radius widget that add a circle to a map and centers on a marker.
 *
 * @constructor
 */
function RadiusWidget() {
	var circle = new google.maps.Circle({
		strokeweight: 1
	});

	this.set('distance', 2);
	this.bindTo('bounds', circle);
	circle.bindTo('center', this);
	circle.bindTo('map', this);
	circle.bindTo('radius', this);

	this.addSizer_();
};

RadiusWidget.prototype = new google.maps.MVCObject();

/**
 * Update the radius when the distance has changed.
 */
RadiusWidget.prototype.distance_changed = function() {
	this.set('radius', this.get('distance') * 1000);
};


/**
 * Add the sizer marker to the map.
 *
 * @private
 */
RadiusWidget.prototype.addSizer_ = function() {
	var sizer = new google.maps.Marker({
		draggable: true,
		title: 'Drag me'
	});

	sizer.bindTo('map', this);
	sizer.bindTo('position', this, 'sizer_position');

	var me = this;
	google.maps.event.addListener(sizer, 'drag', function() {
	  // Set the circle distance (radius)
	  me.setDistance();
	});
};


/**
 * Update the center of the circle and position the sizer back on the line.
 *
 * Position is bound to the DistanceWidget so this is expected to change when
 * the position of the distance widget is changed.
 */
RadiusWidget.prototype.center_changed = function() {
	var bounds = this.get('bounds');

	if (bounds) {
		var lng = bounds.getNorthEast().lng();

		var position = new google.maps.LatLng(this.get('center').lat(), lng);
		this.set('sizer_position', position);
	}
};

/**
 * Calculates the distance between two latlng locations in km.
 * @see http://www.movable-type.co.uk/scripts/latlong.html
 *
 * @param {google.maps.LatLng} p1 The first lat lng point.
 * @param {google.maps.LatLng} p2 The second lat lng point.
 * @return {number} The distance between the two points in km.
 * @private
*/
RadiusWidget.prototype.distanceBetweenPoints_ = function(p1, p2) {
  if (!p1 || !p2) {
    return 0;
  }

  var R = 6371; // Radius of the Earth in km
  var dLat = (p2.lat() - p1.lat()) * Math.PI / 180;
  var dLon = (p2.lng() - p1.lng()) * Math.PI / 180;
  var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
    Math.cos(p1.lat() * Math.PI / 180) * Math.cos(p2.lat() * Math.PI / 180) *
    Math.sin(dLon / 2) * Math.sin(dLon / 2);
  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
  var d = R * c;
  return d;
};

/**
 * Set the distance of the circle based on the position of the sizer.
 */
RadiusWidget.prototype.setDistance = function() {
  // As the sizer is being dragged, its position changes.  Because the
  // RadiusWidget's sizer_position is bound to the sizer's position, it will
  // change as well.
  var pos = this.get('sizer_position');
  var center = this.get('center');
  var distance = this.distanceBetweenPoints_(center, pos);

  // Set the distance property for any objects that are bound to it
  this.set('distance', distance);
};


//doc ready
$(function(){

	initialize();
	geolocation();
	checkState();
	//getApotheken();

	$('input[type=checkbox]').change(function() {
		localStorage[$(this).attr('id')] = $(this).attr('checked');
		checkState();
	});
});
