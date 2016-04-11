<?php
/*
 * COPYRIGHT 2016, Sebastian Steins
 * https://seb.st
 *
 * This file is part of php-image-server
 *
 *
 * Copyright (c) 2016 Sebastian Steins <hi@seb.st>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to
 * deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 */

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
