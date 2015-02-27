<!DOCTYPE html>
<html>
<head>
	<title>Archi Velo</title>
	<link rel="stylesheet" href="style.css" type="text/css"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
	<div class="container"><h1>Toto</h1></div>
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
</body>
</html>