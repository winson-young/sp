<?php

namespace Core;

/**
 * SP核心类
 */
class Sp
{
	/**
	 * 项目启动
	 */
	public static function start() {
		// 访问路径
		Route::initRoute();
	}
}