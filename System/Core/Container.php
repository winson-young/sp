<?php

namespace Core;

use \Exception;

class Container
{
    // 非共享服务集合
    protected $service = [];
    // 共享服务集合
    protected $sharedService = [];

    private static $instance;

    private function __construct() {}

    private function __clone() {}

    public static function instance() {
        if (!is_object(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * 设置服务
     *
     * @param $name string 设置服务的名称
     * @param $definition object 服务
     *
     * @return void
     */
    public function set($name, $definition)
    {
        $this->service[$name] = $definition;
    }

    /**
     * 获取服务
     *
     * @param $name string 要获取的服务名
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function get($name)
    {
        if (isset($this->service[$name])) {
            $definition = $this->service[$name];
        } else {
            throw new Exception("Service '" . $name . "' wasn't found in the dependency injection container");
        }

        if (is_object($definition)) {
            $instance = call_user_func($definition);
        }

        return $instance;
    }
}