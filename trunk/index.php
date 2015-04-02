<!DOCTYPE html>
<html lang="fr">
<head>
	<title>Archi Velo</title>
	<link rel="stylesheet" href="style.css" type="text/css"/>
	<meta http-equiv="Content-Type" content="text/html;" charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
	<style type="text/css">html { height: 100% } body { height: 100%; margin: 0px; padding: 0px } #map_canvas { width: 70%; height: 70%; margin: auto; margin-bottom: 80px; border-radius: 40px}</style>
	<script type="text/javascript">
	</script>
</head>
<body>
	<h1 style="text-align:center; font-size:72px">Archi-Vélo</h1>
	<div id="map_canvas"></div>
	<script type="text/javascript">
		map = new google.maps.Map(document.getElementById("map_canvas"), {  
		        zoom: 17,
		        center: new google.maps.LatLng(48.858565, 2.347198),
		        mapTypeId: google.maps.MapTypeId.ROADMAP
		      });   
		var watchId = navigator.geolocation.watchPosition(successCallback,null,{enableHighAccuracy:true});  
		function successCallback(position){
		  map.panTo(new google.maps.LatLng(position.coords.latitude, position.coords.longitude));
		  var contentMoi = '<div id="content"><div id="siteNotice"><div><h1 id="firstHeading" class="firstHeading" style="font-size:24px">Vous êtes ici !</h1></div>';
		  var infowindow = new google.maps.InfoWindow({content: contentMoi});
		  var marker = new google.maps.Marker({
		    position: new google.maps.LatLng(position.coords.latitude, position.coords.longitude), 
		    map: map
		  }); 
		  google.maps.event.addListener( marker, 'click', function() {infowindow.open(map, marker);});
		}
	</script>
	<div class="container">
		<div class="row"><?php 
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
			<div class="table-responsive">
				<table class="table table-bordered">
					<!--<tr><th class="col-md-3">Nom</th><th class="col-md-3">Map Google</th><th class="col-md-3">Nombre de places libres</th><th class="col-md-3">Nombre de vélos disponibles</th></tr>-->
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

							$nom_encode = str_replace("°", "ème", $nom);
							$adresse_encode = str_replace("n°", "Numéro ", $address);
							$adresse_good = str_replace("°", "ème", $adresse_encode);

							//Affichage des données
							//echo '<tr><td class="col-md-3"><b>'.ucwords($nom_encode).'</b></td><td class="col-md-3">'.$lat.'<br/>'.$lng.'</td><td class="col-md-3">'.$nbVelos.'</td><td class="col-md-3">'.$nbPlaceLibre.'</td></tr>';
							
							echo '<script type="text/javascript">
									var contentString'.$i.' = \'<div id="content"><div id="siteNotice"><div><h1 id="firstHeading" class="firstHeading" style="font-size:24px">'.addslashes($nom_encode).'</h1><div id="bodyContent"><p>Nombre de place disponibles : '.$nbPlaceLibre.'</p><p>Nombre de vélos disponibles : '.$nbVelos.'</p></div></div>\';
									var myMarker'.$i.' = new google.maps.Marker({position: {lat: '.$lat.', lng: '.$lng.'},title:"'.$nom_encode.'", icon: "http://www.geovelo.fr/static/img/pictos/velov.png", map:map});
									myMarker'.$i.'.setMap(map); 
									google.maps.event.addListener( myMarker'.$i.', \'click\', function() {
										var infowindow'.$i.' = new google.maps.InfoWindow({
										    content: contentString'.$i.'
										});
										infowindow'.$i.'.open(map, myMarker'.$i.');
									});
									google.maps.event.trigger(map, \'resize\');
								</script>';
						}
					?>
				</table>
			</div>
		</div>
	</div>
	</body>
</html>