<?php

require_once __DIR__."/Cache.php";

class NullCache implements Cache {

  public function getOrSet($key, Closure $default) {
    return $default();
  }

}
