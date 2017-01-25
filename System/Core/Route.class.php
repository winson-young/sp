<?php
/**
 * SP路由类
 */
class route
{
	// 控制器类名
	public static $controller = 'Index';
	// 控制器函数名
	public static $function = 'index';

	protected function __construct() {
		self::access();
	}

	/**
	 * 路由访问
	 */
	public function access() {
		if (isset($_SERVER['PATH_INFO'])) {
			$accessRoute = trim($_SERVER['PATH_INFO'], '/');

			if (!empty($accessRoute)) {
				$urlSeparator = explode('/', $accessRoute);
				self::$controller = array_shift($urlSeparator);
				if (count($urlSeparator)) {
					self::$function = array_shift($urlSeparator);
				}
				$this->setGetParam($urlSeparator);
			}
		}
	}

	/**
	 * 处理路由传递的get参数
	 * 如果参数相同, 后面的值则会覆盖前面参数
	 * @param array accessRoute 路由参数
	 */
	private function setGetParam($accessRoute) {
		if (empty($accessRoute))
			return;
		$accessRoute = _addslashes($accessRoute);
		foreach ($accessRoute as $keyCount => $paramers) {
			if ($keyCount % 2) {
				$getParamers[$lastParamers] = $paramers;
			} else {
				$lastParamers = $paramers;
			}
		}
		$_GET = array_merge($getParamers, $_GET);
	}
			
}