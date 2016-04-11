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

require __DIR__."/Jobs/EncryptedJob.php";
require __DIR__."/Jobs/PlainArrayJob.php";
require __DIR__."/Jobs/ImageJobFactory.php";
require __DIR__."/Images/RemoteImage.php";
require __DIR__."/Processor/Processor.php";
require __DIR__."/Caches/NullCache.php";

$key = "testkey";

if (isset($_GET['a']) && $_GET['a'] == 'r') { // action==render

  $job_str = $_GET['j'];
  $job_sig = $_GET['s'];
  $url = $_GET['u'];

  // $job = new EncryptedJob($job_str, $job_sig, $key);
  $job = new PlainArrayJob(["job" =>  "llc"]);
  $image = new RemoteImage($url);

  $p = new Processor($image, $job, new NullCache());
  // var_dump($p->getImage()->getStream()); die;

  header("Content-Type: image/jpg");
  $im = $p->getImage();
  echo $im->getStream();


} else {
  if (count($_POST)) {
    include __DIR__."/form.php";
    $job = EncryptedJob::createJobDescriptionAndSignature(json_decode($_POST['j']), $_POST['k']);
    include __DIR__."/img.php";
    include __DIR__."/dbg.php";

  } else {
    include __DIR__."/form.php";
  }
}
