<?php

namespace Core;

use Core\Container as Container;

/**
 * SP基类
 */
class Basic
{
    /**
     * @param $name string 属性名
     * @return mixed
     */
    public function __get($name)
    {
        // 实例化容器
        $container = Container::instance();
        return $container->get($name);
    }
}