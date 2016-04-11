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

require_once __DIR__."/Image.php";

class RemoteImage implements Image {

  private $url;
  private $contents;

  public function __construct($url) {
    $this->url = $url;
  }

  public function getStream() {
    if (is_null($this->contents)) {
      $this->contents = file_get_contents($this->url);
    }
    return $this->contents;
  }

  public function getCacheKey() {
    return base64_encode($this->url);
  }

  public function getSize() {
    return strlen($this->getStream());
  }

}
