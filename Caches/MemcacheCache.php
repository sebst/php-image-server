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

require_once __DIR__ . "/Cache.php";

class MemcacheCache implements Cache
{

    /**
     * Hostname used for the memcache connection.
     *
     * @var string
     */
    private $hostname = null;

    /**
     * Port used for the memcached connection.
     *
     * @var int
     */
    private $port = null;

    /**
     * The unique pool id.
     *
     * @var string
     */
    private $poolId = null;
    
    /**
     * The ttl for compressed images.
     *
     * @var int
     */
    private $ttl = null;

    /**
     * The memcache conneciton.
     *
     * @var Memcache
     */
    private $memcache = null;

    /**
     * Constructor.
     *
     * @param string $hostname
     *            Hostname used for the memcached connection.
     * @param int $port
     *            Port used for the memcached connection.
     * @param int $ttl
     *            TTL for compressed images.
     * @throws RuntimeException If the storage is unable to connect to memcache server.
     */
    public function __construct($hostname, $port, $ttl)
    {
        $this->hostname = (string) $hostname;
        $this->port = (int) $port;
        $this->ttl = (int) $ttl;
        $this->poolId = "php-image-server" . '/';
        $this->memcache = new Memcache();
        $this->memcache->addserver($this->hostname, $this->port);
        
        $serverKey = $this->hostname . ':' . $this->port;
        
        $stats = $this->memcache->getExtendedStats();
        if ($stats[$serverKey] === false) {
            throw new RuntimeException('Memcached server not started: ' . $this->hostname . ':' . $this->port);
        }
        
        if (! $this->memcache->connect($this->hostname, $this->port)) {
            throw new RuntimeException('Unable to connect to memcached server: ' . $this->hostname . ':' . $this->port);
        }
    }

    public function getOrSet($key, Closure $default)
    {
        try {
            return $this->retrieve($key);
        } catch (Exception $e) {
            $res = $default();
            $this->store($key, $res, $this->ttl);
        }
    }

    private function store($key, $value, $ttl)
    {
        $this->memcache->set($this->poolId . $key, $value, MEMCACHE_COMPRESSED, $ttl);
    }

    private function retrieve($key)
    {
        $flags = false;
        
        $result = $this->memcache->get($this->poolId . $key, $flags);
        
        if ($flags === false) {
            throw new OutOfRangeException('Value for key does not exist: ' . $key);
        }
        
        return $result;
    }
}
