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
