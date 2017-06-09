<?php

namespace Core;

/**
 * SP路由类
 */
class Route
{
    /**
     * @desc 缺省控制器名称
     */
    const component = 'index';

    /**
     * @desc 缺省方法名称
     */
    const task = 'index';

    /**
     * @desc 初始化路由信息
     */
	public static function initRoute()
    {
		// 获取参数
        $params = self::separateParameters();
		// 路由地址获取
        $params = self::getRouteInfo($params);
		// 地址参数化
		self::mergeParametersToGet($params);
	}

    /**
     * @desc 分离路由信息
     * @return array
     */
	private static function separateParameters()
    {
        // 分析访问地址
		if (isset($_SERVER['REQUEST_URI'])) {
			$accessRoute = trim($_SERVER['REQUEST_URI'], '/');
            $pathInfo = pathinfo($accessRoute);
            // 摒除后缀
            if (isset($pathInfo['extension'])) {
                $accessRoute = str_replace('.' . $pathInfo['extension'], '', $accessRoute);
            }
			if (!empty($accessRoute)) {
				return explode('/', $accessRoute);
			}
		}
		return array(self::component, self::task);
	}

    /**
     * @desc 获取路由参数
     * @param $parameters array 参数列表
     * @return array
     */
	private static function getRouteInfo($params)
    {
        // 声明控制器名称
		define('COMPONENT', array_shift($params));

        // 声明方法名称
		if (count($params)) {
			define('FUNCTIONS', array_shift($params));
		} else {
			define('FUNCTIONS', self::task);
		}

		return $params;
	}

    /**
     * @desc 地址参数化
     * @param $parameters array 去除控制器和任务后的参数列表
     * @return boolean
     */
	private static function mergeParametersToGet($params)
    {
		if (empty($params)) {
            return false;
        }

        $params = _addSlashes($params);
		$i = 0;
		while ($params) {
			$j = $i + 1;
			if (isset($params[$j])) {
				$_GET[$params[$i]] = $params[$j];
				unset($params[$j]);
			}
			unset($params[$i]);
			$i += 2;
		}
        return true;
	}
			
}