<?php

require_once('MessageClass.php');

class Satellite {
  protected $name;
  protected $planet_name;
  protected $image;
  protected $color;
  protected $text;

  protected $diameter;
  protected $radius;

  protected $orbit;
  protected $distance_planet;
  protected $pos_orbit;

  protected $orbital_period;
  protected $speed;
  
  public function __construct($row) {
    $this->name = $row['name'];
    $this->planet_name = $row['planet_name'];
    $this->image = $row['image'];
    $this->color = $row['color'];
    $this->text = $row['text'];

    $this->diameter = $row['diameter'];
    $this->radius = $row['diameter'] / 2;

    $this->orbit = $row['distance_planet'] * 2;
    $this->distance_planet = $row['distance_planet'];
    $this->pos_orbit = -$row['distance_planet'] - 2;

    $this->orbital_period = $row['orbital_period'];
    $this->speed = $row['orbital_period'] / 20;
  } 

  public function getName() {return $this->name; }
  public function getNamePlanet() {return $this->planet_name; }
  public function getImage64_encode() {return base64_encode($this->image); }
  public function getImage() {return $this->image; }
  public function getColor() {return $this->color; }
  public function getText() {return $this->text; }
  public function getDiameter() {return $this->diameter; }
  public function getRadius() {return $this->radius; }
  public function getOrbit() {return $this->orbit; }
  public function getDistancePlanet() {return $this->distance_planet; }
  public function getPos_orbit() {return $this->pos_orbit; }
  public function getOrbitalPeriod() {return $this->orbital_period; }
  public function getSpeed() {return $this->speed; }


  public function printSatellite() {
    $this->printCss();
    echo "<li class='{$this->name}'></li>";
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
  public function printSatelliteEdit() {
    $this->printCssEdit();
    echo "<li class='{$this->name}'>";
    echo "  <span class='satellite'></span>";
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
            .{$this->name} > .satellite{
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
              <form action='satellite.php' method='post'>
                <input type='hidden' name='planetS' value='{$this->planet_name}'>
                <input class='satellite' type='submit' name='satellite' value='{$this->name}'>
              </form>
              <form action='satellites.php' method='post'>
                <input type='hidden' name='planetS' value='{$this->planet_name}'>
                <input type='hidden' name='satellite' value='{$this->name}'>
                <button name='delete' type='submit'><i class='fa fa-minus' aria-hidden='true'></i></button>
              </form>
            </div>";

  }
  public function printBtnFrontend() {
      echo "<form action='planets.php' method='post'>
              <input type='hidden' name='planet' value='{$this->planet_name}'>
              <button class='planet' type='submit' name='satellite' value='{$this->name}'>
                <i style='color: {$this->color}; width: 50px;position: initial;' class='fa fa-circle fa-stack-1x fa-inverse' style='font-size: 11px'></i>{$this->name}
              </button>
            </form>";

  }
}