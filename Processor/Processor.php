<?php

require_once __DIR__."/../Images/Image.php";
require_once __DIR__."/../Jobs/Job.php";
require_once __DIR__."/../Jobs/ImageJobFactory.php";
require_once __DIR__."/../Caches/Cache.php";

class Processor {

  private $image;
  private $job;
  private $cache;

  function __construct(Image $image, Job $job, Cache $cache) {
    $this->image = $image;
    $this->job = $job;
    $this->cache = $cache;
  }

  function getImage() {
    $processor = ImageJobFactory::create($this->job);
    $image = $this->image;
    try {
      $cache_key = $this->image->getCacheKey() . $this->job->getCacheKey();
      return $this->cache->getOrSet($cache_key, function() use ($processor, $image) { return $processor->process($this->image);});
    } catch(Exception $e) {
      return $processor->process($this->image);
    }
  }

}
