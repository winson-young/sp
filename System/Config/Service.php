<?php

use Core\Container;
use Core\Cache\RedisDb;
use \Core\Cache\MemcacheDb;
use Core\Cache\File;
use Core\Db;

$container = Container::instance();

// Redis
$container->set('fastCache', function () {
    return new RedisDb([
        'ip' => '127.0.0.1',
        'port' => 6379
    ]);
});

// memcache
$container->set('cache', function () {
    return new MemcacheDb([
        'ip' => '127.0.0.1',
        'port' => 11211
    ]);
});

// File
$container->set('slowCache', function () {
    return new File([
        'path' => SP_PATH . APP_NAME . DS . 'Cache'
    ]);
});

// localDb
$container->set('localDb', function () {
    return Db::instance([
        'write' => [[
            'dsn' => 'mysql:dbname=test;host=127.0.0.1;charset=utf8',
            'user' => 'root',
            'password' => '123123'
        ]],
        'read' => [[
            'dsn' => 'mysql:dbname=test;host=127.0.0.1;charset=utf8',
            'user' => 'root',
            'password' => '123123'
        ]]
    ]);
});