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
    const controller = 'index';

    /**
     * @desc 缺省方法名称
     */
    const functions = 'index';

    /**
     * @desc 初始化路由信息
     */
	public static function initRoute() {
		// 获取参数
		$paramers = self::separateParamers();
		// 路由地址获取
		$paramers = self::getRouteInfo($paramers);
		// 地址参数化
		self::parameredPath($paramers);
	}

    /**
     * @desc 分离路由信息;
     * @return array
     */
	private static function separateParamers() {
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
		return array(self::controller, self::functions);
	}

    /**
     * @desc 获取路由参数;
     * @return array
     */
	private static function getRouteInfo($paramers) {
        // 声明控制器名称
		define('CONTROLLER', array_shift($paramers));

        // 声明方法名称
		if (count($paramers)) {
			define('FUNCTIONS', array_shift($paramers));
		} else {
			define('FUNCTIONS', 'index');
		}

		return $paramers;
	}

    /**
     * @desc 地址参数化;
     * @return boolean
     */
	private static function parameredPath($paramers) {
		if (empty($paramers)) {
            return false;
        }

		$paramers = _addslashes($paramers);
		$i = 0;
		while ($paramers) {
			$j = $i + 1;
			if (isset($paramers[$j])) {
				$_GET[$paramers[$i]] = $paramers[$j];
				unset($paramers[$j]);
			}
			unset($paramers[$i]);
			$i += 2;
		}
        return true;
	}
			
}