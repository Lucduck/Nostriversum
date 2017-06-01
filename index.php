<?php include 'DB/DB.php'; ?>
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

<body>
	<div class="burger-icon">
		<div class="click"></div>
		<span></span>
	</div>

	<div class="burger-bubble">
		<h2 menu="#home">INICIO</h2>
		<h2 onclick='location.href="planets.php"'>MAPA</h2>
		<h2 menu="#curiosities">CURIOSIDADES</h2>
		<h2 menu="#aboutMe">SOBRE MI</h2>
		<h2 menu="#contact">CONTACTO</h2>
		<p>2017 © Lucas Pérez González</p>
	</div>

	<header id="home" class="home">
		<img class="planet" id="planet-red" src="img/Planet-red.png" alt="">
		<img class="planet" id="planet-blue" src="img/Planet-blue.png" alt="">
		<img class="planet" id="planet-green" src="img/Planet-green.png" alt="">
		<img class="planet" id="planet-purple" src="img/Planet-purple.png" alt="">
		<img class="planet" id="planet-skyBlue" src="img/Planet-skyBlue.png" alt="">
		<h1>NOSTRIVERSUM</h1>
		<img class="planet-btm" src="img/astronauta-planet-bottom.png" alt="planet-btm">
	</header>

	<div id="curiosities" class="curiosities section">
        <?php // CARDS
            try {
                $DataBase = new DB();
            } catch (PDOException $e) {
                $error = $e->getCode();
                $missatge = $e->getMessage();
            }
            if (!isset($error)) {
                $articles = $DataBase->obteArticles();
                foreach($articles as $article){
                    $article->mostraCard();
                }
            }
        ?>

	</div>

	<div id="pr-space-1" class="parallax section">
		<div class="window-space" data-type="parallax"></div>
		<div class="window-border"></div>
	</div>

	<div id="aboutMe" class="aboutMe section">
		<h1>SOBRE MI</h1>
		<p>Soy Lucas Pérez, programador web. Hace unos años empece a estudiar programación, ahora acabo y hago esta pagina para el proyecto de final de curso.</p>
		<br>
		<p>Nostriversum es una pagina donde una persona podrá aprender y entretenerse con la información del sistema solar que contiene.</p>
		<p>Las personas que gestionamos esta pagina, iremos actualizándola y gestionándola para que todas las personas que estén interesadas en todo este tema, estén informadas con la actualidad.</p>
		<br>
		<p>Espero que os guste esta pagina web, que sigáis aprendiendo y que tengáis ganas de descubrir y conocer mas.</p>
	</div>

	<div id="pr-space-2" class="parallax section">
		<div class="window-space" data-type="parallax"></div>
		<div class="window-border"></div>
	</div>

	<div id="contact" class="contact section">

	</div>
</body>

</html>