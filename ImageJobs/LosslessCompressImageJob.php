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

require_once __DIR__ . "/ImageJob.php";
require_once __DIR__ . "/../Images/Image.php";
require_once __DIR__ . "/../Images/LocalImage.php";
require_once __DIR__ . "/../Images/StreamImage.php";

class LosslessCompressImageJob implements ImageJob
{

    public function __construct()
    {}

    public function process(Image $image)
    {
        $file_name = uniqid();
        
        $dest_orig = "/tmp/" . $file_name . "orig";
        $dest_compress = "/tmp/" . $file_name . "compressed";
        
        file_put_contents($dest_orig, $image->getStream());
        
        $cmd = $this->jpegtran($dest_orig, $dest_compress);
        
        $image = new StreamImage(file_get_contents($dest_compress));
        unlink($dest_orig);
        unlink($dest_compress);
        return $image;
        
        // return new LocalImage($dest_compress);
    }

    private function jpegtran($dest_orig, $dest_compress)
    {
        $cmd = "jpegtran -copy none -optimize $dest_orig > $dest_compress";
        exec($cmd);
    }

    private function jpegoptim($dest_orig, $dest_compress)
    {
        $cmd = "jpegoptim --max=75 --strip-all --all-progressive - < $dest_orig > $dest_compress";
        exec($cmd);
    }
}
