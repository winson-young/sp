<?php

use Core\Container as Container;
use Core\Cache\RedisDb as RedisDb;
use Core\Cache\File as File;
use Core\Database\Mysql as Mysql;

$container = Container::instance();

// Redis
$container->set('fastCache', function () {
    return new RedisDb(array(
        'ip' => '127.0.0.1',
        'port' => 6379
    ));
});

// File
$container->set('slowCache', function () {
    return new File(array(
        'path' => SP_PATH . APP_NAME . DS . 'Cache'
    ));
});

// Database
$container->set('db', function () {
    return new Mysql(
        'mysql:dbname=test;host=127.0.0.1;charset=utf8',
        'root',
        '123123'
    );
});