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

// DELETE User
if (isset($_POST['delete-user'])) {
		$DataBase->DeleteUser($_POST['user']);
    header("Location: ../backend.php");
}

if (isset($_POST['add']) || isset($_POST['save'])){
	//Name and password
	if (isset($_POST['add'])) {
		$name = $_POST['name'];
		$password = $_POST['password'];
	}

	//Mail
	$mail = $_POST['mail'];

	//Group
  	$group = $_POST['group'];

	//activated
  	$activated = $_POST['activated'];
		
	//Image
	$image = $DataBase->getImage($_FILES['photo']);
	if(isset($_POST['add']) && $image == null){
		$errorImg = "Error in the image<br>";
	}


	// SAVE User
	if (isset($_POST['add']) && !isset($errorImg)) {
		$DataBase->InsertarUsuari($name, $mail, $image, $password, $group, $activated);
		header("Location: ../backend.php");
	}
	if (isset($_POST['save'])) {
		$DataBase->UpdateUsuari($_POST['user'], $mail, $image, $group, $activated);
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
		<form enctype="multipart/form-data" action='user.php' method='post'>
			<table>
				<tr>
					<th>
						<?php
							// add user
							if (isset($_POST['add-user'])) {
									echo ("<h1>Añadir</h1>");
							}
							// Edit user
							if (isset($_POST['edit-user']) || isset($_POST['save'])) {
									echo ("<h1>Editar</h1>");
									$user = $DataBase->getUsuari($_POST['user']);
									echo "<input type='hidden' name='user' value='{$user->getName()}'>";
									$editar = true;
							}
						?>
					</th>
				</tr>
				<?php
				if(isset($errorImg))
					echo "<tr><th>{$errorImg}</th></tr>";
				?>
				<tr>
				 	<?php if($editar){
						 $imagee = base64_encode($user->getImage());
						echo "<td class='center'>
									<p>Imagen actual</p>
									<img class='img-user' src='data:image/jpeg;base64, {$imagee}'  alt='user' required/>
								</td>";
					 }
					?>
				</tr>
				<tr>
					<td>
						<p>Nombre<?php if($editar) echo ": <strong>{$user->getName()}</strong>";?></p>
						<?php if(!$editar) echo "<input class='inp' type='text' name='name' value='' required>"; ?>
					</td>
				</tr>
				<?php 
					if(!$editar){
						echo "<tr>
								<td>
									<p>Contraseña</p>
									<input class='inp' type='text' name='password' value='' required>
								</td>
							</tr>";
					}
				?>
				<tr>
					<td>
						<p>Correo electrónico</p>
						<input class="inp" type='mail' name='mail' value='<?php if($editar) echo $user->getMail(); ?>' required>
					</td>
				</tr>
				<tr>
					<td>
						<p>Imagen</p>
						<input class="inp" type='file' name='photo' <?php if(!$editar) echo 'required'; ?>>
					</td>
				</tr>
				<tr>
					<td>
						<p>Grupo</p>
						<?php
							if($editar)
								$user->printSelectGroups($DataBase, 'inp');
							else
								$DataBase->printSelectGroups('inp');
						?>
					</td>
				</tr>
				<?php if(!isset($user) || $user->getName() != 'admin'){ ?>
				<tr>
					<td>
						<p>Activado</p>
						<?php
							if($editar)
								$actUser = $user->getActivated();
							else
								$actUser = 1;
						?>
						<select class='inp' name='activated'>
							<option value="1" <?php if($actUser) echo 'selected'; ?>>Si</option>
							<option value="0" <?php if(!$actUser) echo 'selected'; ?>>No</option>
						</select>
					</td>
				</tr>
				<?php } ?>
				<tr>
					<td>
						<?php
							// add user
							if (isset($_POST['add-user'])) {
									echo "<input type='submit' name='add' class='btn' value='Guardar'>";
							}
							// Edit user
							if (isset($_POST['edit-user']) || isset($_POST['save'])) {
									echo "<input type='submit' name='save' class='btn' value='Guardar'>";
							}
						?>
						
					</td>
				</tr>
				<tr>
					<td>
						<input onclick='window.location="../backend.php"' class="btn red" value="Regresar">
					</td>
				</tr>
			</table>
		</form>
	</div>
</body>
</html>
