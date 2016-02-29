<?php

require_once __DIR__."/Image.php";

class StreamImage implements Image {
  private $contents;

  public function __construct($contents) {
    $this->contents = $contents;
  }

  public function getStream() {
    return $this->contents;
  }

  public function getCacheKey() {
    throw new Exception();
  }

  public function getSize() {
    return strlen($this->getStream());
  }

}
