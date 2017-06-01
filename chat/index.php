<?php
// incluir la clase DB
include '../DB/DB.php';
session_start();
if(isset($_POST['exit'])){
	$_SESSION['nostriversum_user_chat'] = null;
	header("Location: index.php");
}
if (isset($_POST['backend_chat'])) {
    $_SESSION['nostriversum_user_chat'] = $_SESSION['usuari'];
}
if (isset($_SESSION['nostriversum_user_chat'])) {
    header("Location: chat.php");
}
// Comprovem si ja s'ha enviat el formulari
if (isset($_POST['entrar'])) {
    //inicio una variable amb la calse de DB()
    try {
        $DataBase = new DB();
	}catch (PDOException $e) {
    	$error = $e->getCode();
        $missatge = $e->getMessage();
    }
    
	if (!isset($error)) {
		$usuari = $_POST['username'];
		$password = $_POST['password'];
		if (empty($usuari) || empty($password)) {
			$error = "Has d'introduir un nom d'usuari i una contrasenya";
		} else {
	// Executem la consulta per comprovar les credencials
			if ($DataBase->verificaUsuari($usuari, $password)) {
				$user = $DataBase->getUsuari($usuari);
				if ($DataBase->activatedUser($user)) {
					$_SESSION['nostriversum_user_chat'] = $user;
					
					header("Location: chat.php");
				} else {
					$error = "Usuari desactivat!";
				}
			} else {
			// Si les credencials no són correctes les tornem a demanar
				$error = "Usuari o contraseña no valids!";
			}
		}
	} else {
		$error = "No s'ha pogut connectar amb la base de dades";
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="shortcut icon" href="img/favicon.ico">
	<title>NOSTRIVERSUM</title>
	<!-- PARA MOVILES -->
    <meta name='viewport' content='width=device-width, user-scalable=no, initial-scale=1, maximum-scale=0.9, minimum-scale=0.9'>
    

	<!-- Icons and text -->
	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="css/login.css" rel="stylesheet">

	<!-- JQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<!-- MATERIALIZE -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.1/css/materialize.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.1/js/materialize.min.js"></script>
</head>

<body>
	<div class="row z-depth-3">
		<p> <?php if (!empty($error)) {echo "<div class='error'>".$error."</div>";} ?> </p>
		<form class="col s12" action='index.php' method='post'>
			<p class="title_log_normal">NOSTRIVERSUM account</p>
			<div>
				<div class="input-field col s12">
					<input id="username" type="text" name="username">
					<label for="username"><i class="fa fa-user" aria-hidden="true"></i> Username</label>
				</div>
			</div>
			<div>
				<div class="input-field col s12">
					<input id="password" type="password" name="password">
					<label for="password"><i class="fa fa-lock" aria-hidden="true"></i> Password</label>
				</div>
			</div>
			<div class="row">
				<div class="input-field col button_s6">
					<input type='submit' name='entrar' value='Log in' class="waves-effect waves-light btn-large"/>
				</div>
			</div>
		</form>
	</div>
</body>

</html>