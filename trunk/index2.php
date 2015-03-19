<!DOCTYPE html>
<html>
<head>
	<title>Archi Velo</title>
	<link rel="stylesheet" href="style.css" type="text/css"/>
	
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<style type="text/css">
    html { height: 100% }
    body { height: 100%; margin: 0px; padding: 0px }
    #map_canvas { height: 40% ; width:40%;}
	</style>
	
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>

</head>
<body >
	<div class="container"><h1>Toto</h1></div>
	
	<button class="btn btn-default" onclick="initialize()">Localiser Moi </button>
	<div id="map_canvas"></div>
	

	
	<div class="span6">
		<p><?php 
			//Récupération du fichier JSON
			$json = file_get_contents('https://api.jcdecaux.com/vls/v1/stations?contract=Lyon&apiKey=05011dd5abfb13c9db88e0f585644d4cac5a416c'); 
			
			//Le var_dump est à décommenter si on veut récupérer d'autres infos dans le JSON pour voir le nom du bon champ
			//var_dump(json_decode($json));

			//Transformation du JSON en tableau
			$test = json_decode($json, true);

			//Compte le nb de lignes du tableau
			$nbLigne = count($test);
			?>
			<!-- Tableau présentant les données -->
			<table class="table table-bordered">
				<tr><th>Nom</th><th>Adresse</th><th>Nombre de places libres</th><th>Nombre de vélos disponibles</th></tr>
				<?php
				//Boucle permettant de parcourir le tableau et de récupérer les bonnes valeurs du JSON
				for($i=0;$i<$nbLigne;$i++){
					//On récupère le nom
					$name = $test[$i]['name'];

					//On récupère l'adresse
					$address = $test[$i]['address'];

					//On récupère juste le nom de la station pas son identifiant donc on extrait la partie que l'on veut
					list($num, $nom) = explode('-', $name);

					//Récupération des coordonnées de la station
					$lat = $test[$i]['position']['lat'];
					$lng = $test[$i]['position']['lng'];

					//Récupération des infos de la station : nb de vélos et le nb de places dispo
					$nbVelos = $test[$i]['available_bikes'];
					$nbPlaceLibre = $test[$i]['available_bike_stands'];

					//Affichage des données
					echo '<tr><td>'.$nom.'</td><td>'.$address.'</td><td>'.$nbVelos.'</td><td>'.$nbPlaceLibre.'</td></tr>';
				}
			?>
			</table>
		</p>
	</div>
	
<form id="form" action=index.php method=POST>
  <input type=hidden id="Lat" name="Lat" value="">
  <input type=hidden id="Long" name="Long" value="">
</form>

<script>
var previousPosition = null;
		
function initialize()
{
	alert("initialize");
	var x;
	var y;
	 if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);

    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(loc)
{
	//alert(loc.coords.latitude);
	map = new google.maps.Map(document.getElementById("map_canvas"), {
	zoom: 19,
	center: new google.maps.LatLng(loc.coords.lattitude,loc.coords.longitude),
	mapTypeId: google.maps.MapTypeId.ROADMAP
  });   
	
	

 
if (navigator.geolocation){
  var watchId = navigator.geolocation.watchPosition(successCallback,
                            null,
                            {enableHighAccuracy:true});
}else{
	alert("Votre navigateur ne prend pas en compte la géolocalisation HTML5");    
}
}

function successCallback(position){
  map.panTo(new google.maps.LatLng(position.coords.latitude, position.coords.longitude));
  var marker = new google.maps.Marker({
    position: new google.maps.LatLng(position.coords.latitude, position.coords.longitude), 
    map: map
  }); 
  if (previousPosition){
    var newLineCoordinates =
    [
      new google.maps.LatLng(previousPosition.coords.latitude, previousPosition.coords.longitude),
      new google.maps.LatLng(position.coords.latitude, position.coords.longitude)
    ];
         
    var newLine = new google.maps.Polyline({
      path: newLineCoordinates,        
      strokeColor: "#FF0000",
      strokeOpacity: 1.0,
      strokeWeight: 2
    });
    newLine.setMap(map);
  }
  previousPosition = position;
}


/*	var f = document.getElementById("form");
	var x = document.getElementById("Lat");
	var y = document.getElementById("Long");*/

/*
function showPosition(position) 
{

	
	//x = position.coords.latitude;
	//x = position.coords.longitude;
var lat = position.coords.latitude;
	x = position.coords.latitude;
	y = position.coords.latitude;
	alert(x);
	alert(y);
	
	//f.submit();

}*/


</script>
	

	      

</body>
</html>