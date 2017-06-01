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
<div class="contentPlanets">
  <div class="planets">
    <ul class="solarSystem">
    <?php
      $planets = $DataBase->getPlanets();
      foreach($planets as $planet){
        $planet->printPlanet();
      }
    ?>
    </ul>
  </div>
  <div class="list">
    <?php
      foreach($planets as $planet){
        if($planet->getDistanceSun() != 0)
          $planet->printBtnSatellites();
      }
    ?>
  </div>
  <input id='scale' class='inputRangeScale' type='range' value='1.5' min='0' max='3' step='.01'>
  <script>
    $('#scale').bind('input', function(){
      scale($('#scale'))
    }).bind('change', function(){
      scale($('#scale'))	/* for IE */
    });
    function scale(e){
      let value = $(e).val()
      let scale = 'scale(' + value + ')'

      $('.contentPlanets .planets').css('transform', scale)
    }
  </script>
</div>
