//global vars
var map;
var infowindow = new google.maps.InfoWindow({
	content: ''
});

//marker clusters
var mcCellen;
var mcApo;
var mcSani;
var mcSchool;

// markers
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
var schoolennurl		   = 'http://data.appsforghent.be/poi/basisscholen.json';
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

//get current location
function geolocation() {
	if (Modernizr.geolocation) {
		navigator.geolocation.getCurrentPosition(geoSuccess, geoError, { timeout: 10000, enableHighAccuracy:true });
	} else {
		alert('You have an ancient browser. Please visit <a href="http://browsehappy.com/">Browsehappy</a>.');
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
		
		var parkingimage = 'img/parking.png';

		$.each(data.Parkings.parkings, function(key, val){

			//different images
		 	if (val.availableCapacity >= 400) {
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

		 	//push in array
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
	    }); //eo each
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

			//get info for sport page
		 	google.maps.event.addListener(marker, 'click', function() {
		 		var title = val.naam;
		 		var address = val.straat + ' ' + val.nr + '<br>' + val.pstcd + ' ' + val.gem;
		 		//var contact = val.contactInfo;

	 			$('#sport-content h1').html(title);
	 			$('#sport-content p').html(address);
	 			//$('#sport-content a').html(contact);
		 	});

		 	//infowindow
			bindInfoWindow(marker, map, infowindow, '<h1>' + this.naam + '</h1>' +
		 	'<p>Type: ' + this.type + '</p><a href="#sport" data-transition="slide">go</a>');
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

			//get info for apo page
		 	google.maps.event.addListener(marker, 'click', function() {
		 		var title = val.naam;
		 		var address = val.adres + '<br>' + val.postcode + ' ' + val.gemeente;
		 		//var contact = val.contactInfo;

	 			$('#apo-content h1').html(title);
	 			$('#apo-content p').html(address);
	 			//$('#apo-content a').html(contact);
		 	});

		 	//infowindow
			bindInfoWindow(marker, map, infowindow, '<h1>' + this.naam + '</h1><a href="#apo" data-transition="slide">go</a>');
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
			var open = open = val.open7op7;
			if (open == 1) {
	 			open = 'ja';
	 		} else {
	 			open = 'nee';
	 		}

			marker = new google.maps.Marker({
				position: latlng,
				map: map,
				title: 'Publiek sanitair',
				icon: saniimg
			});

			mSani.push(marker);

			//get info for sani page
		 	google.maps.event.addListener(marker, 'click', function() {
		 		var title = val.situering;
		 		var type = val.type;
		 		var prijs = val.toegprijs;

		 		if (prijs == 1) {
		 			prijs = 'ja';
		 		} else {
		 			prijs = 'nee'
		 		}

	 			$('#sani-content h1').html(title);
	 			$('#sani-content #betaland').html('Betalend: ' + prijs);
	 			$('#sani-content #type').html('Type: ' + type);
	 			//$('#sani-content a').html(contact);
		 	});

		 	//infowindow
			bindInfoWindow(marker, map, infowindow, '<h1>' + this.situering + '</h1><p>Open 7op7: ' + open + '</p><a href="#sani" data-transition="slide">go</a>');
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

			//get info for parking page
		 	google.maps.event.addListener(marker, 'click', function() {
		 		var title = val.naam;
		 		var address = val.ligging;

	 			$('#bios-content h1').html(title);
	 			$('#bios-content p').html(address);
	 			
		 	});

			//infowindow
		 	bindInfoWindow(marker, map, infowindow, '<h1>' + this.naam + '</h1><a href="#bios" data-transition="slide">go</a>');
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

			//get info for parking page
		 	google.maps.event.addListener(marker, 'click', function() {
		 		var title = val.locatie;
		 		var afdeling = val.afdeling;

	 			$('#bib-content h1').html(title);
	 			$('#bib-content p').html('Afdeling: ' + afdeling);
		 	});

			//infowindow
		 	bindInfoWindow(marker, map, infowindow, '<h1>Bib:</h1><h2>' + val.locatie + '</h2><a href="#bib" data-transition="slide">go</a>');
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

			//get info for parking page
		 	google.maps.event.addListener(marker, 'click', function() {
		 		var title = val.naam_wacht;
		 		var afdeling = val.afdeling;
		 		var adres = val.adres + '<br>' + val.postcode + ' ' + val.gemeente;
		 		var open = val.open_op;

	 			$('#arts-content h1').html(title);
	 			$('#arts-content #adres').html(adres);
	 			$('#arts-content #open').html(open);

		 	});

			//infowindow
		 	bindInfoWindow(marker, map, infowindow, '<h1>' + val.naam_wacht + '</h1><a href="#arts" data-transition="slide">go</a>');
		});
	});
}

