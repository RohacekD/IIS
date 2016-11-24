/**
 * Created by Dominik Roháček on 12.2.15.
 */
function initialize() {
	/*    var mapCanvas = document.getElementById('map-canvas');
	 var myLatlng = new google.maps.LatLng(49.56119564, 15.3395763);
	 var mapOptions = {
	 center: myLatlng,
	 zoom: 11,
	 mapTypeId: google.maps.MapTypeId.ROADMAP,
	 disableDefaultUI: true
	 }
	 var map = new google.maps.Map(mapCanvas, mapOptions);

	 var marker = new google.maps.Marker({
	 position: myLatlng,
	 map: map,
	 title: 'Bluetherm Humpolec 1519'
	 });*/
}
//google.maps.event.addDomListener(window, 'load', initialize);

function picResize() {
	jQuery(".sameHeight").matchHeight();
	$(".production .production_circle .images img:not(.tag)").css("height", function () {
		return $(this).outerWidth();
	});
	jQuery(".production .production_circle h3").matchHeight();
}
/*
 * Here put every matchHeight script or size operations that must be done after every
 * window resize or load.
 */
function sizeOperations() {
}

$(window).resize(function () {
	sizeOperations();
});

$(window).load(function () {
	sizeOperations();
});

$(document).ready(function () {
});

$("#menu-toggle").click(function (e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});