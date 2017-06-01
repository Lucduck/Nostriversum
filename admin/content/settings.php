<?php 
include '../../DB/DB.php';
// Recuperem la informació de la sessió
session_start();
if (!isset($_SESSION['usuari'])) {
  header("Location: ../index.php");
}
$page = basename($_SERVER['PHP_SELF']);
$_SESSION['page'] = $page;

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

<div class="contentSettings">
  <div class="cardUser">
    <table>
      <tr>
        <td>
          <img src="data:image/jpeg;base64, <?php echo base64_encode($_SESSION['usuari']->getImage());?> " alt="user"/>
        </td>
        <td>
          <form enctype="multipart/form-data" action='changes.php' method='post'>
            <p>Imagen de perfil</p>
            <input type="file" name="photo">

            <p>Correo electrónico</p>
            <input type="text" name="mail" value="<?php echo $_SESSION['usuari']->getMail(); ?>" placeholder="e-mail">
            
            <p>Plantilla</p>
            <?php
            $_SESSION['usuari']->printSelectThemes($DataBase);
            ?>
            <input type='hidden' name='user' value='<?php echo $_SESSION['usuari']->getName(); ?>'>
            <input class="btn" type="submit" name="settings" value="Guardar y recargar">
          </form>
        </td>
      </tr>
    </table>
  </div>
</div>