function getSchool() {
	$.getJSON(schoolennurl, function(data) {
		//console.log(data);
		var schoolimg = 'img/cramschool.png'

		$.each(data.basisscholen, function(key, val){
			marker = new google.maps.Marker({
				position: new google.maps.LatLng(val.lat, val.long),
				map: map,
				title: 'Schoolen',
				icon: schoolimg
			});
			mSchool.push(marker);

			//get info for parking page
		 	google.maps.event.addListener(marker, 'click', function() {
		 		var title = val.roepnaam;
		 		var adres = val.straat;
		 		var aanbod = val.aanbod;
		 		var net = val.net;

	 			$('#school-content h1').html(title);
	 			$('#school-content #adres').html(adres);
	 			$('#school-content #aanbod').html(aanbod);
	 			$('#school-content #net').html(net);
		 	});

			//infowindow
		 	bindInfoWindow(marker, map, infowindow, '<h1>' + val.roepnaam + '</h1><a href="#school" data-transition="slide">go</a>');

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

			//get info for parking page
		 	google.maps.event.addListener(marker, 'click', function() {
		 		var title = val.naam;
		 		var adres = val.straat + ' ' + val.nr + '<br>' + val.postcode + ' ' + val.gemeente;
		 		var aanbod = val.aanbod;
		 		var net = val.net;

	 			$('#ziek-content h1').html(title);
	 			$('#ziek-content #adres').html(adres);
		 	});
		 	
		 	//pano
		 	var panoramaOptions = {
			  position: new google.maps.LatLng(val.lat, val.long),
			  pov: {
			    heading: 34,
			    pitch: 10,
			    zoom: 1
			  }
			};
		 	
		 	bindPano(marker, panoramaOptions);

			//infowindow
		 	bindInfoWindow(marker, map, infowindow, '<h1>' + val.naam + '</h1><a href="#ziek" data-transition="slide">go</a>');
		}); //eo each
	}); //eo json
}

function bindInfoWindow(marker, map, infowindow, html){
	google.maps.event.addListener(marker, 'click', function() {
		infowindow.setContent(html);
		infowindow.open(map, marker);
	});
}

function removeMarkers(){
	// als er markers zijn voor foo, loop door de markers array en setMap(null)
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
	//als localstorage = checked, toon het vinkje en get foo, else removeMarkers
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

//when page is live resize map
$("#home").live("pageshow", function (b) {
    var a = $(window).height() - $("#map_canvas").offset().top - $("#home").find('[data-role="footer"]').height() - 25;
    $("#map_canvas").height(a);
});

//doc ready
$(function(){

	initialize();
	geolocation();
	checkState();

	// listen naar een change, en verander localStorage naargelang; checked of undefined
	$('input[type=checkbox]').change(function() {
		localStorage[$(this).attr('id')] = $(this).attr('checked');
		checkState();
	});

	//when page is resized, resize map
	$(window).resize(function (b) {
        var a = $(window).height() - $("#map_canvas").offset().top - $("#home").find('[data-role="footer"]').height() - 25;
        $("#map_canvas").height(a);
        centermap();
        return false;
    });

});