<?php

namespace Core\Common;

use Core\Loader;

class General
{
    /**
     * 加载文件
     * 检查文件是否存在
     *
     * @param $fileName string 载入完整文件名
     *
     * @return boolean 载入是否成功
     */
    public static function import($fileName) {
        if (file_exists($fileName)) {
            require_once($fileName);
            return true;
        } else {
            return false;
        }
    }

    /**
     * 数组转义 不转移数组下标
     *
     * @param $parameters string|array 需转义字符或数组
     *
     * @return string|array 转义结果
     */
    public static function deepAddSlashes($params) {
        if (empty($params)) return $params;
        return is_array($params) ? array_map(array('General', 'deepAddSlashes'), $params) : addslashes($params);
    }

    /**
     * 注册自动加载方法
     *
     * @param $class string 要实例化的类名
     *
     * @return bool|string 成功则返回文件路径, 非则返回false
     */
    public static function loadClass($class) {
        $loader = Loader::instance();
        return $loader->loadClass($class);
    }

    /**
     * 随机获取数组中的值
     *
     * @param array $array
     *
     * @return mixed
     */
    public static function arrayRandValue(array $array) {
        $key = array_rand($array);
        return $array[$key];
    }

    /**
     * 格式化数据库配置信息
     *
     * @param array $options 数据库配置信息
     *
     * @return array
     */
    public static function formatDatabaseOption(array $options) {
        if (!isset($options['dsn']) || !is_string($options['dsn'])) {
            $options['dsn'] = '';
        }
        if (!isset($options['user']) || !is_string($options['user'])) {
            $options['user'] = null;
        }
        if (!isset($options['password']) || !is_string($options['password'])) {
            $options['password'] = null;
        }
        if (!isset($options['options']) || !is_array($options['options'])) {
            $options['options'] = array();
        }
        return $options;
    }
}