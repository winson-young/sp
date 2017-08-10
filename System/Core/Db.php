<?php

namespace Core;

use Core\Common\General;
use Core\Database\Connection;

class Db
{
    /**
     * 储存db连接对象
     *
     * @var array
     */
    private static $instance = [];

    /**
     * Db constructor.
     */
    private function __construct() {}

    /**
     * Db clone.
     */
    private function __clone() {}

    /**
     * 获取数据库连接对象
     *
     * @param array $options 数据库配置信息
     * @param string $default 默认返回数据库类型 (读、写)
     *
     * @return object
     */
    public static function instance(array $options = array(), $default = 'read') {
        // 获取读取数据库配置
        if (isset($options['read'])) {
            // 随机连接数据库
            $read = General::arrayRandValue($options['read']);
        } else {
            $read = General::arrayRandValue($options);
            if (!isset($read['dsn'])) {
                echo 'could not connect database with empty dsn.';
                exit;
            }
        }
        // 获取写入数据库配置
        if (isset($options['write'])) {
            $write = General::arrayRandValue($options['write']);
        } else {
            $write = $read;
        }
        // 保存读取数据库连接句柄
        if (!isset(self::$instance['read']) || !is_object(self::$instance['read'])) {
            $read = General::formatDatabaseOption($read);
            self::$instance['read'] = new Connection($read['dsn'], $read['user'], $read['password'], $read['options']);
        }
        // 保存写入数据库连接句柄
        if (!isset(self::$instance['write']) || !is_object(self::$instance['write'])) {
            $write = General::formatDatabaseOption($write);
            self::$instance['write'] = new Connection($write['dsn'], $write['user'], $write['password'], $write['options']);
        }
        if ($default === 'write') {
            return self::$instance['write'];
        } else {
            return self::$instance['read'];
        }
    }
}