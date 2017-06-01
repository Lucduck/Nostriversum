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

// DELETE ARTICLE
if (isset($_POST['delete-article'])) {
		$DataBase->DeleteArticle($_POST['article']);
    header("Location: ../backend.php");
}

$error = "";
if (isset($_POST['add']) || isset($_POST['save'])){
	//Title
  if(isset($_POST['title']))
		$title = $_POST['title'];
  else
		$error .= "Write a title<br>";

	//Text
  if(isset($_POST['text']))
		$text = $_POST['text'];
  else
		$error .= "Write content<br>";
		
	//Image
	$image = $DataBase->getImage($_FILES['photo']);
}


// SAVE ARTICLE
if (isset($_POST['add'])) {
	if($error == ""){
		$DataBase->InsertarArticle($title, $image, $text);
		header("Location: ../backend.php");
	}
}
if (isset($_POST['save'])) {
	$DataBase->UpdateArticle($_POST['article'], $title, $image, $text);
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
		<form enctype="multipart/form-data" action='article.php' method='post'>
			<table>
				<tr>
					<th colspan='2'>
						<?php
							// add Article
							if (isset($_POST['add-article'])) {
									echo ("<h1>Añadir</h1>");
							}
							// Edit Article
							if (isset($_POST['edit-article']) || isset($_POST['save'])) {
									echo ("<h1>Editar</h1>");
									$article = $DataBase->obteArticle($_POST['article']);
									echo "<input type='hidden' name='article' value='{$article->getId()}'>";
									$editar = true;
							}
						?>
					</th>
				</tr>
				<?php
				if($error != "")
					echo "<tr><th colspan='2'>{$error}</th></tr>";
				?>
				<tr>
					<td>
						<p>Título</p>
						<input class="inp" type='title' name='title' value='<?php if($editar) echo $article->getTitle(); ?>' required>
					</td>
				 	<?php if($editar){
						 $imagee = base64_encode($article->getImage());
						echo "<td rowspan='2'>
									<p>Imagen actual</p>
									<img src='data:image/jpeg;base64, {$imagee}'  alt='user'/>
								</td>";
					 }
					?>
				</tr>
				<tr>
					<td>
						<p>Imagen</p>
						<input class="inp" type='file' name='photo' <?php if(!$editar) echo 'required'; ?>>
					</td>
				</tr>
				<tr>
					<td colspan='2'>
						<p>Texto</p>
						<textarea name="text" maxlength="5000" required><?php if($editar) echo($article->getText());?></textarea>
					</td>
				</tr>
				<tr>
					<td colspan='2'>
						<?php
							// add Article
							if (isset($_POST['add-article'])) {
									echo "<input type='submit' name='add' class='btn' value='Guardar'>";
							}
							// Edit Article
							if (isset($_POST['edit-article']) || isset($_POST['save'])) {
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
