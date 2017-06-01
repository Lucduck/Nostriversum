<?php
include '../../DB/DB.php';
// Recuperem la informació de la sessió
session_start();
// i comprovem que s'usuari s'ha identificat
if (!isset($_SESSION['usuari'])) {
  header("Location: ../index.php");
}
if(empty($_POST['satellite']) && !isset($_POST['new'])){
	die('hola');
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
// Actualizar la ultima conexión
$DataBase->UpdateUsuari_connection($_SESSION['usuari']);

$error = null;
// SAVE ARTICLE
if (isset($_POST['add'])){
	$name = $_POST['satellite'];
	$planet_name = $_POST['planetS'];
	$color = $_POST['color'];
	$text = $_POST['text'];
	$diameter = $_POST['size'];
	$distance_planet = $_POST['orbit'];
	$orbital_period = $_POST['period'];
	$image = $DataBase->getImage($_FILES['imageSatellite']);

	if($error == null){
		$DataBase->InsertarSatellite($name, $planet_name, $image, $color, $text, $diameter, $distance_planet, $orbital_period);
	}
}
if (isset($_POST['save'])){
	$name = $_POST['satellite'];
	$planet_name = $_POST['planetS'];
	$color = $_POST['color'];
	$text = $_POST['text'];
	$diameter = $_POST['size'];
	$distance_planet = $_POST['orbit'];
	$orbital_period = $_POST['period'];

	//Image
	$image = null;
	if(isset($_FILES['imageSatellite']))
		$image = $DataBase->getImage($_FILES['imageSatellite']);

	if($error == null){
		$DataBase->UpdateSatellite($name, $planet_name, $image, $color, $text, $diameter, $distance_planet, $orbital_period);
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

  <!--  JS  -->
</head>

<body style="background-color: rgb(25, 29, 45)">
	<form action='satellites.php' method='post'>
		<input type='hidden' name='planetS' value='<?php echo $_POST['planetS']; ?>'>
		<button type="submit" class='btn-behind'><i class="fa fa-arrow-left" aria-hidden="true"></i></button>
  </form>
  <div class="contentPlanets">
		<div class="planets" style="width: calc(100% - 650px); position: relative">
			<ul class="solarSystem">
			<?php
				$planet = $DataBase->getPlanet($_POST['planetS']);
				$planet->printPlanetCenter();

				$orbit = 90;
				$satellites = $DataBase->getSatellites($_POST['planetS']);
				foreach($satellites as $satellite){
					$satellite->printSatelliteEdit();
					$orbit = 90 + $satellite->getOrbit();
				}
				if(isset($_POST['new'])){
					$orbit_pos = ($orbit / 2) + 2;
					echo "<style>
									.new{
										width: {$orbit}px;
										height: {$orbit}px;
										top: -{$orbit_pos}px;
										left: -{$orbit_pos}px;
									}
									.new > .satellite{
										width: 10px;
										height: 10px;
										top: -5px;
										left: calc(50% - 5px);
										background: #aaa;
									}
								</style>";
					echo "<li class='new'>
								  <span class='satellite'></span>
								</li>";
				}
			?>
			</ul>
			<input id='scale' class='inputRangeScale' type='range' value='1.5' min='0' max='3' step='.01'>
		</div>
		<div class="settings">
			<?php
				if(isset($_POST['new'])){
					$name = "Nuevo";
					$planet_name = $_POST['planetS'];
					$orbital_period = "";
					$distance_planet = $orbit / 2;
					$diameter = 10;
					$color = "#aaaaaa";
					$text = "";
				} else {
					$satellite = $DataBase->getSatellite($_POST['satellite']);
					$name = $satellite->getName();
					$planet_name = $satellite->getNamePlanet();
					$image = $satellite->getImage64_encode();
					$orbital_period = $satellite->getOrbitalPeriod();
					$distance_planet = $satellite->getDistancePlanet();
					$diameter = $satellite->getDiameter();
					$color = $satellite->getColor();
					$text = $satellite->getText();
				}

				echo "<form enctype='multipart/form-data' action='satellite.php' method='post'>
								<h1>{$name}</h1>
								<input type='hidden' name='planetS' value='{$planet_name}'>";
				if(isset($_POST['new'])){
					echo "<p>Nombre</p>
								<input class='input-text' type='text' name='satellite' required>";
					echo "<input class='input-text' type='file' name='imageSatellite' required>";
				} else {
					echo "<input type='hidden' name='satellite' value='{$name}'>";
					echo "<p>Imagen actual</p>
								<div class='image'>
									<img src='data:image/jpeg;base64, {$image}' alt='user'/>
									<input type='file' name='imageSatellite'>
								</div>";
				}
				echo "	<div class='seperator'></div>
								
								<p>Período orbital sideral (en días)</p>
								<input id='{$name}period' class='number' type='number' name='period' min='0' value='{$orbital_period}' step='any' required>
								
								<p>Tamaño de órbita</p>
								<input id='{$name}orbitrange' class='inputRange' satellite='{$name}' name='orbit' type='range' value='{$distance_planet}' min='0' max='500'>
								
								<p>Tamaño del satélite</p>
								<input id='{$name}sizerange' class='inputRange' satellite='{$name}' name='size' type='range' value='{$diameter}' min='0' max='50'>
								
								<p>Color del satélite</p>
								<input id='{$name}color' class='color inputRange' satellite='{$name}' type='color' name='color' value='{$color}'>
								
								<p>Texto (html)</p>
								<textarea class='text' name='text' maxlength='5000' required>{$text}</textarea>";
				
				if(isset($_POST['new'])){
					echo "<input style='margin: 20px 0' class='btn' type='submit' name='add' value='Guardar'>";
				} else {
					echo "<input style='margin: 20px 0' class='btn' type='submit' name='save' value='Guardar'>";
				}

				echo "</form>
							<form action='satellites.php' method='post'>
								<input type='hidden' name='planetS' value='{$planet_name}'>
								<input type='submit' class='btn red' value='Regresar'>
							</form>";
								
					echo "<script>
									$('#{$name}color').bind('input', function(){
										colorChange($('#{$name}color'))
									}).bind('change', function(){
										colorChange($('#{$name}color'))	/* for IE */
									});
									$('#{$name}orbitrange').bind('input', function(){
										orbitRange($('#{$name}orbitrange'))
									}).bind('change', function(){
										orbitRange($('#{$name}orbitrange'))	/* for IE */
									});
									$('#{$name}sizerange').bind('input', function(){
										sizeRange($('#{$name}sizerange'))
									}).bind('change', function(){
										sizeRange($('#{$name}sizerange'))	/* for IE */
									});
								</script>";
			?>
		</div>
  </div>
</body>
<script>

function orbitRange(e){
	let value = $(e).val()
	let satellite = $(e).attr('satellite')
  let size = 'calc('+value+'px * 2)'
  let position = 'calc(-'+value+'px - 2px)'

	$('.'+satellite).css('width', size)
               .css('height', size)
               .css('top', position)
               .css('left', position)
}

function sizeRange(e){
	let value = $(e).val()
	let satellite = $(e).attr('satellite')
  let size = value + 'px'
  let radius = value / 2
  let top = '-'+radius+'px'
  let left = 'calc(50% - '+radius+'px)'

	$('.'+satellite+' > .satellite').css('width', size)
                                  .css('height', size)
                                  .css('top', top)
                                  .css('left', left)
}

function colorChange(e){
	let color = $(e).val()
	let satellite = $(e).attr('satellite')

	$('.'+satellite+' > .satellite').css('background-color', color)
}
</script>
