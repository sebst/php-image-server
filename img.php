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
?>
Requested Ressource: <pre><?php echo $_POST['u']; ?></pre> <br>
Resulting Job DESC: <pre><?php echo $job['job']; ?></pre> <br>
Resulting Job SIGN: <pre><?php echo $job['sig']; ?></pre> <br>

<?php $url = "/?a=r&u={$_POST['u']}&j={$job['job']}&s={$job['sig']}" ?>

Resulting URL: <pre><?php echo $url; ?></pre> <br>

<table>
  <tr>
    <td>
      <img src="<?php echo $_POST['u']; ?>">
      <br>
      original
    </td>
    <td>
      <img src="<?php echo $url; ?>">
      <br>
      result
    </td>
  </tr>
</table>
