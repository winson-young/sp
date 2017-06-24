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
	public static function start()
    {
		// 访问路径
		Route::initRoute();
        // 测试自动加载类
        $task = TASK;
        $component = '\\' . APP_NAME . '\\Component\\' . COMPONENT . 'Component';
        $component = new $component();
        $component->$task();
	}
}