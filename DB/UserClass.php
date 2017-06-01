<?php

require_once('PlanetClass.php');

class User {
  protected $name;
  protected $mail;
  protected $image;
  protected $password;
  protected $theme;
  protected $last_connection;
  protected $group_name;
  protected $group;
  protected $activated;

  public function __construct($row, $DataBase) {
    $this->name = $row['name'];
    $this->mail = $row['mail'];
    $this->image = $row['image'];
    $this->password = $row['password'];
    $this->theme = $DataBase->obteTema($row['theme_name']);
    $this->last_connection = $row['last_connection'];
    $this->group_name = $row['group_name'];
    $this->group = $DataBase->getGroup($row['group_name']);
    $this->activated = $row['activated'];
  }
  
  public function getName() {return $this->name; }
  public function getMail() {return $this->mail; }
  public function getImage() {return $this->image; }
  public function getImageBase64() {return base64_encode($this->image); }
  public function getPassword() {return $this->password; }
  public function getTheme() {return $this->theme; }
  public function getLast_connection() {return $this->last_connection; }
  public function getGroup_name() {return $this->group_name; }
  public function getGroup() {return $this->group; }
  public function getActivated() {return $this->activated; }

  public function printSelectThemes($DataBase) {
    $temes = $DataBase->obteTemes();
    echo "<select name='theme'>";
    foreach($temes as $tema){
      if($tema->equals($this->theme)){
        echo"<option value='{$tema->getName()}' selected>{$tema->getName()}</option>";
      } else {
        echo"<option value='{$tema->getName()}'>{$tema->getName()}</option>";
      }
    }
    echo "</select>";
  }
  public function printSelectGroups($DataBase, $class) {
    $groups = $DataBase->getGroups();
    echo "<select ";
    if($class != '')
      echo " class='$class' ";
    echo " name='group'>";

    foreach($groups as $group){
      if($group->equals($this->group)){
        echo"<option value='{$group->getName()}' selected>{$group->getName()}</option>";
      } else {
        echo"<option value='{$group->getName()}'>{$group->getName()}</option>";
      }
    }
    echo "</select>";
  }

  public function printTr() {
    echo"<tr>
            <td>
              <p>{$this->name}</p>
            </td>
            <td>{$this->last_connection}</td>
            <td>
              <form action='content/user.php' method='post'>
                <input type='hidden' name='user' value='{$this->name}'>
                <span class='fa-stack fa-lg btn-white reload'>
                  <i class='fa fa-square fa-stack-2x'></i>
                  <i class='fa fa-pencil fa-stack-1x fa-inverse'></i>
                  <input type='submit' name='edit-user' value=' '/>
                </span>
              </form>
            </td>
            <td>";
    if($this->name != 'admin') {
      echo"   <form action='content/user.php' method='post'>
                <input type='hidden' name='user' value='{$this->name}'>
                <span class='fa-stack fa-lg btn-white reload'>
                  <i class='fa fa-square fa-stack-2x'></i>
                  <i class='fa fa-trash-o fa-stack-1x fa-inverse'></i>
                  <input type='submit' name='delete-user' value=' '/>
                </span>
              </form>";
    }
    echo"   </td>
        </tr>";
  }
}