<?php
include '../DB/DB.php';
// Recuperem la informació de la sessió
session_start();
// i comprovem que s'usuari s'ha identificat
if (!isset($_SESSION['nostriversum_user_chat'])) {
  header('Location: index.php');
}

try {
  $DataBase = new DB();
}catch (PDOException $e) {
  $error = $e->getCode();
  $missatge = $e->getMessage();
}
if (isset($error)) {
  die('Error: connection failed');
}
// Mira si esta activado el usuario, pero tambien sirve para controlar si esta eliminado el usuario.
if (!$DataBase->activatedUser($_SESSION['nostriversum_user_chat'])) {
  header('Location: index.php');
} else {
  $_SESSION['nostriversum_user_chat'] = $DataBase->getUsuari($_SESSION['nostriversum_user_chat']->getName());
}

?>
<!DOCTYPE html>
<html lang=''>

<head>
  <meta charset='UTF-8'>
  <link rel='shortcut icon' href='../img/favicon.ico'>
  <!-- PARA MOVILES -->
  <meta name='viewport' content='width=device-width, user-scalable=no, initial-scale=1, maximum-scale=0.9, minimum-scale=0.9'>

  <meta http-equiv='X-UA-Compatible' content='ie=edge'>
  <title>BACKEND CHAT</title>

  <!-- CSS -->
  <?php 
    $_SESSION['nostriversum_user_chat']->getTheme()->printPlantilla();
  ?>
  <link rel='stylesheet' type='text/css' href='css/style.css'>

  <!-- FONTS -->
  <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
  <link href='https://fonts.googleapis.com/css?family=Montserrat+Subrayada' rel='stylesheet'>

  <!-- ICONS AWESOME -->
  <link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' type='text/css' rel='stylesheet'>

  <!-- JQUERY -->
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>

  <!--  JS  -->
  <script src="../admin/js/before.js"></script>
</head>

<body>
<!-- MENU_TOP -->
  <div class='menu_top'>
    <div class='messages' onclick='insertContent("messages.php")'>
      <i class='fa fa-comments' aria-hidden='true'></i>
    </div>
    <div class='contacts' onclick='insertContent("contacts.php")'>
      <i class='fa fa-users' aria-hidden='true'></i>
    </div>
    <form action='index.php' method='post' class='exit'>    
      <button type='submit' name='exit'>
        <i class='fa fa-sign-out' aria-hidden='true'></i>
      </button>
    </form>
  </div>
<!-- CONTENT -->
  <div class='cont'>

  </div>

  <?php 
    echo "<script> insertContent('messages.php') </script>";
  ?>
</body>

</html>