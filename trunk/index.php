<!DOCTYPE html>
<html lang="fr">
<head>
	<title>Archi Velo</title>
	<link rel="stylesheet" href="style.css" type="text/css"/>
	<meta http-equiv="Content-Type" content="text/html;" charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<div class="container">
		<h1>Toto</h1>
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
					<tr><th class="col-md-4">Nom</th><th class="col-md-4">Nombre de places libres</th><th class="col-md-4">Nombre de vélos disponibles</th></tr>
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
							echo '<tr><td class="col-md-4"><b>'.ucwords($nom_encode).' :</b><br>'.ucwords($adresse_good).'</td><td class="col-md-4">'.$nbVelos.'</td><td class="col-md-4">'.$nbPlaceLibre.'</td></tr>';
						}
					?>
				</table>
			</div>
		</div>
	</div>
</body>
</html>