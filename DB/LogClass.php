<?php

require_once('SatelliteClass.php');

class Log {
  protected $id;
  protected $date;
  protected $user_name;
  protected $action;
  protected $table_BD;
  protected $description;

  public function __construct($row) {
    $this->id = $row['id'];
    $this->date = $row['date'];
    $this->user_name = $row['user_name'];
    $this->action = $row['action'];
    $this->table_BD = $row['table_BD'];
    $this->description = $row['description'];
  }
  
  public function getId() {return $this->id; }
  public function getDate() {return $this->date; }
  public function getUser_name() {return $this->user_name; }
  public function getAction() {return $this->action; }
  public function getTable_BD() {return $this->table_BD; }
  public function getDescription() {return $this->description; }

  public function mostraTr() {
    echo"<tr>
            <td>{$this->date}</td>
            <td>{$this->user_name}</td>
            <td>{$this->action}</td>
            <td>{$this->table_BD}</td>
            <td>{$this->description}</td>
        </tr>";
  }
}