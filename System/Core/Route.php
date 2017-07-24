<?php

namespace Core;

/**
 * SP路由类
 */
class Route
{
    /**
     * @desc 缺省组件名称
     *
     * @var string
     */
    const component = 'Index';

    /**
     * @desc 缺省任务名称
     *
     * @var string
     */
    const task = 'index';

    /**
     * @desc 初始化路由信息
     */
	public static function initRoute()
    {
		// 获取参数
        $params = self::parameter();
		// 路由地址获取
        $params = self::route($params);
	    // 地址参数化
		self::merge($params);
	}

    /**
     * @desc 分离路由信息
     *
     * @return array
     */
	private static function parameter()
    {
        $defaultParam = array(self::component, self::task);
        // 分析访问地址
        $route    = self::originalRoute();
        $pathInfo = pathinfo($route);
        // 摒除后缀
        if (isset($pathInfo['extension'])) {
            $route = str_replace('.' . $pathInfo['extension'], '', $route);
        }
        if (!empty($route)) {
            $defaultParam = explode('/', $route);
        }
        if (($pos = strpos($pathInfo['extension'], '?')) !== false) {
            $query = substr($pathInfo['extension'], -(strlen($pathInfo['extension']) - $pos - 1));
            $query = self::query($query);
            $defaultParam = self::completeParam($defaultParam, $query);
        }
		return $defaultParam;
	}

	private static function query($query)
    {
        $data = array();
        if (!empty($query)) {
            $query = explode('&', $query);
            foreach ($query as $value) {
                $pos = strpos($value, '=');
                if (false !== $pos) {
                    $left  = substr($value, 0, $pos);
                    $right = substr($value, -(strlen($value) - $pos - 1));
                    array_push($data, $left, $right);
                }
            }
        }
        return $data;
    }

	private static function completeParam($defaultParam, $query)
    {
        $count = count($defaultParam);
        if (1 === $count) {
            $defaultParam[] = self::task;
        }
        array_splice($defaultParam, 2, 0, $query);
        return $defaultParam;
    }

    /**
     * @desc 获取路由参数
     *
     * @return string
     */
    private static function originalRoute()
    {
        // 判断php运行方式来获取路由参数
        if (PHP_SAPI === 'cli') {
            $args = array_slice($_SERVER['argv'], 1);
	        return $args ? implode('/', $args) : '';
        } else {
            return isset($_SERVER['REQUEST_URI']) ? trim($_SERVER['REQUEST_URI'], '/') : '';
        }
    }

    /**
     * @desc 获取路由参数
     *
     * @param $parameters array 参数列表
     * @return array
     */
	private static function route($params)
    {
        // 声明控制器名称
		define('COMPONENT', ucfirst(array_shift($params)));

        // 声明方法名称
		if (count($params)) {
			define('TASK', array_shift($params));
		} else {
			define('TASK', self::task);
		}

		return $params;
	}

    /**
     * @desc 地址参数化
     *
     * @param $parameters array 去除控制器和任务后的参数列表
     * @return boolean
     */
	private static function merge($params)
    {
		if (empty($params)) {
            return false;
        }
        
	    $params = _addSlashes($params);
		while ($params) {
		    $value = current($params);
		    $key   = key($params);
            $nextValue = next($params);
            $nextKey   = key($params);
            if ($nextKey !== $key) {
                $_GET[$value] = $nextValue;
            }
            unset($params[$key]);
            unset($params[$nextKey]);
        }
        return true;
	}
			
}