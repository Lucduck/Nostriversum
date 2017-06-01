<?php
include '../../DB/DB.php';
// Recuperem la informació de la sessió
session_start();
// i comprovem que s'usuari s'ha identificat
if (!isset($_SESSION['usuari'])) {
  header("Location: ../index.php");
}
if(empty($_POST['planetS'])){
    header("Location: ../backend.php");
}
try {
  $DataBase = new DB();
}catch (PDOException $e) {
  $error = $e->getCode();
  $missatge = $e->getMessage();
}
if (isset($error)) {
  die("Error: connection failed");
}
if (!$DataBase->activatedUser($_SESSION['usuari'])) {
  header("Location: ../index.php");
}
// Actualizar la ultima connexion
$DataBase->UpdateUsuari_connection($_SESSION['usuari']);

if (isset($_POST['delete'])){
  $DataBase->DeleteSatellite($_POST['satellite']);
}
$error = null;
// SAVE ARTICLE
if (isset($_POST['save'])){
	$name = $_POST['planet'];
	$color = $_POST['color'];
	$text = $_POST['text'];
	$diameter = $_POST['size'];
	$distance_sun = $_POST['orbit'];
	$orbital_period = $_POST['period'];
	$rings = $_POST['rings'];
	$size_rings = $_POST['size_rings'];

	//Image
	$image = null;
	if(isset($_FILES['imagePlanet']))
		$image = $DataBase->getImage($_FILES['imagePlanet']);

	if($error == null){
		$DataBase->UpdatePlanet($name, $image, $color, $text, $diameter, $distance_sun, $orbital_period, $rings, $size_rings);
	}
}
?>

<!DOCTYPE html>
<html lang="">
<head>
  <meta charset="UTF-8">
  <link rel="shortcut icon" href="../img/favicon.ico">
  <!-- PARA MOVILES -->
  <meta name='viewport' content='width=device-width, user-scalable=no, initial-scale=1, maximum-scale=0.9, minimum-scale=0.9'>

  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>BACKEND N</title>

  <!-- CSS -->
  <?php 
    $_SESSION['usuari']->getTheme()->printPlantilla();
  ?>
  <link rel="stylesheet" type="text/css" href="../css/style.css">

  <!-- FONTS -->
  <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
  <link href="https://fonts.googleapis.com/css?family=Montserrat+Subrayada" rel="stylesheet">

  <!-- ICONS AWESOME -->
  <link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' type='text/css' rel='stylesheet'>

  <!-- JQUERY -->
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
</head>

<body style="background-color: rgb(25, 29, 45)">
	<button onclick='window.location.href = "../backend.php"' class='btn-behind'><i class="fa fa-home" aria-hidden="true"></i></button>
  <div class="contentPlanets">
		<div class="planets" style="width: 50%; position: relative">
			<ul class="solarSystem">
			<?php
				$planet = $DataBase->getPlanet($_POST['planetS']);
				$planet->printPlanetCenter();

				$satellites = $DataBase->getSatellites($_POST['planetS']);
				foreach($satellites as $satellite){
					$satellite->printSatellite();
				}
			?>
			</ul>
      <input id='scale' class='inputRangeScale' type='range' value='1.5' min='0' max='3' step='.01'>
		</div>
		<div class="settings" style="max-width: none; padding: 0">
			<h1 style="text-transform: capitalize"><?php echo $planet->getName(); ?></h1>
      <?php
        foreach($satellites as $satellite){
          $satellite->printBtn();
        }
      ?>
      <form action='satellite.php' method='post'>
        <input type='hidden' name='planetS' value='<?php echo $planet->getName(); ?>'>
        <button class='satellite' type='submit' name='new'><i class='fa fa-plus' aria-hidden='true'></i></button>
      </form>
		</div>
  </div>
</body>
