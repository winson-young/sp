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
	static function access() {

		$scriptName = $_SERVER['SCRIPT_NAME'];
		$requestUrl = $_SERVER['REQUEST_URI'];
		$accessRoute = trim(str_replace($scriptName, '', $requestUrl, '/'));

		if (!empty($accessRoute)) {
			$urlSeparator = explode('/', $accessRoute);
			self::controller = array_shift($accessRoute);
			if (count($accessRoute)) {
				self::function = array_shift($accessRoute);
			}
			$this->setGetParam($accessRoute);
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
		$lastParamers = '';
		$getParamers = arary();
		foreach ($accessRoute as $keyCount => $paramers) {
			if ($keyCount % 2) {
				$getParamers[$lastParamers] = $paramers;
			} else {
				$lastParamers = $paramers;
			}
		}
		if ($getParamers) {
			$this->mergeGetParamer($getParamers);
		}
	}

	/**
	 * 将路由参数写入全局变量中
	 * @param array getParamer 路由参数
	 */
	private function mergeGetParamer($getParamer) {
		foreach ($getParamer as $key => $paramer) {
			if (!isset($_GET[$key])) {
				$_GET[$key] = $paramer;
			}
		}
	}
			
}