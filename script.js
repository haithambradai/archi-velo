$(document).ready(function() {
    // Carte zoom 16
	var myMapOptions = {
		zoom: 16,
		center: myLatlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	// Création de la carte
	var map = new google.maps.Map(document.getElementById("map_canvas"), myMapOptions);

	alert("toto");

	var lat = '<?php echo $lat; ?>';
	var lng = '<?php echo $lng; ?>';

	var myLatlng = new google.maps.LatLng(lat,lng);
	// Création du Marker
	var myMarker+'<?php echo $i; ?>' = new google.maps.Marker({
		// Coordonnées du cinéma
		position: myLatlng,
		title:'<?php echo $nom_encode; ?>',
		map: map
	});

	myMarker+'<?php echo $i; ?>'.setMap(map);
 });