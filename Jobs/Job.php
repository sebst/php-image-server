<?php


interface Job {

  public function getJobDescription();

  public function authenticate();

  public function getCacheKey();

}
