<?php 
include '../../DB/DB.php';
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
		<span class="fa-stack fa-lg btn-white reload" onclick="location.reload(true)">
			<i class="fa fa-square fa-stack-2x"></i>
			<i class="fa fa-repeat fa-stack-1x fa-inverse"></i>
		</span>
	</div>
	<table>
		<tr class='log'>
			<th>Fecha</th>
			<th>Usuario</th>
			<th>Acción</th>
			<th>Database Table</th>
			<th>Descripción</th>
		</tr>
		<?php
		if (!isset($error)) {
			$articles = $DataBase->obteLogOrderBy('date', 'desc');
			foreach($articles as $article){
				$article->mostraTr();
			}
    }
		?>
	</table>
</div>