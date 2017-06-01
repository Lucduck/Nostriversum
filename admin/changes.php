<?php
include '../DB/DB.php';
// Recuperem la informació de la sessió
session_start();
// i comprovem que s'usuari s'ha identificat
if (!isset($_SESSION['usuari'])) {
  header("Location: index.php");
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
  header("Location: index.php");
}


/* CONFIGURACION */
$msg = 'OK';
if (isset($_POST['settings'])) {
  $user = $_POST['user'];
  $mail = $_POST['mail'];
  $theme = $_POST['theme'];

  $image = $DataBase->getImage($_FILES['photo']);

  $DataBase->updateUsuariSettings($user, $mail, $theme, $image);
}

/* TERMINAR */
$_SESSION['usuari'] = $DataBase->getUsuari($_SESSION['usuari']->getName());
header("Location: backend.php");
