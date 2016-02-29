<?php

require_once __DIR__."/Job.php";
require_once __DIR__."/PlainArrayJob.php";
require_once __DIR__."/../ImageJobs/NullImageJob.php";
require_once __DIR__."/../ImageJobs/ResizeImageJob.php";
require_once __DIR__."/../ImageJobs/CropImageJob.php";
require_once __DIR__."/../ImageJobs/CompositeImageJob.php";
require_once __DIR__."/../ImageJobs/LosslessCompressImageJob.php";
require_once __DIR__."/../ImageJobs/GuardedLosslessCompressionImageJob.php";

class ImageJobFactory {

  static function create(Job $job) {
    $job = $job->getJobDescription();
    switch ($job['job']) {
      case 'resize':
        return new ResizeImageJob($job);
      case 'composite':
        return new CompositeImageJob($job);
      case 'null':
        return new NullImageJob();
      case 'llc':
        return new LosslessCompressImageJob($job);
      case 'gllc':
        return new GuardedLosslessCompressionImageJob($job);
    }

    return new NullImageJob();

  }

}
