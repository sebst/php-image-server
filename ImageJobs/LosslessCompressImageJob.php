<?php


require_once __DIR__."/ImageJob.php";
require_once __DIR__."/../Images/Image.php";
require_once __DIR__."/../Images/LocalImage.php";
require_once __DIR__."/../Images/StreamImage.php";

class LosslessCompressImageJob implements ImageJob {

  public function __construct() {

  }

  public function process(Image $image) {
    $file_name = uniqid();

    $dest_orig = "/tmp/" . $file_name."orig";
    $dest_compress = "/tmp/" . $file_name."compressed";

    file_put_contents($dest_orig, $image->getStream());

    $cmd = $this->jpegtran($dest_orig, $dest_compress);

    $image = new StreamImage(file_get_contents($dest_compress));
    unlink($dest_orig);
    unlink($dest_compress);
    return $image;

    // return new LocalImage($dest_compress);
  }

  private function jpegtran($dest_orig, $dest_compress) {
    $cmd = "jpegtran -copy none -optimize $dest_orig > $dest_compress";
    exec($cmd);
  }

  private function jpegoptim($dest_orig, $dest_compress) {
    $cmd = "jpegoptim --max=75 --strip-all --all-progressive - < $dest_orig > $dest_compress";
    exec($cmd);
  }

}
