<?php
$jobdescription = [
  "job" => "composite",
  "jobs" => [
    [
    "job" => "composite",
    "jobs" => [
      [
      "job" => 'resize'
      ]
    ]
  ]
  ]
];

$jobdescription = ['job'=>'llc'];

?>

<form method="POST">
  Key: <input type="text" name="k" value="<?php echo isset($_POST['k']) ? $_POST['k'] : 'testkey'; ?>"><br>
  Url: <input type="text" name="u" value="<?php echo isset($_POST['u']) ? $_POST['u'] : 'https://upload.wikimedia.org/wikipedia/commons/9/95/SW_Testbild_auf_Philips_TD1410U.jpg'; ?>"><br>
  Job: <textarea name="j"><?php echo isset($_POST['j']) ? $_POST['j'] : json_encode($jobdescription, JSON_PRETTY_PRINT); ?></textarea><br>
  <input type="submit">
</form>
