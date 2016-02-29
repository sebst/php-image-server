<?php

require_once __DIR__."/Cachable.php";

interface Cache {

  public function getOrSet($key, Closure $default);

}
