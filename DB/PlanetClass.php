<?php

require_once('GroupClass.php');

class Planet {
  protected $name;
  protected $image;
  protected $color;
  protected $text;

  protected $diameter;
  protected $radius;

  protected $orbit;
  protected $distance_sun;
  protected $pos_orbit;

  protected $orbital_period;
  protected $speed;
  protected $rings;
  protected $size_rings;
  
  public function __construct($row) {
    $this->name = $row['name'];
    $this->image = $row['image'];
    $this->color = $row['color'];
    $this->text = $row['text'];

    $this->diameter = $row['diameter'];
    $this->radius = $row['diameter'] / 2;

    $this->orbit = $row['distance_sun'] * 2;
    $this->distance_sun = $row['distance_sun'];
    $this->pos_orbit = -$row['distance_sun'] - 2;

    $this->orbital_period = $row['orbital_period'];
    $this->speed = $row['orbital_period'] / 50;
    if($row['rings'] == null){
      $this->rings = 0;
    }else{
      $this->rings = $row['rings'];
    }
    if($row['size_rings'] == null){
      $this->size_rings = 0;
    }else{
      $this->size_rings = $row['size_rings'];
    }
  } 

  public function getName() {return $this->name; }
  public function getImage64_encode() {return base64_encode($this->image); }
  public function getImage() {return $this->image; }
  public function getColor() {return $this->color; }
  public function getText() {return $this->text; }
  public function getDiameter() {return $this->diameter; }
  public function getRadius() {return $this->radius; }
  public function getOrbit() {return $this->orbit; }
  public function getDistanceSun() {return $this->distance_sun; }
  public function getPos_orbit() {return $this->pos_orbit; }
  public function getOrbitalPeriod() {return $this->orbital_period; }
  public function getSpeed() {return $this->speed; }
  public function getRings() {return $this->rings; }
  public function getSizeRings() {return $this->size_rings; }


  public function printPlanetCenter() {
    echo "<style>
            .{$this->name}{
              top: -2px;
              left: -2px;
            }
            .{$this->name}:before{
              width: 40px;
              height: 40px;
              top: -20px;
              left: calc(50% - 20px);
              background: {$this->color};
            }
          </style>";
    echo "<li class='{$this->name}'>";
    if($this->rings != null){
      $this->printRingsCenter();
    }
    echo "</li>";
  }
  public function printRingsCenter() {
    for ($i = 1; $i <= $this->rings; $i++) {
      echo "<span class='ring' id='anillo{$i}'></span>";
      $whAnillo = 40 + 4 * $i +($this->size_rings * 2) * ($i - 1);
      $tlAnillo = 20 + 2 * $i + $this->size_rings * $i;
      echo "<style>
              .{$this->name} #anillo{$i}{
                width: {$whAnillo}px;
                height: {$whAnillo}px;
                border: {$this->size_rings}px solid {$this->color};
                top: -{$tlAnillo}px;
                left: calc(50% - {$tlAnillo}px);
              }
            </style>";
    }
    
  }
  public function printPlanet() {
    $this->printCss();
    echo "<li class='{$this->name}'>";
    if($this->rings != null){
      $this->printRings();
    }
    echo "</li>";
  }
  public function printCss() {
    $random = rand(0, 360);
    $max = 360 + $random;
    echo "<style>
            .{$this->name}{
              width: {$this->orbit}px;
              height: {$this->orbit}px;
              top: {$this->pos_orbit}px;
              left: {$this->pos_orbit}px;
              animation-duration: {$this->speed}s;
              animation-name: orbit{$this->name}
            }
            .{$this->name}:before{
              width: {$this->diameter}px;
              height: {$this->diameter}px;
              top: -{$this->radius}px;
              left: calc(50% - {$this->radius}px);
              background: {$this->color};
            }
            @keyframes orbit{$this->name}{
              from {transform: rotate({$random}deg)}
              to   {transform: rotate({$max}deg)}
            }
          </style>";
  }
  public function printRings() {
    for ($i = 1; $i <= $this->rings; $i++) {
      echo "<span class='ring' id='anillo{$i}'></span>";
      $whAnillo = $this->diameter + 4 * $i +($this->size_rings * 2) * ($i - 1);
      $tlAnillo = $this->radius + 2 * $i + $this->size_rings * $i;
      echo "<style>
              .{$this->name} #anillo{$i}{
                width: {$whAnillo}px;
                height: {$whAnillo}px;
                border: {$this->size_rings}px solid {$this->color};
                top: -{$tlAnillo}px;
                left: calc(50% - {$tlAnillo}px);
              }
            </style>";
    }
    
  }
  public function printPlanetEdit() {
    $this->printCssEdit();
    echo "<li class='{$this->name}'>";
    echo "<span class='planet'></span>";
    if($this->rings != null){
      $this->printRings();
    }
    echo "</li>";
  }
  public function printCssEdit() {
    echo "<style>
            .{$this->name}{
              width: {$this->orbit}px;
              height: {$this->orbit}px;
              top: {$this->pos_orbit}px;
              left: {$this->pos_orbit}px;
            }
            .{$this->name} >.planet{
              width: {$this->diameter}px;
              height: {$this->diameter}px;
              top: -{$this->radius}px;
              left: calc(50% - {$this->radius}px);
              background: {$this->color};
            }
          </style>";
  }
  public function printBtn() {
      echo "<div class='form-icon'>
              <form action='content/planet.php' method='post'>
                <input class='planet' type='submit' name='planet' value='{$this->name}'>
              </form>
              <form action='content/planet.php' method='post'>
                <input type='hidden' name='planet' value='{$this->name}'>
                <button name='delete' type='submit'><i class='fa fa-minus' aria-hidden='true'></i></button>
              </form>
            </div>";

  }
  public function printBtnSatellites() {
      echo "<div class='form-icon'>
              <form action='content/satellites.php' method='post'>
                <input class='planet' type='submit' name='planetS' value='{$this->name}'>
              </form>
              <form action='content/satellite.php' method='post'>
                <input type='hidden' name='planetS' value='{$this->name}'>
                <button name='new' type='submit'><i class='fa fa-plus' aria-hidden='true'></i></button>
              </form>
            </div>";
  }
  public function printBtnFrontend() {
      echo "<form action='planets.php' method='post'>
              <button class='planet' type='submit' name='planet' value='{$this->name}'>
                <i style='color: {$this->color}; width: 50px;position: initial;' class='fa fa-circle fa-stack-1x fa-inverse' style='font-size: 11px'></i>{$this->name}
              </button>
            </form>";

  }
}