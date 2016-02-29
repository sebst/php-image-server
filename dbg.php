<?php


$job_str = $job['job'];
$job_sig = $job['sig'];
$url = $_POST['u'];


$image = new RemoteImage($url);


$job = new EncryptedJob($job_str, $job_sig, $key);
$image = new RemoteImage($url);
$p = new Processor($image, $job, new NullCache());


$result = $p->getImage();

$orig_size = $image->getSize();
$result_size = $result->getSize();

?>
<hr>
<b>Size of orig:  </b> <?php echo $orig_size ?> bytes<br>
<b>Size of new:  </b> <?php echo $result_size ?> bytes<br>

<b>Ratio:  </b> <?php echo 100-(100*$result_size/$orig_size) ?> %<br>

<hr>
<?php

$im1 = "/tmp/im1";
file_put_contents($im1, $image->getStream());
$im2 = "/tmp/im2";
file_put_contents($im2, $result->getStream());

$image1 = new Imagick($im1);
$image2 = new Imagick($im2);

$w = $image1->getImageWidth();
$h = $image1->getImageHeight();

$pixel_errors = 0;
$pixel_total = 0;

for($x = 0; $x < $w; $x++){
  for($y = 0; $y <$h; $y++){
    $pixel1 = $image1->getImagePixelColor($x, $y)->getColor();
    $pixel2 = $image2->getImagePixelColor($x, $y)->getColor();
    if($pixel1 != $pixel2) {
        $pixel_errors++;
    }
    $pixel_total++;
  }
}

// var_dump($pixel1, $pixel2);

?>

<hr>
<b>Total pixels:  </b> <?php echo $pixel_total . "   (" . $w . " x " . $h . ")" ?> <br>
<b>Error Pixels:  </b> <?php echo $pixel_errors ."   (" . 100*$pixel_errors/$pixel_total . " %)" ?> <br>
<hr>
