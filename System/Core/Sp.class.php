<?php
namespace  SP;

/**
 * SP核心类
 */
class Sp
{
	/**
	 * 项目启动
	 */
	static function start() {
		// 路由访问
		Route::access();
	}
}