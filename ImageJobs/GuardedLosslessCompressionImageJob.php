<?php


require_once __DIR__."/ImageJob.php";
require_once __DIR__."/../Images/Image.php";
require_once __DIR__."/../Images/LocalImage.php";
require_once __DIR__."/../Images/StreamImage.php";
require_once __DIR__."/LosslessCompressImageJob.php";

class GuardedLosslessCompressionImageJob implements ImageJob {

  public function __construct() {
    $this->losslessCompressImageJob = new LosslessCompressImageJob();
  }

  public function process(Image $image) {
    $result = $this->losslessCompressImageJob->process($image);

    $im1 = "/tmp/".uniqid()."1";
    file_put_contents($im1, $image->getStream());
    $im2 = "/tmp/".uniqid()."2";
    file_put_contents($im2, $result->getStream());

    $image1 = new Imagick($im1);
    $image2 = new Imagick($im2);

    $w = $image1->getImageWidth();
    $h = $image1->getImageHeight();

    for($x = 0; $x < $w; $x++){
      for($y = 0; $y <$h; $y++){
        $pixel1 = $image1->getImagePixelColor($x, $y)->getColor();
        $pixel2 = $image2->getImagePixelColor($x, $y)->getColor();
        if($pixel1 != $pixel2) {
            unlink($im1);
            unlink($im2);
            return $image;
        }
      }
    }
    unlink($im1);
    unlink($im2);
    return $result;
  }

}
