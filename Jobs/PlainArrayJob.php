<?php

require_once __DIR__."/Job.php";
require_once __DIR__."/../ImageJobs/NullImageJob.php";
require_once __DIR__."/../ImageJobs/CropImageJob.php";


class PlainArrayJob implements Job {

  private $jobDescription;
  private $signature;
  private $key;

  function __construct($jobDescription) {
    $this->jobDescription = $jobDescription;
  }

  public function authenticate() {
    return true;
  }

  public function getJobDescription() {
    return $this->jobDescription;
  }

  public function getCacheKey() {
    throw new Exception();
  }

}
