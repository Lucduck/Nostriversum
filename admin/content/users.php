<?php 
include '../../DB/DB.php';
// Recuperem la informació de la sessió
session_start();
if (!isset($_SESSION['usuari'])) {
  header("Location: ../index.php");
}
$_SESSION['page'] = basename($_SERVER['PHP_SELF']);

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
?>
<div class="contentArticles">
	<div class="top">
		<form action='content/user.php' method='post'>
			<span class="fa-stack fa-lg btn-white add">
				<i class="fa fa-square fa-stack-2x"></i>
				<i class="fa fa-plus fa-stack-1x fa-inverse"></i>
				<input type='submit' name='add-user' value=' '/>
			</span>
		</form>
		<span class="fa-stack fa-lg btn-white reload" onclick="insertContent('users.php')">
			<i class="fa fa-square fa-stack-2x"></i>
			<i class="fa fa-repeat fa-stack-1x fa-inverse"></i>
		</span>
	</div>
	<table>
		<tr>
			<th>Nombre</th>
			<th>Último acceso</th>
			<th></th>
			<th></th>
		</tr>
		<?php
		if (!isset($error)) {
			$users = $DataBase->getUsuaris();
			foreach($users as $user){
				$user->printTr();
			}
    }
		?>
	</table>
</div>