<?php

require __DIR__."/Jobs/EncryptedJob.php";
require __DIR__."/Jobs/ImageJobFactory.php";
require __DIR__."/Images/RemoteImage.php";
require __DIR__."/Processor/Processor.php";
require __DIR__."/Caches/NullCache.php";

$key = "testkey";

if (isset($_GET['a']) && $_GET['a'] == 'r') { // action==render

  $job_str = $_GET['j'];
  $job_sig = $_GET['s'];
  $url = $_GET['u'];

  $job = new EncryptedJob($job_str, $job_sig, $key);
  $image = new RemoteImage($url);

  $p = new Processor($image, $job, new NullCache());

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
