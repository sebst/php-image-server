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
