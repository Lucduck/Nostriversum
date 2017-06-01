<?php
include '../../DB/DB.php';
// Recuperem la informació de la sessió
session_start();
// i comprovem que s'usuari s'ha identificat
if (!isset($_SESSION['nostriversum_user_chat'])) {
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
}


// getMessages
// getLastMessage
    // public static function getUsuaris() {
    // public static function getUsuari($user_name) {

  $you = $_SESSION['nostriversum_user_chat']->getName();

  $user_chat = $_SESSION['nostriversum_user_chat']->getName();
	$usr_mesg = $DataBase->getMessages($user_chat);
	foreach($usr_mesg as $usr){
    $user = $DataBase->getUsuari($usr);
    $message = $DataBase->getLastMessage($user_chat, $usr);
    $num_new = $DataBase->getNumNewMessages($user_chat, $usr);
    echo "<form action='content/conversation.php' method='post'>
            <input name='he' type='hidden' value='{$user->getName()}' />
            <input name='you' type='hidden' value='$you' />
            <button class='block' name='chat' value='{$user->getName()}'>
              <div class='image'>
                <img src='data:image/jpeg;base64, {$user->getImageBase64()}' alt=''/>
              </div>
              <div class='block-body'>
                <p class='date'>{$message['date']}</p>
                <p class='name'>{$user->getName()}</p>";
    if($num_new > 0){
      echo "    <p class='new'>{$num_new}</p>";
    } else {
      echo "    <br>";
    }
    echo "      <p></p>
              </div>
            </button>
          </form>";
	}

?>
