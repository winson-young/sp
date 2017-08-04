<?php

use Core\Container as Container;
use Core\Cache\RedisDb as RedisDb;

$container = Container::instance();

// Redis
$container->set('fastCache', function () {
    return new RedisDb(array(
        'ip' => '127.0.0.1',
        'port' => 6379
    ));
});