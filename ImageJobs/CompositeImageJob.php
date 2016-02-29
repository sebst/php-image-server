<?php


require_once __DIR__."/ImageJob.php";
require_once __DIR__."/../Images/Image.php";
require_once __DIR__."/../Jobs/PlainArrayJob.php";

class CompositeImageJob implements ImageJob {

  private $jobs = [];

  public function __construct($job) {
    $jobs = $job['jobs'];
    foreach ($jobs as $job) {
      $this->addJob(ImageJobFactory::create(new PlainArrayJob($job)));
    }
  }

  private function addJob(ImageJob $job) {
    $this->jobs[] = $job;
  }

  public function process(Image $image) {
    foreach ($this->jobs as $job) {
      $image = $job->process($image);
    }
    return $image;
  }

}
