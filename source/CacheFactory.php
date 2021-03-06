<?php
/*
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace alxmsl\Primitives;
use alxmsl\Connection\Redis\Connection;
use alxmsl\Primitives\Cache\Cache;
use alxmsl\Primitives\Cache\Provider\MemcachedProvider;
use alxmsl\Primitives\Cache\Provider\PredisProvider;
use alxmsl\Primitives\Cache\Provider\RedisProvider;
use Memcached;
use Predis\Client;

/**
 * Cache instances factory
 * @author alxmsl
 * @date 8/29/14
 */
final class CacheFactory {
    /**
     * Create cache instance on predis factory method
     * @param string $name root cache key name
     * @param string $levelClass cache instance class
     * @param Client $Client predis connection
     * @return null|Cache cache instance or null if level class not found
     */
    public static function createPredisCache($name, $levelClass, Client $Client) {
        if (is_a($levelClass, Cache::class, true)
            && class_exists($levelClass)) {

            $Provider = new PredisProvider();
            $Provider->setClient($Client);
            /** @var Cache $Instance */
            $Instance = new $levelClass($name);
            return $Instance->setProvider($Provider);
        } else {
            return null;
        }
    }

    /**
     * Create cache instance on redis factory method
     * @param string $name root cache key name
     * @param string $levelClass cache instance class
     * @param Connection $Connection redis connection
     * @return null|Cache cache instance or null if level class not found
     */
    public static function createRedisCache($name, $levelClass, Connection $Connection) {
        if (is_a($levelClass, Cache::class, true)
            && class_exists($levelClass)) {

            $Provider = new RedisProvider();
            $Provider->setConnection($Connection);
            /** @var Cache $Instance */
            $Instance = new $levelClass($name);
            return $Instance->setProvider($Provider);
        } else {
            return null;
        }
    }

    /**
     * Create cache instance factory method
     * @param string $name root cache key name
     * @param string $levelClass cache instance class
     * @param Memcached $Connection memcached connection
     * @return null|Cache cache instance or null if level class not found
     */
    public static function createMemcachedCache($name, $levelClass, Memcached $Connection) {
        if (is_a($levelClass, Cache::class, true)
            && class_exists($levelClass)) {

            $Provider = new MemcachedProvider();
            $Provider->setConnection($Connection);
            /** @var Cache $Instance */
            $Instance = new $levelClass($name);
            return $Instance->setProvider($Provider);
        } else {
            return null;
        }
    }
}
