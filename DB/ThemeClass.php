<?php

require_once('UserClass.php');

class Theme {
  protected $id;
  protected $name;
  protected $color_1;
  protected $color_2;
  protected $color_3;
  protected $color_4;
  protected $color_5;
  protected $color_6;
  protected $color_7;
  protected $color_btn;
  protected $color_btn_hover;
  protected $color_exit;
  protected $color_exit_hover;
  protected $color_text;
  protected $color_icon_square;
  protected $color_sphere_chat;
  protected $shadow_1_text;
  protected $shadow_1_box;
  protected $shadow_2_box;

  public function __construct($row) {
    $this->id = $row['id'];
    $this->name = $row['name'];
    $this->color_1 = $row['color_1'];
    $this->color_2 = $row['color_2'];
    $this->color_3 = $row['color_3'];
    $this->color_4 = $row['color_4'];
    $this->color_5 = $row['color_5'];
    $this->color_6 = $row['color_6'];
    $this->color_7 = $row['color_7'];
    $this->color_btn = $row['color_btn'];
    $this->color_btn_hover = $row['color_btn_hover'];
    $this->color_exit = $row['color_exit'];
    $this->color_exit_hover = $row['color_exit_hover'];
    $this->color_text = $row['color_text'];
    $this->color_icon_square = $row['color_icon_square'];
    $this->color_sphere_chat = $row['color_sphere_chat'];
    $this->shadow_1_text = $row['shadow_1_text'];
    $this->shadow_1_box = $row['shadow_1_box'];
    $this->shadow_2_box = $row['shadow_2_box'];
  }
  
  public function getId() {return $this->id; }
  public function getName() {return $this->name; }
  public function getColor_1() {return $this->color_1; }
  public function getColor_2() {return $this->color_2; }
  public function getColor_3() {return $this->color_3; }
  public function getColor_4() {return $this->color_4; }
  public function getColor_5() {return $this->color_5; }
  public function getColor_6() {return $this->color_6; }
  public function getColor_7() {return $this->color_7; }
  public function getColor_btn() {return $this->color_btn; }
  public function getColor_btn_hover() {return $this->color_btn_hover; }
  public function getColor_exit() {return $this->color_exit; }
  public function getColor_exit_hover() {return $this->color_exit_hover; }
  public function getColor_text() {return $this->color_text; }
  public function getColor_icon_square() {return $this->color_icon_square; }
  public function getColor_sphere_chat() {return $this->color_sphere_chat; }
  public function getShadow_1_text() {return $this->shadow_1_text; }
  public function getShadow_1_box() {return $this->shadow_1_box; }
  public function getShadow_2_box() {return $this->shadow_2_box; }

  public function printPlantilla(){
    echo "<style>
              :root {
                --color_1: {$this->color_1};
                --color_2: {$this->color_2};
                --color_3: {$this->color_3};
                --color_4: {$this->color_4};
                --color_5: {$this->color_5};
                --color_6: {$this->color_6};
                --color_7: {$this->color_7};
                --color_btn: {$this->color_btn};
                --color_btn_hover: {$this->color_btn_hover};
                --color_exit: {$this->color_exit};
                --color_exit_hover: {$this->color_exit_hover};
                --color_text: {$this->color_text};
                --color_icon_square: {$this->color_icon_square};
                --color_sphere_chat: {$this->color_sphere_chat};
                --shadow_1_text: {$this->shadow_1_text};
                --shadow_1_box: {$this->shadow_1_box};
                --shadow_2_box: {$this->shadow_2_box};
              }
            </style>";
  }
  public function equals($thema) {
    if($thema->getName() === $this->name){
      return true;
    } else {
      return false;
    }
  }
}