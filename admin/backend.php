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
// Mira si esta activado el usuario, pero tambien sirve para controlar si esta eliminado el usuario.
if (!$DataBase->activatedUser($_SESSION['usuari'])) {
  header("Location: index.php");
}

// Actualizar la ultima connexion
$DataBase->UpdateUsuari_connection($_SESSION['usuari']);

?>
<!DOCTYPE html>
<html lang="">

<head>
  <meta charset="UTF-8">
  <link rel="shortcut icon" href="img/favicon.ico">
  <!-- PARA MOVILES -->
  <meta name='viewport' content='width=device-width, user-scalable=no, initial-scale=1, maximum-scale=0.9, minimum-scale=0.9'>

  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>BACKEND N</title>

  <!-- CSS -->
  <?php 
    $_SESSION['usuari']->getTheme()->printPlantilla();
  ?>
  <link rel="stylesheet" type="text/css" href="css/style.css">

  <!-- FONTS -->
  <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
  <link href="https://fonts.googleapis.com/css?family=Montserrat+Subrayada" rel="stylesheet">

  <!-- ICONS AWESOME -->
  <link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' type='text/css' rel='stylesheet'>

  <!-- JQUERY -->
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>

  <!--  JS  -->
  <script src="js/before.js"></script>
  <script src="js/after.js"></script>
</head>

<body>
<!-- CHAT -->
  <div class="fixed-chat-btn" style="bottom: 25px; right: 25px;">
    <form action='../chat/' method='post'>
      <button type='submit' name='backend_chat'>
        <i class="fa fa-comment fa-lg" aria-hidden="true"></i>
      </button>
    </form>
  </div>

<!-- MENU TOP -->
  <div class="menu-top">
    <div class="user">
      <img src="data:image/jpeg;base64, <?php echo base64_encode($_SESSION['usuari']->getImage());?> " alt="user" class="photo"/>
      <p><?php echo $_SESSION['usuari']->getName();?></p>
      <div class="down-options" onclick="optionsUser()">
        <i class="fa fa-caret-down" aria-hidden="true"></i>
      </div>
      <div class="options">
        <div class="settings">
          <div class="btn" onclick="insertContent('settings.php')">
            <p><i class="fa fa-cog" aria-hidden="true"></i> Ajustes</p>
          </div>
        </div>
        <div class="exit">
          <form action='index.php' method='post'>        
            <input type="submit" class="btn" name="exit" value='Salir'/>
          </form>
        </div>
      </div>
    </div>
    <p onclick="insertContent('backend.php')"><strong>Backend</strong> NOSTRIVERSUM</p>
    <i class="fa fa-grav" aria-hidden="true"></i>
  </div>

<!-- MENU LEFT -->
  <div class="menu-left">
    <?php 
      $_SESSION['usuari']->getGroup()->printMenu();
    ?>
  </div>

<!-- CONTENT -->
  <div class="cont">
  </div>

  <?php 
    echo "<script> insertContent('{$_SESSION['page']}') </script>";
  ?>
</body>

</html>