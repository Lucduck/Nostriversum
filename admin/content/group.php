<?php
include '../../DB/DB.php';
// Recuperem la informació de la sessió
session_start();
// i comprovem que s'usuari s'ha identificat
if (!isset($_SESSION['usuari'])) {
  header("Location: ../index.php");
}
if(empty($_POST)){
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

// DELETE Group
if (isset($_POST['delete-group'])) {
	$DataBase->DeleteGroup($_POST['group']);
    header("Location: ../backend.php");
}

if (isset($_POST['add']) || isset($_POST['save'])){
	$name = $_POST['name'];
	$articles = $_POST['articles'];
	$info = $_POST['info'];
	$planets = $_POST['planets'];
	$satellites = $_POST['satellites'];
	$log = $_POST['log'];
	$users = $_POST['users'];
	$groups = $_POST['groups'];

	// SAVE Group
	if (isset($_POST['add'])) {
		$DataBase->InsertGroup($name, $articles, $info, $planets, $satellites, $log, $users, $groups);
		header("Location: ../backend.php");
	} else {
		$DataBase->UpdateGroup($_POST['group'], $name, $articles, $info, $planets, $satellites, $log, $users, $groups);
		$_POST['group'] = $name;
	}
}


$editar = false;
?>
<!DOCTYPE html>
<html>
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
  <link rel="stylesheet" type="text/css" href="../css/styleAE.css">

  <!-- FONTS -->
  <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>

  <!-- ICONS AWESOME -->
  <link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' type='text/css' rel='stylesheet'>
</head>

<body>
	<button onclick='window.location.href = "../backend.php"' class='btn-behind'><i class="fa fa-home" aria-hidden="true"></i></button>
	<div class='content'>
		<form enctype="multipart/form-data" action='group.php' method='post'>
			<table>
				<tr>
					<th colspan='2'>
						<?php
							// Add Group
							if (isset($_POST['add-group'])) {
									echo ("<h1>Añadir grupo</h1>");
							}
							// Edit Group
							if (isset($_POST['edit-group']) || isset($_POST['save'])) {
									echo ("<h1>Editar grupo</h1>");
									$group = $DataBase->getGroup($_POST['group']);
									echo "<input type='hidden' name='group' value='{$group->getName()}'>";
									$editar = true;
							}
						?>
					</th>
				</tr>
				<!--<tr>
					<td colspan='2'>
						<p><strong>Group name</strong><?php if($editar) echo ": {$group->getName()}";?></p>
						<?php if(!$editar) echo "<input class='inp' type='text' name='name' value='' required>"; ?>
					</td>
				</tr>-->
				<tr>
					<td colspan='2'>
						<p><strong>Nombre del grupo</strong></p>
						<input class="inp" type='text' name='name' value='<?php if($editar) echo $group->getName(); ?>' required>
					</td>
				</tr>
				<?php
					if($editar){
						$actArticles = $group->getArticles();
						$actInfo = $group->getInfo();
						$actPlanets = $group->getPlanets();
						$actSatellites = $group->getSatellites();
						$actLog = $group->getLog();
						$actUsers = $group->getUsers();
						$actGroups = $group->getGroups();
					} else {
						$actArticles = 0;
						$actInfo = 1;
						$actPlanets = 0;
						$actSatellites = 0;
						$actLog = 0;
						$actUsers = 0;
						$actGroups = 0;
					}
				?>
				<tr>
					<td colspan='2'>
						<p><strong>Permisos</strong></p>
					</td>
				</tr>
				<tr>
					<td>
						<p class='right'>Artículos</p>
					</td>
					<td>
						<select class='inp' name='articles'>
							<option value="1" <?php if($actArticles) echo 'selected'; ?>>Si</option>
							<option value="0" <?php if(!$actArticles) echo 'selected'; ?>>No</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<p class='right'>Información</p>
					</td>
					<td>
						<select class='inp' name='info'>
							<option value="1" <?php if($actInfo) echo 'selected'; ?>>Si</option>
							<option value="0" <?php if(!$actInfo) echo 'selected'; ?>>No</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<p class='right'>Planetas</p>
					</td>
					<td>
						<select class='inp' name='planets'>
							<option value="1" <?php if($actPlanets) echo 'selected'; ?>>Si</option>
							<option value="0" <?php if(!$actPlanets) echo 'selected'; ?>>No</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<p class='right'>Satélites</p>
					</td>
					<td>
						<select class='inp' name='satellites'>
							<option value="1" <?php if($actSatellites) echo 'selected'; ?>>Si</option>
							<option value="0" <?php if(!$actSatellites) echo 'selected'; ?>>No</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<p class='right'>Registro</p>
					</td>
					<td>
						<select class='inp' name='log'>
							<option value="1" <?php if($actLog) echo 'selected'; ?>>Si</option>
							<option value="0" <?php if(!$actLog) echo 'selected'; ?>>No</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<p class='right'>Usuarios</p>
					</td>
					<td>
						<select class='inp' name='users'>
							<option value="1" <?php if($actUsers) echo 'selected'; ?>>Si</option>
							<option value="0" <?php if(!$actUsers) echo 'selected'; ?>>No</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<p class='right'>Grupos</p>
					</td>
					<td>
						<select class='inp' name='groups'>
							<option value="1" <?php if($actGroups) echo 'selected'; ?>>Si</option>
							<option value="0" <?php if(!$actGroups) echo 'selected'; ?>>No</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan='2'>
						<?php
							// Add Group
							if (isset($_POST['add-group'])) {
									echo "<input type='submit' name='add' class='btn' value='Guardar'>";
							}
							// Edit Group
							if (isset($_POST['edit-group']) || isset($_POST['save'])) {
									echo "<input type='submit' name='save' class='btn' value='Guardar'>";
							}
						?>
						
					</td>
				</tr>
				<tr>
					<td colspan='2'>
						<input onclick='window.location="../backend.php"' class="btn red" value="Regresar">
					</td>
				</tr>
			</table>
		</form>
	</div>
</body>
</html>
