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
        // 测试自动加载类
        $component = self::getComponent();
        call_user_func(array(new $component, TASK));
	}

    /**
     * 获取组件类名
     *
     * @return string
     */
    private static function getComponent() {
        return '\\' . APP_NAME . '\\Component\\' . COMPONENT . 'Component';
    }
}