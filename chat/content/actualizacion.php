<?php
include '../../DB/DB.php';
  //Configuracion de la conexion a base de datos

try {
  $DataBase = new DB();
}catch (PDOException $e) {
  $error = $e->getCode();
  $missatge = $e->getMessage();
}
  //variables POST

  $he = $_POST['he'];

  $you = $_POST['you'];

  $mensaje = $_POST['mensaje'];
  if($mensaje != ''){
    //actualiza los datos del empleados
    $date = date("Y-m-d H:i:s");

    $sql="INSERT INTO chats (`sender`, `receiver`, `text`, `date`, `is_it_read`) VALUES ('$you', '$he', '$mensaje', '$date', 0)";
    $DataBase->executaConsulta($sql);
  }