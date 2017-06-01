<?php
include '../../DB/DB.php';
// Recuperem la informació de la sessió
session_start();
// i comprovem que s'usuari s'ha identificat
if (!isset($_SESSION['nostriversum_user_chat'])) {
  header('Location: ../index.php');
}
if (!isset($_POST['chat'])) {
  header('Location: ../index.php');
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
  header('Location: ../index.php');
} else {
  $_SESSION['nostriversum_user_chat'] = $DataBase->getUsuari($_SESSION['nostriversum_user_chat']->getName());
}

$you = $_POST['you'];
$he = $_POST['he'];
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
  <link rel='stylesheet' type='text/css' href='../css/style.css'>

  <!-- FONTS -->
  <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
  <link href='https://fonts.googleapis.com/css?family=Montserrat+Subrayada' rel='stylesheet'>

  <!-- ICONS AWESOME -->
  <link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' type='text/css' rel='stylesheet'>

  <!-- JQUERY -->
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>

  <!--  JS  -->
  <script src="../js/ajax.js"></script>
</head>

<body class='body-chat'>
<!-- MENU_TOP -->
  <div class='menu_top'>
    <div class='return' onclick='window.location.href = "../chat.php"'>
      <i class='fa fa-arrow-left' aria-hidden='true'></i>
    </div>
  </div>
<!-- CONTENT -->
  <div class='cont-conversation' id='cont-conversation'>
  </div>

  <div class="new">
    <form name="frmMsg" action="" onsubmit="enviarDatosMensaje(); return false">
      <input name="he" type="hidden" value="<?php echo $he; ?>" />
      <input name="you" type="hidden" value="<?php echo $you; ?>" />
      <input id='mensaje' name="mensaje" type="text" value="" placeholder="Escribe un mensaje aquí"/>
      <button type="submit" name="Submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
    </form>
    <div id='scroll-down' onclick='scrollBtm()'><i class="fa fa-arrow-down" aria-hidden="true"></i></div>
  </div>
  <form method="post" id="formularioRE">
    <input name="he" type="hidden" value="<?php echo $he; ?>" />
    <input name="you" type="hidden" value="<?php echo $you; ?>" />
  </form>
  <script>
    window.onload = function () {
      refreshdiv()
      setInterval(refreshdiv, 1000)
    }
    $('.cont-conversation').scroll(function() {
      if ($(this).scrollTop()>$(this).height()){
        $('#scroll-down').fadeOut()
      } else {
        $('#scroll-down').fadeIn()
      }
    });
  </script>
</body>

</html>