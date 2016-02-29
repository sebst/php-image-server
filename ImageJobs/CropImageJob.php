<?php


require_once __DIR__."/ImageJob.php";
require_once __DIR__."/../Images/Image.php";
require_once __DIR__."/../Images/StreamImage.php";

class CropImageJob implements ImageJob {

  public function __construct($params = []) {
    $this->x = 20;
    $this->y = 10;
    $this->w = 132;
    $this->h = 304;

  }

  public function process(Image $image) {
    $im = imagecreatefromstring($image->getStream());
    $im = imagecrop ( $im , ['x'=>$this->x, "y"=>$this->y, "width"=>$this->w, "height"=>$this->h] );
    return new StreamImage(imagejpeg($im));
  }

}
