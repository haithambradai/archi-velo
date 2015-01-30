
<!DOCTYPE html>
<html>
<head>
	<title>Archi Velo</title>
	<link rel="stylesheet" href="style.css" type="text/css"/>
</head>
<body>
	<div class="container"><h1>Toto</h1></div>
	<?php 
		echo '<h1> Ceci est un Test </h1>'


$response = file_get_contents('https://api.jcdecaux.com/vls/v1/stations?apiKey=05011dd5abfb13c9db88e0f585644d4cac5a416c'); 
//echo $response;

	?>
</body>
</html>
<<<<<<< .mine
<?php 
echo '<h1> Ceci est un Test </h1>';

$response = file_get_contents('https://api.jcdecaux.com/vls/v1/stations?apiKey=05011dd5abfb13c9db88e0f585644d4cac5a416c'); 
echo $response;
?>=======<!DOCTYPE html>
<html>
<head>
	<title>Archi Velo</title>
	<link rel="stylesheet" href="style.css" type="text/css"/>
</head>
<body>
	<div class="container"><h1>Toto</h1></div>
	<?php 
		echo '<h1> Ceci est un Test </h1>'
	?>
</body>
</html>
>>>>>>> .theirs