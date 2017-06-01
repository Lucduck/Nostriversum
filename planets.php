<?php 
include 'DB/DB.php';
try {
  $DataBase = new DB();
}catch (PDOException $e) {
  $error = $e->getCode();
  $missatge = $e->getMessage();
}
if (isset($error)) {
	die("Error: connection failed");
}
?>
<!DOCTYPE html>
<html lang="">

<head>
	<meta charset="UTF-8">
	<link rel="shortcut icon" href="img/favicon.ico">
	<!-- PARA MOVILES -->
    <meta name='viewport' content='width=device-width, user-scalable=no, initial-scale=1, maximum-scale=0.9, minimum-scale=0.9'>
    
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>NOSTRIVERSUM</title>

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="css/style.css">

	<!-- FONTS -->
	<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
	<link href="https://fonts.googleapis.com/css?family=Montserrat+Subrayada" rel="stylesheet">

	<!-- ICONS AWESOME -->
	<link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css' type='text/css' rel='stylesheet'>

	<!-- JQUERY -->
	<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>

	<!--  JS  -->
	<script src="js/js.js"></script>
	<script src="js/Parallax.js"></script>
</head>

<body style="background-color: rgb(25, 29, 45)">
  <div class="contentPlanets">
		<div class="planets">
			<ul class="solarSystem">
			<?php
				if(!isset($_POST['planet']) && !isset($_POST['satellite'])){
					$planets = $DataBase->getPlanets();
					foreach($planets as $planet){
						$planet->printPlanet();
					}
				}
				if(isset($_POST['planet'])){
					$planet = $DataBase->getPlanet($_POST['planet']);
					$planet->printPlanetCenter();

					$satellites = $DataBase->getSatellites($_POST['planet']);
					foreach($satellites as $satellite){
						$satellite->printSatellite();
					}
				}
			?>
			</ul>
		</div>
		<div class="list">
			<?php
				if(!isset($_POST['planet']) && !isset($_POST['satellite'])){
					foreach($planets as $planet){
						$planet->printBtnFrontend();
					}
				}
				if(isset($_POST['planet'])){
						$planet->printBtnFrontend();
						foreach($satellites as $satellite){
							$satellite->printBtnFrontend();
						}
			?>
				<button class='planet' onclick='window.location.href = "planets.php"'>
					<i style='color: {$this->color}; width: 50px;position: initial;' class='fa fa-arrow-left fa-stack-1x fa-inverse' style='font-size: 11px'></i>
				</button> 
			<?php 
				} 
			?>
		</div>
		<input id='scale' class='inputRange' type='range' value='1' min='0' max='3' step='.01'>
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
		</script>
		<?php
			if(isset($_POST['planet'])){
				if(isset($_POST['satellite'])){
					$satellite = $DataBase->getSatellite($_POST['satellite']);
					$name = $satellite->getName();
					$image = $satellite->getImage64_encode();
					$text = $satellite->getText();
					$color = $satellite->getColor();
				} else {
					$name = $planet->getName();
					$image = $planet->getImage64_encode();
					$text = $planet->getText();
					$color = $planet->getColor();
				}
		?>
		<div class="info">
			<i style='color: <?php echo $color ?>' class='fa fa-circle fa-stack-1x fa-inverse'></i>
			<div class="cont">
				<h1><?php echo $name; ?></h1>
				<img src='data:image/jpeg;base64, <?php echo $image; ?>' alt='user'/>
				<div class="text">
					<?php echo $text; ?>
				</div>
			</div>
		</div>
		<?php
			}
		?>
  </div>
</body>
</html>