//global vars
function banana(e,t){$.ajax({url:"../tmp/open9000---cache"+e,type:"GET",dataType:"text",success:function(e){var n=e.split(/s:[0-9]{3,}:"/),r=n[n.length-1],i=r.toString().split('";}}'),s=i[0],o=JSON.parse(s);t(o)},error:function(){window.console.log("fail")}})}function initialize(){var e={zoom:13,center:new google.maps.LatLng(51.05,3.7167),mapTypeId:google.maps.MapTypeId.ROADMAP};map=new google.maps.Map(document.getElementById("map_canvas"),e)}function geolocation(){Modernizr.geolocation?navigator.geolocation.getCurrentPosition(geoSuccess,geoError,{timeout:1e4,enableHighAccuracy:!0}):alert('You have an ancient browser. Please visit <a href="http://browsehappy.com/">Browsehappy</a>.')}function geoSuccess(e){var t=e.coords;myGeoMarker=new google.maps.Marker({position:new google.maps.LatLng(t.latitude,t.longitude),map:map,title:"My location"});typeof myGeoMarker!="undefined"&&centermap()}function centermap(){var e=myGeoMarker.getPosition();map.setCenter(e)}function geoError(e){console.log(e)}function getParking(){$.getJSON(parkingurl,function(e){$.each(e.Parkings.parkings,function(e,t){var n=t.availableCapacity,r=t.totalCapacity,i=r-n;n>=400?parkingimage="img/4+.png":n>=200?parkingimage="img/2+.png":parkingimage="img/2.png";marker=new google.maps.Marker({position:new google.maps.LatLng(t.latitude,t.longitude),title:t.description,map:map,icon:parkingimage});mParking.push(marker);google.maps.event.addListener(marker,"click",function(){var e=t.description,r=t.address,s=t.contactInfo;$("#parking-content h1").html(e);$("#parking-content .p-address").html(r);$("#parking-content a").html(s);$("#p-right p").html('<span id="free">Free '+n+'</span> - <span id="occupied">Occupied '+i+"</span>");if($("#canvas").is(":empty")){var o=[n,i],u=100,a=100,f=Math.min(u,a)/2,l=d3.scale.category20(),c=d3.layout.pie().sort(null),h=d3.svg.arc().innerRadius(f-15).outerRadius(f),p=d3.select("#canvas").append("svg").attr("width",u).attr("height",a).append("g").attr("transform","translate("+u/2+","+a/2+")"),d=p.selectAll("path").data(c(o));d.enter().append("path");d.exit().remove();d.attr("fill",function(e,t){return l(t)}).attr("d",h)}});$("#backbutton").click(function(){$("#canvas").empty()});bindInfoWindow(marker,map,infowindow,"<h1>"+this.description+"</h1>"+"<p>Places left: "+this.availableCapacity+'</p><a href="#parking" data-transition="slide">More Info</a>')})})}function getSport(){banana(2,function(e){var t="img/weights.png";$.each(e.sportgent,function(e,n){marker=new google.maps.Marker({position:new google.maps.LatLng(n.lat,n.long),map:map,title:"Sport centra",icon:t});mSport.push(marker);google.maps.event.addListener(marker,"click",function(){var e=n.naam,t=n.straat+" "+n.nr+"<br>"+n.pstcd+" "+n.gem;$("#sport-content h1").html(e);$("#sport-content p").html(t)});bindInfoWindow(marker,map,infowindow,"<h1>"+this.naam+"</h1>"+"<p>Type: "+this.type+'</p><a href="#sport" data-transition="slide">More Info</a>')})})}function getCellen(){banana(10,function(e){var t="img/telephone.png";$.each(e.telefooncellen,function(e,n){marker=new google.maps.Marker({position:new google.maps.LatLng(n.lat,n.long),map:map,title:"Telefoon cellen",icon:t});mCellen.push(marker)});mcCellen=new MarkerClusterer(map,mCellen)})}function getApotheken(){banana(4,function(e){var t="img/drugstore.png";$.each(e.apotheken,function(e,n){marker=new google.maps.Marker({position:new google.maps.LatLng(n.lat,n.long),map:map,title:"Apotheken",icon:t});mApo.push(marker);google.maps.event.addListener(marker,"click",function(){var e=n.naam,t=n.adres+"<br>"+n.postcode+" "+n.gemeente;$("#apo-content h1").html(e);$("#apo-content p").html(t)});bindInfoWindow(marker,map,infowindow,"<h1>"+this.naam+'</h1><a href="#apo" data-transition="slide">More Info</a>')});mcApo=new MarkerClusterer(map,mApo)})}function getSani(){banana(9,function(e){var t="img/toilets.png";$.each(e.publieksanitair,function(e,n){var r=new google.maps.LatLng(n.lat,n.long),i=i=n.open7op7;i==1?i="ja":i="nee";marker=new google.maps.Marker({position:r,map:map,title:"Publiek sanitair",icon:t});mSani.push(marker);google.maps.event.addListener(marker,"click",function(){var e=n.situering,t=n.type,r=n.toegprijs;r==1?r="ja":r="nee";$("#sani-content h1").html(e);$("#sani-content #betaland").html("Betalend: "+r);$("#sani-content #type").html("Type: "+t)});bindInfoWindow(marker,map,infowindow,"<h1>"+this.situering+"</h1><p>Open 7op7: "+i+'</p><a href="#sani" data-transition="slide">More Info</a>')});mcSani=new MarkerClusterer(map,mSani)})}function getBios(){banana(5,function(e){var t="img/cinema.png";$.each(e.bioscopen,function(e,n){marker=new google.maps.Marker({position:new google.maps.LatLng(n.lat,n.long),map:map,title:"Bioscopen",icon:t});mBios.push(marker);google.maps.event.addListener(marker,"click",function(){var e=n.naam,t=n.ligging;$("#bios-content h1").html(e);$("#bios-content p").html(t)});bindInfoWindow(marker,map,infowindow,"<h1>"+this.naam+'</h1><a href="#bios" data-transition="slide">More Info</a>')})})}function getBib(){banana(6,function(e){var t="img/book.png";$.each(e.bibliotheken,function(e,n){marker=new google.maps.Marker({position:new google.maps.LatLng(n.lat,n.long),map:map,title:"Bibliotheken",icon:t});mBib.push(marker);google.maps.event.addListener(marker,"click",function(){var e=n.locatie,t=n.afdeling;$("#bib-content h1").html(e);$("#bib-content p").html("Afdeling: "+t)});bindInfoWindow(marker,map,infowindow,"<h1>Bib:</h1><h2>"+n.locatie+'</h2><a href="#bib" data-transition="slide">More Info</a>')})})}function getArts(){banana(7,function(e){var t="img/medicine.png";$.each(e.huisartsenwachtposten,function(e,n){marker=new google.maps.Marker({position:new google.maps.LatLng(n.lat,n.long),map:map,title:"Huisartsenwachtposten",icon:t});mArts.push(marker);google.maps.event.addListener(marker,"click",function(){var e=n.naam_wacht,t=n.afdeling,r=n.adres+"<br>"+n.postcode+" "+n.gemeente,i=n.open_op;$("#arts-content h1").html(e);$("#arts-content #adres").html(r);$("#arts-content #open").html(i)});bindInfoWindow(marker,map,infowindow,"<h1>"+n.naam_wacht+'</h1><a href="#arts" data-transition="slide">More Info</a>')})})}function getSchool(){banana(8,function(e){var t="img/cramschool.png";$.each(e.basisscholen,function(e,n){marker=new google.maps.Marker({position:new google.maps.LatLng(n.lat,n.long),map:map,title:"Schoolen",icon:t});mSchool.push(marker);google.maps.event.addListener(marker,"click",function(){var e=n.roepnaam,t=n.straat,r=n.aanbod,i=n.net;$("#school-content h1").html(e);$("#school-content #adres").html(t);$("#school-content #aanbod").html(r);$("#school-content #net").html(i)});bindInfoWindow(marker,map,infowindow,"<h1>"+n.roepnaam+'</h1><a href="#school" data-transition="slide">More Info</a>')});mcSchool=new MarkerClusterer(map,mSchool)})}function getZiekenhuis(){banana(3,function(e){var t="img/firstaid.png";$.each(e.ziekenhuizen,function(e,n){marker=new google.maps.Marker({position:new google.maps.LatLng(n.lat,n.long),map:map,title:"Ziekenhuizen",icon:t});mZiek.push(marker);google.maps.event.addListener(marker,"click",function(){var e=n.naam,t=n.straat+" "+n.nr+"<br>"+n.postcode+" "+n.gemeente,r=n.aanbod,i=n.net;$("#ziek-content h1").html(e);$("#ziek-content #adres").html(t)});var r={position:new google.maps.LatLng(n.lat,n.long),pov:{heading:34,pitch:10,zoom:1}};bindInfoWindow(marker,map,infowindow,"<h1>"+n.naam+'</h1><a href="#ziek" data-transition="slide">More Info</a>')})})}function bindInfoWindow(e,t,n,r){google.maps.event.addListener(e,"click",function(){n.setContent(r);n.open(t,e)})}function removeMarkers(){if(mParking){for(i in mParking)mParking[i].setMap(null);mParking.length=0}if(mApo){for(i in mApo)mApo[i].setMap(null);mApo.length=0}if(mSchool){for(i in mSchool)mSchool[i].setMap(null);mSchool.length=0}if(mSani){for(i in mSani)mSani[i].setMap(null);mSani.length=0}if(mSport){for(i in mSport)mSport[i].setMap(null);mSport.length=0}if(mZiek){for(i in mZiek)mZiek[i].setMap(null);mZiek.length=0}if(mArts){for(i in mArts)mArts[i].setMap(null);mArts.length=0}if(mBib){for(i in mBib)mBib[i].setMap(null);mBib.length=0}if(mBios){for(i in mBios)mBios[i].setMap(null);mBios.length=0}if(mCellen){for(i in mCellen)mCellen[i].setMap(null);mCellen.length=0}mcSchool&&mcSchool.clearMarkers();mcCellen&&mcCellen.clearMarkers();mcApo&&mcApo.clearMarkers();mcSani&&mcSani.clearMarkers()}function checkState(){if(localStorage.apo==="checked"){$("#apo").attr("checked","checked");$(".apo").addClass("ui-checkbox-on");$(".apo span").addClass("ui-icon-checkbox-on");getApotheken()}else removeMarkers();if(localStorage.arts==="checked"){$("#arts").attr("checked","checked");$(".arts").addClass("ui-checkbox-on");$(".arts span").addClass("ui-icon-checkbox-on");getArts()}else removeMarkers();if(localStorage.bib==="checked"){$("#bib").attr("checked","checked");$(".bib").addClass("ui-checkbox-on");$(".bib span").addClass("ui-icon-checkbox-on");getBib()}else removeMarkers();if(localStorage.bios==="checked"){$("#bios").attr("checked","checked");$(".bios").addClass("ui-checkbox-on");$(".bios span").addClass("ui-icon-checkbox-on");getBios()}else removeMarkers();if(localStorage.cellen==="checked"){$("#cellen").attr("checked","checked");$(".cellen").addClass("ui-checkbox-on");$(".cellen span").addClass("ui-icon-checkbox-on");getCellen()}else removeMarkers();if(localStorage.school==="checked"){$("#school").attr("checked","checked");$(".school").addClass("ui-checkbox-on");$(".school span").addClass("ui-icon-checkbox-on");getSchool()}else removeMarkers();if(localStorage.parking==="checked"){$("#parking").attr("checked","checked");$(".parking").addClass("ui-checkbox-on");$(".parking span").addClass("ui-icon-checkbox-on");getParking()}else removeMarkers();if(localStorage.sport==="checked"){$("#sport").attr("checked","checked");$(".sport").addClass("ui-checkbox-on");$(".sport span").addClass("ui-icon-checkbox-on");getSport()}else removeMarkers();if(localStorage.sani==="checked"){$("#sani").attr("checked","checked");$(".sani").addClass("ui-checkbox-on");$(".sani span").addClass("ui-icon-checkbox-on");getSani()}else removeMarkers();if(localStorage.ziek==="checked"){$("#ziek").attr("checked","checked");$(".ziek").addClass("ui-checkbox-on");$(".ziek span").addClass("ui-icon-checkbox-on");getZiekenhuis()}else removeMarkers()}var map,infowindow=new google.maps.InfoWindow({content:""}),mcCellen,mcApo,mcSani,mcSchool,mParking=[],mSport=[],mZiek=[],mApo=[],mBib=[],mBios=[],mArts=[],mSchool=[],mSani=[],mCellen=[],parkingurl="http://datatank.gent.be/Mobiliteitsbedrijf/Parkings.json",sportnurl="http://data.appsforghent.be/poi/sportgent.json",ziekenhuizenurl="http://data.appsforghent.be/poi/ziekenhuizen.json",apothekenurl="http://data.appsforghent.be/poi/apotheken.json",bibliothekenurl="http://data.appsforghent.be/poi/bibliotheken.json",bioscopenurl="http://data.appsforghent.be/poi/bioscopen.json",huisartsenwachtposturl="http://data.appsforghent.be/poi/huisartsenwachtposten.json",schoolennurl="http://data.appsforghent.be/poi/basisscholen.json",sanitairurl="http://data.appsforghent.be/poi/publieksanitair.json",telefooncellenurl="http://data.appsforghent.be/poi/telefooncellen.json";$("#home").live("pageshow",function(e){var t=$(window).height()-$("#map_canvas").offset().top-$("#home").find('[data-role="footer"]').height()-25;$("#map_canvas").height(t)});$(function(){initialize();geolocation();checkState();$("input[type=checkbox]").change(function(){localStorage[$(this).attr("id")]=$(this).attr("checked");checkState()});$(window).resize(function(e){var t=$(window).height()-$("#map_canvas").offset().top-$("#home").find('[data-role="footer"]').height()-25;$("#map_canvas").height(t);centermap();return!1})});