<?php

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
