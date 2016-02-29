<?php

require_once __DIR__."/Job.php";


class EncryptedJob implements Job {

  private $jobDescription;
  private $signature;
  private $key;

  function __construct($jobDescription, $signature, $key) {
    $this->jobDescription = $jobDescription;
    $this->signature = $signature;
    $this->key = $key;
  }

  public function authenticate() {
    if ($this->jobDescription != "" && md5($this->jobDescription.$this->key) !== $this->signature) {
      throw new Exception();
    }
    return true;
  }

  public function getJobDescription() {
    if ($this->jobDescription == "") {
      return [];
    }
    return json_decode(gzuncompress(base64_decode($this->jobDescription)), true);
  }

  public function getCacheKey() {
    return $this->jobDescription;
  }

  public static function createJobDescriptionAndSignature($job, $key) {
    $job = base64_encode(gzcompress(json_encode($job)));
    return [
      "job" => $job,
      "sig" => md5($job.$key)
    ];
  }

}
