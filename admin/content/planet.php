<?php
include '../../DB/DB.php';
// Recuperem la informació de la sessió
session_start();
// i comprovem que s'usuari s'ha identificat
if (!isset($_SESSION['usuari'])) {
  header("Location: ../index.php");
}
if(empty($_POST['planet']) && !isset($_POST['new'])){
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


$error = null;
if (isset($_POST['delete'])){
	$DataBase->DeletePlanet($_POST['planet']);
	header("Location: ../backend.php");
}

// SAVE ARTICLE
if (isset($_POST['add'])){
	$name = $_POST['planet'];
	$image = $DataBase->getImage($_FILES['imagePlanet']);
	$color = $_POST['color'];
	$text = $_POST['text'];
	$diameter = $_POST['size'];
	$distance_sun = $_POST['orbit'];
	$orbital_period = $_POST['period'];
	$rings = $_POST['rings'];
	$size_rings = $_POST['size_rings'];

	if($error == null){
		$DataBase->InsertPlanet($name, $image, $color, $text, $diameter, $distance_sun, $orbital_period, $rings, $size_rings);
	}
}
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

  <!--  JS  -->
</head>

<body style="background-color: rgb(25, 29, 45)">
  <button onclick='window.location.href = "../backend.php"' class='btn-behind'><i class="fa fa-home" aria-hidden="true"></i></button>
  <div class="contentPlanets">
		<div class="planets" style="width: calc(100% - 650px); position: relative">
			<ul class="solarSystem">
			<?php
				$planets = $DataBase->getPlanets();

				$orbit = 90;
				foreach($planets as $planet){
					$planet->printPlanetEdit();
					$orbit = 90 + $planet->getOrbit();
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
									.new > .planet{
										width: 10px;
										height: 10px;
										top: -5px;
										left: calc(50% - 5px);
										background: #aaa;
									}
								</style>";
					echo "<li class='new'>
								  <span class='planet'></span>
								</li>";
				}
			?>
			</ul>
		</div>
			<input id='scale' class='inputRangeScale' type='range' value='1.5' min='0' max='3' step='.01'>
		<div class="settings">
			<?php
				if(isset($_POST['new'])){
					$name = "Nuevo";
					$orbital_period = "";
					$distance_sun = $orbit / 2;
					$diameter = 10;
					$color = "#aaaaaa";
					$text = "";
					$rings = 0;
					$size_rings = 0;
				} else {
					$planet = $DataBase->getPlanet($_POST['planet']);
					$name = $planet->getName();
					$image = $planet->getImage64_encode();
					$orbital_period = $planet->getOrbitalPeriod();
					$distance_sun = $planet->getDistanceSun();
					$diameter = $planet->getDiameter();
					$color = $planet->getColor();
					$text = $planet->getText();
					$rings = $planet->getRings();
					$size_rings = $planet->getSizeRings();
				}

				echo "<form enctype='multipart/form-data' action='planet.php' method='post'>
								<h1>{$name}</h1>";
				if(isset($_POST['new'])){
					echo "<p>Nombre</p>
								<input class='input-text' type='text' name='planet' required>";
					echo "<input class='input-text' type='file' name='imagePlanet' required>";
				} else {
					echo "<input type='hidden' name='planet' value='{$name}'>";
					echo "<p>Imagen actual</p>
								<div class='image'>
									<img src='data:image/jpeg;base64, {$image}' alt='user'/>
									<input type='file' name='imagePlanet'>
								</div>";
				}

				echo "	<div class='seperator'></div>
								
								<p>Período orbital sideral (en días)</p>
								<input id='{$name}period' class='number' type='number' name='period' min='0' value='{$orbital_period}' step='any' required>
								
								<p>Tamaño de órbita</p>
								<input id='{$name}orbitrange' class='inputRange' planet='{$name}' name='orbit' type='range' value='{$distance_sun}' min='0' max='500'>
								
								<p>Tamaño del planeta</p>
								<input id='{$name}sizerange' class='inputRange' planet='{$name}' name='size' type='range' value='{$diameter}' min='0' max='50'>
								
								<p>Color del planeta</p>
								<input id='{$name}color' class='color inputRange' planet='{$name}' type='color' name='color' value='{$color}'>
								
								<div class='seperator'></div>

								<p>Cantidad de anillos</p>
								<input id='{$name}numrings' class='number' planet='{$name}' type='number' name='rings' min='0' value='{$rings}'>
								
								<p>Tamaño de los anillos</p>
								<input id='{$name}sizerings' class='number' planet='{$name}' type='number' name='size_rings' min='0' value='{$size_rings}'>
								<!--<div style='width: 20%' class='btn' onclick='ringsChange(this)' planet='{$name}'>Mostrar anillos</div>-->
								
								<p>Texto (html)</p>
								<textarea class='text' name='text' maxlength='5000' required>{$text}</textarea>";
							
				if(isset($_POST['new'])){
					echo "<input style='margin: 20px 0' class='btn' type='submit' name='add' value='Guardar'>";
				} else {
					echo "<input style='margin: 20px 0' class='btn' type='submit' name='save' value='Guardar'>";
				}

				echo "</form>
							<form action='../backend.php' method='post'>
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
    $('#scale').bind('input', function(){
      scale($('#scale'))
    }).bind('change', function(){
      scale($('#scale'))	/* for IE */
    });
    function scale(e){
      let value = $(e).val()
      let scale = 'scale(' + value + ')'

      $('.contentPlanets .planets').css('transform', scale)
    }

function orbitRange(e){
	let value = $(e).val()
	let planet = $(e).attr('planet')
  let size = 'calc('+value+'px * 2)'
  let position = 'calc(-'+value+'px - 2px)'

	$('.'+planet).css('width', size)
               .css('height', size)
               .css('top', position)
               .css('left', position)
}

function sizeRange(e){
	let value = $(e).val()
	let planet = $(e).attr('planet')
  let size = value + 'px'
  let radius = value / 2
  let top = '-'+radius+'px'
  let left = 'calc(50% - '+radius+'px)'

	$('.'+planet+' > .planet').css('width', size)
														.css('height', size)
														.css('top', top)
														.css('left', left)
}

function colorChange(e){
	let color = $(e).val()
	let planet = $(e).attr('planet')

	$('.'+planet+' > .planet').css('background-color', color)
	$('.'+planet+' span.ring').css('border-color', color)
}

// AUN  NO HACE NADA, LO ARE AL FINAL?
function ringsChange(e){
	let planet = $(e).attr('planet')
	let num = $('#'+planet+'numrings').val()
	let size = $('#'+planet+'sizerings').val()
	console.log(num)
	console.log(size)
	console.log(planet)
	// let color = $(e).val()
	// let planet = $(e).attr('planet')

	// $('.'+planet+' > .planet').css('background-color', color)
	// $('.'+planet+' span.ring').css('border-color', color)
}
</script>
