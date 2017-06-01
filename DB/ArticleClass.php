<?php

require_once('ThemeClass.php');

class Article {
  protected $id;
  protected $title;
  protected $image;
  protected $text;
  protected $lastModified;

  public function __construct($row) {
    $this->id = $row['id'];
    $this->title = $row['title'];
    $this->image = $row['image'];
    $this->text = $row['text'];
    $this->lastModified = $row['last_modified'];
  }
  
  public function getId() {return $this->id; }
  public function getTitle() {return $this->title; }
  public function getImage() {return $this->image; }
  public function getText() {return $this->text; }
  public function getLastModified() {return $this->lastModified; }
  public function mostra() {
    echo '<img src="data:image/jpeg;base64,' . base64_encode($this->image) . '" />';
    //echo "<tr><td>".$this->image."</td><td>".$this->title."</td><td>".$this->lastModified."</td><td>".$this->text."</td></tr>";
  }
  public function mostraCard() {
    echo" <div class='card'>
            <img src='data:image/jpeg;base64,".base64_encode($this->image)."' alt='Image article'/>
            <div class='content'>
              <p class='title'>{$this->title}</p>
            </div>
            <span class='fa-stack fa-lg icon-plus' id='icon-plus{$this->id}'>
              <i class='fa fa-circle fa-stack-2x'></i>
              <i class='fa fa-plus fa-stack-1x fa-inverse'></i>
            </span>
          </div>";
    $this->mostraCardBox();
  }
  public function mostraCardBox() {
    echo "<div class='big-card-box' id='big-card-box{$this->id}'>
            <div class='big-card'>
              <span class='fa-stack fa-2x icon-close' id='icon-close{$this->id}'>
                <i class='fa fa-circle fa-stack-2x'></i>
                <i class='fa fa-close fa-stack-1x fa-inverse'></i>
              </span>

              <div class='content-top'>
                <img src='data:image/jpeg;base64,".base64_encode($this->image)."' alt='Image article'/>
                <h1 class='title'>{$this->title}</h1>
              </div>
              <div class='content-bottom'>
                {$this->text}
              </div>
            </div>
          </div>";
    echo "<script>
            $('#icon-plus{$this->id}').click(function () {
              $('#big-card-box{$this->id}').css('display', 'flex')
            })
            $('#icon-close{$this->id}').click(function () {
              $('#big-card-box{$this->id}').css('display', 'none')
            })
          </script>";
  }
  public function mostraTr() {
    echo"<tr>
            <td>
              <p>{$this->title}</p>
              <img src='data:image/jpeg;base64,".base64_encode($this->image)."' alt='Image'/>
            </td>
            <td>
              <form action='content/article.php' method='post'>
                <input type='hidden' name='article' value='{$this->id}'>
                <span class='fa-stack fa-lg btn-white reload'>
                  <i class='fa fa-square fa-stack-2x'></i>
                  <i class='fa fa-pencil fa-stack-1x fa-inverse'></i>
                  <input type='submit' name='edit-article' value=' '/>
                </span>
              </form>
            </td>
            <td>
              <form action='content/article.php' method='post'>
                <input type='hidden' name='article' value='{$this->id}'>
                <span class='fa-stack fa-lg btn-white reload'>
                  <i class='fa fa-square fa-stack-2x'></i>
                  <i class='fa fa-trash-o fa-stack-1x fa-inverse'></i>
                  <input type='submit' name='delete-article' value=' '/>
                </span>
              </form>
            </td>
            <td>{$this->lastModified}</td>
            <td>{$this->id}</td>
        </tr>";
  }
}