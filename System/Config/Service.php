<?php

use Core\Container as Container;
use Core\Cache\Redis as Redis;

$container = Container::instance();

// Redis
$container->set('falseCache', function () {
    return new Redis();
});