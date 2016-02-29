<?php

interface Image {

  public function getStream();

  public function getCacheKey();

  public function getSize();

}
