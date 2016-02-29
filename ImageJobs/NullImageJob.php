<?php


require_once __DIR__."/ImageJob.php";
require_once __DIR__."/../Images/Image.php";

class NullImageJob implements ImageJob {

  public function __construct() {

  }

  public function process(Image $image) {
    return $image;
  }

}
