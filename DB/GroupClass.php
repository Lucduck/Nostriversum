<?php

require_once('LogClass.php');

class Group {
  protected $name;
  protected $articles;
  protected $info;
  protected $planets;
  protected $satellites;
  protected $log;
  protected $users;
  protected $groups;

  public function __construct($row) {
    $this->name = $row['name'];

    $this->articles = $row['articles'];
    $this->info = $row['info'];

    $this->planets = $row['planets'];
    $this->satellites = $row['satellites'];

    $this->log = $row['log'];
    $this->users = $row['users'];
    $this->groups = $row['groups'];
  }
  
  public function getName() {return $this->name; }
  public function getArticles() {return $this->articles; }
  public function getInfo() {return $this->info; }
  public function getPlanets() {return $this->planets; }
  public function getSatellites() {return $this->satellites; }
  public function getLog() {return $this->log; }
  public function getUsers() {return $this->users; }
  public function getGroups() {return $this->groups; }

  public function printMenu() {
    if($this->articles || $this->info){
      echo "
            <button class='accordion'><i class='fa fa-file-o' aria-hidden='true'></i> Web <i class='fa fa-caret-down' aria-hidden='true'></i></button>
            <div class='panel'>";
      if($this->articles){
        echo "
              <div class='element' onclick='insertContent(\"articles.php\")'>
                <span class='fa-stack fa-lg'>
                  <i class='fa fa-square fa-stack-2x' style='color: #ffa000'></i>
                  <i class='fa fa-file-text-o fa-stack-1x fa-inverse'></i>
                </span> Artículos
              </div>";
      }
      if($this->info){
        echo "
              <div class='element' onclick='insertContent(\"info.php\")'>
                <span class='fa-stack fa-lg'>
                  <i class='fa fa-square fa-stack-2x' style='color: #1976d2'></i>
                  <i class='fa fa-info fa-stack-1x fa-inverse'></i>
                </span> Información
              </div>";
      }
      echo "</div>";
    }
    if($this->planets || $this->satellites){
      echo "
            <button class='accordion'><i class='fa fa-globe' aria-hidden='true'></i> Sistema solar <i class='fa fa-caret-down' aria-hidden='true'></i></button>
            <div class='panel'>";
      if($this->planets){
        echo "
              <div class='element' onclick='insertContent(\"planets.php\")'>
                <span class='fa-stack fa-lg'>
                  <i class='fa fa-square fa-stack-2x' style='color: #512da8'></i>
                  <i class='fa fa-globe fa-stack-1x fa-inverse'></i>
                </span> Planetas
              </div>";
      }
      if($this->satellites){
        echo "
              <div class='element' onclick='insertContent(\"satellites_planets.php\")'>
                <span class='fa-stack fa-lg'>
                  <i class='fa fa-square fa-stack-2x' style='color: #7b1fa2'></i>
                  <i class='fa fa-circle fa-stack-1x fa-inverse' style='font-size: 11px'></i>
                </span> Satélites
              </div>";
      }
      echo "</div>";
    }
    if($this->log || $this->users || $this->groups){
      echo "
            <button class='accordion'><i class='fa fa-plug' aria-hidden='true'></i> Sistema <i class='fa fa-caret-down' aria-hidden='true'></i></button>
            <div class='panel'>";
      if($this->log){
        echo "
              <div class='element' onclick='insertContent(\"log.php\")'>
                <span class='fa-stack fa-lg'>
                  <i class='fa fa-square fa-stack-2x' style='color: #c2185b'></i>
                  <i class='fa fa-list-alt fa-stack-1x fa-inverse'></i>
                </span> Registro
              </div>";
      }
      if($this->users){
        echo "
              <div class='element' onclick='insertContent(\"users.php\")'>
                <span class='fa-stack fa-lg'>
                  <i class='fa fa-square fa-stack-2x' style='color: #0288d1'></i>
                  <i class='fa fa-user fa-stack-1x fa-inverse'></i>
                </span> Usuarios backend
              </div>";
      }
      if($this->groups){
        echo "
              <div class='element' onclick='insertContent(\"groups.php\")'>
                <span class='fa-stack fa-lg'>
                  <i class='fa fa-square fa-stack-2x' style='color: #00796b'></i>
                  <i class='fa fa-users fa-stack-1x fa-inverse'></i>
                </span> Grupos backend
              </div>";
      }
      echo "
            </div>";
    }
    echo "<script> backendReady() </script>";
  }

  public function printTr() {
    echo"<tr>
            <td>
              <p>{$this->name}</p>
            </td>";
    if($this->name != 'admin') {
      echo" <td>
              <form action='content/group.php' method='post'>
                <input type='hidden' name='group' value='{$this->name}'>
                <span class='fa-stack fa-lg btn-white reload'>
                  <i class='fa fa-square fa-stack-2x'></i>
                  <i class='fa fa-pencil fa-stack-1x fa-inverse'></i>
                  <input type='submit' name='edit-group' value=' '/>
                </span>
              </form>
            </td>
            <td>
              <form action='content/group.php' method='post'>
                <input type='hidden' name='group' value='{$this->name}'>
                <span class='fa-stack fa-lg btn-white reload'>
                  <i class='fa fa-square fa-stack-2x'></i>
                  <i class='fa fa-trash-o fa-stack-1x fa-inverse'></i>
                  <input type='submit' name='delete-group' value=' '/>
                </span>
              </form>
            </td>";
    } else {
      echo"<td></td><td></td>";
    }
    echo"</tr>";
  }
  public function equals($group) {
    if($group->getName() === $this->name){
      return true;
    } else {
      return false;
    }
  }
}