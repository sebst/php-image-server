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

require_once __DIR__ . "/Job.php";

class EncryptedJob implements Job
{

    private $jobDescription;

    private $signature;

    private $key;

    function __construct($jobDescription, $signature, $key)
    {
        $this->jobDescription = $jobDescription;
        $this->signature = $signature;
        $this->key = $key;
    }

    public function authenticate()
    {
        if ($this->jobDescription != "" && md5($this->jobDescription . $this->key) !== $this->signature) {
            throw new Exception();
        }
        return true;
    }

    public function getJobDescription()
    {
        if ($this->jobDescription == "") {
            return [];
        }
        return json_decode(gzuncompress(base64_decode($this->jobDescription)), true);
    }

    public function getCacheKey()
    {
        return $this->jobDescription;
    }

    public static function createJobDescriptionAndSignature($job, $key)
    {
        $job = base64_encode(gzcompress(json_encode($job)));
        return [
            "job" => $job,
            "sig" => md5($job . $key)
        ];
    }
}
