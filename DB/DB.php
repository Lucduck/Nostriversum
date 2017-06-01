<?php

require_once('ArticleClass.php');
class DB {
	protected static $DB;
    
	public function __construct(){
        $host="localhost";
        $user="u847478112_lucas";
        $pass="LucasPerez.95";
        $db="u847478112_solar";

        self::$DB = mysqli_connect($host, $user, $pass, $db);
        self::$DB->set_charset("utf8");

		if(!self::$DB){
			die("No se pudo establecer la conexion");
		}
	}
    public static function executaConsulta($sql) {
        $DataBase = self::$DB;

        $error = $DataBase->connect_errno;
        $resultat = null;
        if ($error == null) 
            $resultat = $DataBase->query($sql);
        return $resultat;
    }

/* LOG */
    public static function insertLog($user_name, $action, $table, $description) {
        $date = date("Y-m-d H:i:s");
        
        $sql = "INSERT INTO log(date, user_name, action, table_BD, description) VALUES ('{$date}', '{$user_name}', '{$action}', '{$table}', '{$description}')";
        self::executaConsulta($sql);
    }
    public static function obteLogOrderBy($camp, $ordre) {
        if(strtolower($ordre) != 'asc' && strtolower($ordre) != 'desc'){
            $ordre = 'desc';
        }
        $sql = "SELECT * FROM log ORDER BY {$camp} {$ordre}";
        $resultat = self::executaConsulta ($sql);
        $log = array();
        if($resultat) {
        // Añadimos un elemento por cada articulo obtenido
            $row = $resultat->fetch_array();
            while ($row != null) {
                $log[] = new Log($row);
                $row = $resultat->fetch_array();
            }
        }
        return $log;
    }

/* USER */
    public static function verificaUsuari($nom, $contrasenya) {
        $sql = "SELECT name FROM backend_users ";
        $sql .= "WHERE name='$nom' ";
        $sql .= "AND password='" . md5($contrasenya) . "';";
        
        $resultat = self::executaConsulta ($sql);
        
        $verificat = false;
        if(isset($resultat)) {
            $fila = $resultat->fetch_array();
            if(isset($fila))
                $verificat=true;
        }
        return $verificat;
    }
    public static function activatedUser($user) {
        $sql = "SELECT name FROM backend_users ";
        $sql .= " WHERE name LIKE '{$user->getName()}' ";
        $sql .= " AND activated = '1';";
        
        $resultat = self::executaConsulta ($sql);
        
        $verificat = false;
        if(isset($resultat)) {
            $fila = $resultat->fetch_array();
            if(isset($fila))
                $verificat=true;
        }
        return $verificat;
    }
    public static function getUsuaris() {
        $sql = "SELECT * FROM backend_users";
        $resultat = self::executaConsulta ($sql);
        $usuaris = array();
        if($resultat) {
        // Añadimos un elemento por cada usuario obtenido
            $row = $resultat->fetch_array();
            while ($row != null) {
                $usuaris[] = new User($row, $DataBase = new DB());
                $row = $resultat->fetch_array();
            }
        }
        return $usuaris;
    }
    public static function getUsuari($user_name) {
        $sql = "SELECT * FROM backend_users 
                WHERE name='$user_name'";
                
        $resultat = self::executaConsulta ($sql);
        $usuari = null;
        if(isset($resultat)) {
            $row = $resultat->fetch_array();
            $usuari = new User($row, $DataBase = new DB());
        }
        return $usuari;
    }
    public static function InsertarUsuari($name, $mail, $image, $password, $group, $activated) {
        $date = date("Y-m-d");
        $theme = 'black';
        $sql = "INSERT INTO backend_users(name, mail, image, password, theme_name, last_connection, group_name, activated) VALUES ('{$name}', '{$mail}', '{$image}', md5('{$password}'), '{$theme}', '{$date}', '{$group}', '{$activated}')";

        self::executaConsulta($sql);
        // die ($sql ;
        
        //LOG
        $user_act_name = $_SESSION['usuari']->getName();
        $description = "name: {$name}, mail: {$mail}, theme_name: {$theme}, group_name: {$group}, activated: {$activated}";
        self::insertLog($user_act_name, 'Insert', 'backend_users', "$description");
    }
    public static function UpdateUsuari($name, $mail, $image, $group, $activated) {
        $user_before = self::getUsuari($name);

        $sql = "UPDATE backend_users SET mail='{$mail}', ";
        if($image != null)
          $sql .= "image='{$image}', ";
        $sql .= " group_name='{$group}', activated='{$activated}' WHERE name = '{$name}'";

        self::executaConsulta($sql);

        $user_after = self::getUsuari($name);
        //LOG
        $user_act_name = $_SESSION['usuari']->getName();
        $description = "name: {$name}, mail: {$user_before->getMail()} -> {$user_after->getMail()},";
        if($image != null)
          $description .= " image,";
        $description .= " group_name: {$user_before->getGroup_name()} -> {$user_after->getGroup_name()}, activated: {$user_before->getActivated()} -> {$user_after->getActivated()}";
        self::insertLog($user_act_name, 'Update', 'backend_users', $description);
    }
    public function updateUsuariSettings($name, $mail, $tema, $image) {
        $user_before = self::getUsuari($name);

        $sql = "UPDATE backend_users SET mail='{$mail}', ";
        if($image != null)
          $sql .= " image='{$image}', ";
        $sql .= " theme_name='{$tema}' WHERE name = '{$name}'";

        self::executaConsulta($sql);

        $user_after = self::getUsuari($name);
        //LOG
        $user_act_name = $_SESSION['usuari']->getName();
        $description = "name: {$name}, mail: {$user_before->getMail()} -> {$user_after->getMail()},";
        if($image != null)
          $description .= " image,";
        $description .= " group_name: {$user_before->getGroup_name()} -> {$user_after->getGroup_name()}, activated: {$user_before->getActivated()} -> {$user_after->getActivated()}";
        self::insertLog($user_act_name, 'Update', 'backend_users', $description);
    }
    public static function DeleteUser($name) {
        $user_before = self::getUsuari($name);

        $sql = "DELETE FROM backend_users WHERE name = '{$name}'";
        self::executaConsulta($sql);

        //LOG
        $user_act_name = $_SESSION['usuari']->getName();
        $description = "name: {$user_before->getName()}, mail: {$user_before->getMail()}, group_name: {$user_before->getGroup_name()}', activated: {$user_before->getActivated()}";
        self::insertLog($user_act_name, 'Delete', 'backend_users', $description);
    }
    public static function UpdateUsuari_connection($name) {
        $date = date("Y-m-d");
        $sql = "UPDATE backend_users SET last_connection='{$date}' WHERE name = '{$name->getName()}'";
        self::executaConsulta($sql);
    }

/* GROUP */
    public static function getGroup($group_name) {
        $sql = "SELECT * FROM backend_groups WHERE name LIKE '{$group_name}';";

        $resultat = self::executaConsulta ($sql);
        $group = null;
        if(isset($resultat)) {
            $row = $resultat->fetch_array();
            $group = new Group($row);
        }
        return $group;
    }
    public static function getGroups() {
        $sql = "SELECT * FROM backend_groups";
        $resultat = self::executaConsulta ($sql);
        $groups = array();
        if($resultat) {
            $row = $resultat->fetch_array();
            while ($row != null) {
                $groups[] = new Group($row);
                $row = $resultat->fetch_array();
            }
        }
        return $groups;
    }
    public function printSelectGroups($class) {
        $groups = self::getGroups();
        echo "<select ";
        if($class != '')
        echo " class='$class' ";
        echo " name='group'>";

        foreach($groups as $group){
            echo"<option value='{$group->getName()}'>{$group->getName()}</option>";
        }
        echo "</select>";
    }
    public static function InsertGroup($name, $articles, $info, $planets, $satellites, $log, $users, $groups) {
        $sql = "INSERT INTO backend_groups(name, articles, info, planets, satellites, log, users, groups) VALUES ('{$name}', '{$articles}', '{$info}', '{$planets}', '{$satellites}', '{$log}', '{$users}', '{$groups}')";
        self::executaConsulta($sql);

        //LOG
        $user_act_name = $_SESSION['usuari']->getName();
        $description = "name: {$name}";
        self::insertLog($user_act_name, 'Insert', 'backend_groups', $description);
    }
    public static function UpdateGroup($name_before, $name_after, $articles, $info, $planets, $satellites, $log, $users, $groups) {
        $group_before = self::getGroup($name_before);

        $sql = "UPDATE backend_groups SET name = '{$name_after}', articles = '{$articles}', info = '{$info}', planets = '{$planets}', satellites = '{$satellites}', log = '{$log}', users = '{$users}', groups = '{$groups}' WHERE name = '{$name_before}'";
        self::executaConsulta($sql);

        $group_after = self::getGroup($name_after);
        //LOG
        $user_act_name = $_SESSION['usuari']->getName();
        $description = "name: {$group_before->getName()} -> {$group_after->getName()}, Articles: {$group_before->getArticles()} -> {$group_after->getArticles()}, Info: {$group_before->getInfo()} -> {$group_after->getInfo()}, Planets: {$group_before->getPlanets()} -> {$group_after->getPlanets()}, Satellites: {$group_before->getSatellites()} -> {$group_after->getSatellites()}, Log: {$group_before->getLog()} -> {$group_after->getLog()}, Users: {$group_before->getUsers()} -> {$group_after->getUsers()}, Groups: {$group_before->getGroups()} -> {$group_after->getGroups()}";
        self::insertLog($user_act_name, 'Update', 'backend_groups', $description);
    }
    public static function DeleteGroup($name) {
        $group_before = self::getGroup($name);
        $sql = "DELETE FROM backend_groups WHERE name = '{$name}'";
        self::executaConsulta($sql);

        //LOG
        $user_act_name = $_SESSION['usuari']->getName();
        $description = "name: {$group_before->getName()}, Articles: {$group_before->getArticles()}, Info: {$group_before->getInfo()}, Planets: {$group_before->getPlanets()}, Satellites: {$group_before->getSatellites()}, Log: {$group_before->getLog()}, Users: {$group_before->getUsers()}, Groups: {$group_before->getGroups()}";
        self::insertLog($user_act_name, 'Delete', 'backend_groups', $description);
    }

/* ARTICLES */
    public static function obteArticles() {
        $sql = "SELECT id, title, image, text, last_modified FROM articles";
        $resultat = self::executaConsulta ($sql);
        $articles = array();
        if($resultat) {
        // Añadimos un elemento por cada articulo obtenido
            $row = $resultat->fetch_array();
            while ($row != null) {
                $articles[] = new Article($row);
                $row = $resultat->fetch_array();
            }
        }
        return $articles;
    }
    public static function obteArticlesOrderBy($camp, $ordre) {
        // $ordre == asc || desc
        if(strtolower($ordre) != 'asc' && strtolower($ordre) != 'desc'){
            $ordre = 'desc';
        }
        $sql = "SELECT id, title, image, text, last_modified FROM articles ORDER BY {$camp} {$ordre}";
        $resultat = self::executaConsulta ($sql);
        $articles = array();
        if($resultat) {
        // Añadimos un elemento por cada articulo obtenido
            $row = $resultat->fetch_array();
            while ($row != null) {
                $articles[] = new Article($row);
                $row = $resultat->fetch_array();
            }
        }
        return $articles;
    }
    public static function obteArticle($id) {
        $sql = "SELECT id, title, image, text, last_modified FROM articles";
        $sql .= " WHERE id='" . $id . "'";
        $resultat = self::executaConsulta ($sql);
        $article = null;
        if(isset($resultat)) {
            $row = $resultat->fetch_array();
            $article = new Article($row);
        }
        return $article;
    }
    public static function InsertarArticle($title, $image, $text) {
        $date = date("Y-m-d");
        //$mydate = date("d/m/Y", strtotime($date));
        
        $sql = "INSERT INTO articles(title, image, text, last_modified) VALUES ('{$title}', '{$image}', '{$text}', '{$date}')";
        self::executaConsulta($sql);

        //LOG
        $user_act_name = $_SESSION['usuari']->getName();
        $description = "title: {$title}, text: {$text}";
        self::insertLog($user_act_name, 'Insert', 'articles', $description);
    }
    public static function UpdateArticle($id, $title, $image, $text) {
        $article_before = self::obteArticle($id);
        $date = date("Y-m-d");

        $sql = "UPDATE articles SET title='{$title}', ";
        if($image != null)
          $sql .= " image='{$image}', ";
        $sql .= " text='{$text}', last_modified='{$date}' WHERE id = {$id}";
        self::executaConsulta($sql);

        $article_after = self::obteArticle($id);
        //LOG
        $user_act_name = $_SESSION['usuari']->getName();
        $description = "id: {$id}, title: {$article_before->getTitle()} -> {$article_after->getTitle()}, ";
        if($image != null)
          $description .= " image, ";
        $description .= " text: {$article_before->getText()} -> {$article_after->getText()}";
        self::insertLog($user_act_name, 'Update', 'articles', $description);
    }
    public static function DeleteArticle($id) {
        $article_before = self::obteArticle($id);

        $sql = "DELETE FROM articles WHERE id = '{$id}'";
        self::executaConsulta($sql);

        //LOG
        $user_act_name = $_SESSION['usuari']->getName();
        $description = "id: {$id}, title: {$article_before->getTitle()}, text: {$article_before->getText()}";
        self::insertLog($user_act_name, 'Delete', 'articles', $description);
    }

/* THEME */
    public static function obteTema($theme_name) {
        $sql = "SELECT * FROM backend_theme WHERE name LIKE '{$theme_name}';";

        $resultat = self::executaConsulta ($sql);
        $tema = null;
        if(isset($resultat)) {
            $row = $resultat->fetch_array();
            $tema = new Theme($row);
        }
        return $tema;
    }
    public static function obteTemes() {
        $sql = "SELECT * FROM backend_theme";

        $resultat = self::executaConsulta ($sql);
        $temes = array();
        if($resultat) {
        // Añadimos un elemento por cada articulo obtenido
            $row = $resultat->fetch_array();
            while ($row != null) {
                $temes[] = new Theme($row);
                $row = $resultat->fetch_array();
            }
        }
        return $temes;
    }
    public static function getImage($photo) {
        $DataBase = self::$DB;
        $msg = 'OK';
        $imgData = null;
        if(isset($photo)){
            $maxsize = 10000000; //set to approx 10 MB
            //check whether file is uploaded with HTTP POST
            if(is_uploaded_file($photo['tmp_name'])) {    
              //checks size of uploaded image on server side
              if( $photo['size'] < $maxsize) {  
                  //checks whether uploaded file is of image type
                  $finfo = finfo_open(FILEINFO_MIME_TYPE);
                  if(strpos(finfo_file($finfo, $photo['tmp_name']),"image")===0) {    
                    // prepare the image for insertion
                    $imgData =addslashes (file_get_contents($photo['tmp_name']));

                    $msg='<p>Image successfully saved in database with id ='. mysqli_insert_id($DataBase).' </p>';
                  } else
                  $msg="<p>Uploaded file is not an image.</p>";
              } else {
                  // if the file is not less than the maximum allowed, print an error
                  $msg='<div>File exceeds the Maximum File limit</div>
                      <div>Maximum File limit is '.$maxsize.' bytes</div>
                      <div>File '.$photo['name'].' is '.$photo['size'].' bytes</div><hr />';
              }
            } else
            $msg="File not uploaded successfully.";
        } else
            $msg="File not selected";
        return $imgData;
    }

/* PLANETS */
    public static function getPlanets() {
        $sql = "SELECT * FROM planets ORDER BY distance_sun ASC";
        $resultat = self::executaConsulta ($sql);
        $planets = array();
        if($resultat) {
        // Añadimos un elemento por cada planeta obtenido
            $row = $resultat->fetch_array();
            while ($row != null) {
                $planets[] = new Planet($row);
                $row = $resultat->fetch_array();
            }
        }
        return $planets;
    }
    public static function getPlanet($name) {
        $sql = "SELECT * FROM planets WHERE name = '{$name}'";
        $resultat = self::executaConsulta ($sql);
        $planet = null;
        if(isset($resultat)) {
            $row = $resultat->fetch_array();
            $planet = new Planet($row);
        }
        return $planet;
    }
    public static function InsertPlanet($name, $image, $color, $text, $diameter, $distance_sun, $orbital_period, $rings, $size_rings) {
        $sql = "INSERT INTO planets(name, image, color, text, diameter, distance_sun, orbital_period, rings, size_rings)
                VALUES ('{$name}', '{$image}', '{$color}', '{$text}', '{$diameter}', '{$distance_sun}', '{$orbital_period}', '{$rings}', '{$size_rings}')";
        self::executaConsulta($sql);

        //LOG
        $user_act_name = $_SESSION['usuari']->getName();
        $description = "name: {$name}";
        self::insertLog($user_act_name, 'Insert', 'planets', $description);
    }
    public static function UpdatePlanet($name, $image, $color, $text, $diameter, $distance_sun, $orbital_period, $rings, $size_rings) {
        $planet_before = self::getPlanet($name);

        $sql = "UPDATE planets SET ";
        if($image != null)
          $sql .= " image='{$image}', ";
        $sql .= " color='{$color}', text='{$text}', diameter='{$diameter}', distance_sun='{$distance_sun}', orbital_period='{$orbital_period}', rings='{$rings}', size_rings='{$size_rings}' WHERE name = '{$name}'";
        self::executaConsulta($sql);

        $planet_after = self::getPlanet($name);
        //LOG
        $user_act_name = $_SESSION['usuari']->getName();
        $description = "name: {$name}, ";
        if($image != null)
          $description .= " image, ";
        $description .= " color: {$planet_before->getColor()} -> {$planet_after->getColor()}, diameter: {$planet_before->getDiameter()} -> {$planet_after->getDiameter()}, distance_sun: {$planet_before->getDistanceSun()} -> {$planet_after->getDistanceSun()}, orbital_period: {$planet_before->getOrbitalPeriod()} -> {$planet_after->getOrbitalPeriod()}, rings: {$planet_before->getRings()} -> {$planet_after->getRings()}, size_rings: {$planet_before->getSizeRings()} -> {$planet_after->getSizeRings()}, text: {$planet_before->getText()} -> {$planet_after->getText()}";
        self::insertLog($user_act_name, 'Update', 'planets', $description);
    }
    public static function DeletePlanet($name) {
        $planet_before = self::getPlanet($name);

        $sql = "DELETE FROM planets WHERE name = '{$name}'";
        self::executaConsulta($sql);

        //LOG
        $user_act_name = $_SESSION['usuari']->getName();
        $description = "name:{$planet_before->getName()}, color: {$planet_before->getColor()}, diameter: {$planet_before->getDiameter()}, distance_sun: {$planet_before->getDistanceSun()}, orbital_period: {$planet_before->getOrbitalPeriod()}, rings: {$planet_before->getRings()}, size_rings: {$planet_before->getSizeRings()}, text: {$planet_before->getText()}";
        self::insertLog($user_act_name, 'Delete', 'planets', $description);
    }

/* SATELLITES */
    public static function getSatellites($planet) {
        $sql = "SELECT * FROM satellites WHERE planet_name LIKE '{$planet}' ORDER BY distance_planet ASC";
        $resultat = self::executaConsulta ($sql);
        $satellites = array();
        // Añadimos un elemento por cada satelite obtenido
        if($resultat) {
            $row = $resultat->fetch_array();
            while ($row != null) {
                $satellites[] = new Satellite($row);
                $row = $resultat->fetch_array();
            }
        }
        return $satellites;
    }
    public static function getSatellite($name) {
        $sql = "SELECT * FROM satellites WHERE name = '{$name}'";
        $resultat = self::executaConsulta ($sql);
        $satellite = null;
        if(isset($resultat)) {
            $row = $resultat->fetch_array();
            $satellite = new Satellite($row);
        }
        return $satellite;
    }
    public static function InsertarSatellite($name, $planet_name, $image, $color, $text, $diameter, $distance_planet, $orbital_period) {
        $sql = "INSERT INTO satellites(name, planet_name, image, color, text, diameter, distance_planet, orbital_period)
                VALUES ('{$name}', '{$planet_name}', '{$image}', '{$color}', '{$text}', '{$diameter}', '{$distance_planet}', '{$orbital_period}')";
        self::executaConsulta($sql);

        //LOG
        $user_act_name = $_SESSION['usuari']->getName();
        $description = "name: {$name}";
        self::insertLog($user_act_name, 'Insert', 'Satellite', $description);
    }
    public static function UpdateSatellite($name, $planet_name, $image, $color, $text, $diameter, $distance_planet, $orbital_period) {
        $satellite_before = self::getSatellite($name);

        $sql = "UPDATE satellites SET planet_name='{$planet_name}', ";
        if($image != null)
          $sql .= " image='{$image}', ";
        $sql .= " color='{$color}', text='{$text}', diameter='{$diameter}', distance_planet='{$distance_planet}', orbital_period='{$orbital_period}' WHERE name = '{$name}'";
        self::executaConsulta($sql);

        $satellite_after = self::getSatellite($name);
        //LOG
        $user_act_name = $_SESSION['usuari']->getName();
        $description = "name: {$name}, planet_name: {$satellite_before->getNamePlanet()} -> {$satellite_after->getNamePlanet()}, ";
        if($image != null)
          $description .= " image, ";
        $description .= " color: {$satellite_before->getColor()} -> {$satellite_after->getColor()}, diameter: {$satellite_before->getDiameter()} -> {$satellite_after->getDiameter()}, distance_planet: {$satellite_before->getDistancePlanet()} -> {$satellite_after->getDistancePlanet()}, orbital_period: {$satellite_before->getOrbitalPeriod()} -> {$satellite_after->getOrbitalPeriod()}";
        self::insertLog($user_act_name, 'Update', 'Satellite', $description);
    }
    public static function DeleteSatellite($name) {
        $satellite_before = self::getSatellite($name);

        $sql = "DELETE FROM satellites WHERE name = '{$name}'";
        self::executaConsulta($sql);

        //LOG
        $user_act_name = $_SESSION['usuari']->getName();
        $satellite_after = self::getSatellite($name);
        $description = "name:{$satellite_before->getName()}, planet_name:{$satellite_before->getNamePlanet()}, color: {$satellite_before->getColor()}, diameter: {$satellite_before->getDiameter()}, distance_planet: {$satellite_before->getDistancePlanet()}, orbital_period: {$satellite_before->getOrbitalPeriod()}, text: {$satellite_before->getText()}";
        self::insertLog($user_act_name, 'Delete', 'Satellite', $description);
    }

/* CHAT */
    public static function getMessages($user) {
        $sql = "SELECT sender FROM chats WHERE receiver LIKE '{$user}' GROUP BY sender ORDER BY date ASC";
        
        $resultat = self::executaConsulta ($sql);
        $users = array();
        if($resultat) {
            $row = $resultat->fetch_array();
            while ($row != null) {
                $users[] = $row['sender'];
                $row = $resultat->fetch_array();
            }
        }
        return $users;
    }
    public static function getLastMessage($receiver, $sender) {
        $sql = "SELECT * FROM chats WHERE receiver LIKE '{$receiver}' AND sender LIKE '{$sender}' Order By date DESC limit 1";

        $resultat = self::executaConsulta ($sql);
        $message = null;
        if(isset($resultat)) {
            $message = $resultat->fetch_array();
        }
        return $message;
    }
    public static function getNumNewMessages($receiver, $sender) { // you, he
        $sql = "SELECT count(sender) 'num' FROM chats WHERE sender LIKE '$sender' AND receiver LIKE '$receiver' AND is_it_read = 0";

        $resultat = self::executaConsulta ($sql);
        $num = 0;
        if(isset($resultat)) {
            $message = $resultat->fetch_array();
            $num = $message['num'];
        }
        return $num;
    }
    public static function getConversation($receiver, $sender) {
        $sql = "SELECT * FROM chats WHERE (receiver LIKE '$receiver' AND sender LIKE '$sender') OR (receiver LIKE '$sender' AND sender LIKE '$receiver') ORDER BY date asc";
        
        $resultat = self::executaConsulta ($sql);
        $messages = array();
        if($resultat) {
            $row = $resultat->fetch_array();
            while ($row != null) {
                $messages[] = new Message($row);
                $row = $resultat->fetch_array();
            }
        }
        return $messages;
    }
    public static function updateRead($receiver, $sender) { // you, he
        $sql = "UPDATE chats SET is_it_read = 1 WHERE sender LIKE '$sender' AND receiver LIKE '$receiver' AND is_it_read = 0";
        self::executaConsulta($sql);
    }
}



?>
