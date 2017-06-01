<?php

class Message {
  protected $id;
  protected $sender;
  protected $receiver;
  protected $text;
  protected $date;
  protected $it_is_read;

  public function __construct($row) {
    $this->id = $row['id'];
    $this->sender = $row['sender'];
    $this->receiver = $row['receiver'];
    $this->text = $row['text'];
    $this->date = $row['date'];
    $this->it_is_read = $row['is_it_read'];
  }
  
  public function getId() {return $this->id; }
  public function getSender() {return $this->sender; }
  public function getReceiver() {return $this->receiver; }
  public function getText() {return $this->text; }
  public function getDate() {return $this->date; }
  public function getItIsRead() {return $this->it_is_read; }
}