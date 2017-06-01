<?php
include '../../DB/DB.php';
try {
  $DataBase = new DB();
}catch (PDOException $e) {
  $error = $e->getCode();
  $missatge = $e->getMessage();
}
if (isset($error)) {
  die('Error: connection failed');
}
  $you = $_POST['you'];
  $he = $_POST['he'];
  $DataBase->updateRead($you, $he);

  $messages = $DataBase->getConversation($you, $he);
	foreach($messages as $msg){
    $sender = $msg->getSender();
    $text = $msg->getText();
    $date = $msg->getDate();
    if($sender == $you){
      echo "<div class='you'>";
    } else{
      echo "<div class='he'>";
    }
    echo "    <p>$text</p>
              <p class='date'>$date</p>
            </div>";
  }
?>