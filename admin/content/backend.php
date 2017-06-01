<?php 
include '../../DB/DB.php';
// Recuperem la informació de la sessió
session_start();
if (!isset($_SESSION['usuari'])) {
  header("Location: ../index.php");
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
$page = basename($_SERVER['PHP_SELF']);
$_SESSION['page'] = $page;
?>

	<header id="home" class="home">
		<img class="planet" id="planet-red" src="../img/Planet-red.png" alt="">
		<img class="planet" id="planet-blue" src="../img/Planet-blue.png" alt="">
		<img class="planet" id="planet-green" src="../img/Planet-green.png" alt="">
		<img class="planet" id="planet-purple" src="../img/Planet-purple.png" alt="">
		<img class="planet" id="planet-skyBlue" src="../img/Planet-skyBlue.png" alt="">
		<h1>NOSTRIVERSUM</h1>
		<img class="planet-btm" src="../img/astronauta-planet-bottom.png" alt="planet-btm">
	</header>