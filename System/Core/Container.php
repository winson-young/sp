<?php

namespace Core;

use \Exception;

class Container
{
    /**
     * 非共享服务集合
     *
     * @var array
     */
    protected $service = [];

    /**
     * 共享服务集合
     *
     * @var array
     */
    protected $sharedService = [];

    /**
     * 储存容器对象
     *
     * @var object
     */
    private static $instance;

    /**
     * Container constructor.
     */
    private function __construct() {}

    /**
     * Container clone.
     */
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
            if (is_object($definition)) {
                $instance = call_user_func($definition);
                return $instance;
            }
        }

        throw new Exception("Service '" . $name . "' wasn't found in the dependency injection container");
    }
}