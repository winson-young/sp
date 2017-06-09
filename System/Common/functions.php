<?php

/**
 * 自动加载类
 * @param string $class 类名
 */
function _autoLoader($class) {
    var_dump($class);
	$coreClass = SP_PATH . $class . EXT;
	if (import($coreClass)) {
		return true;
	}
	return false;
}

/**
 * 加载文件
 * 检查文件是否存在
 * @param string $fileName 载入完整文件名
 * @return boolean 载入是否成功
 */
function import($fileName) {
	if (file_exists($fileName)) {
		require_once($fileName);
		return true;
	} else {
		return false;
	}
}

/**
 * 数组转义
 * @param string|array $parameters 需转义字符或数组
 * @return string|array 转义结果
 */
function _addSlashes($params) {
	if (empty($params)) return '';
	if (is_array($params)) {
        $slashedParams = array();
		foreach ($params as $key => $value) {
			$newKey = addslashes($key);
			$newValue = addslashes($value);
            $slashedParams[$newKey] = $newValue;
		}
		return $slashedParams;
	} else {
		return addslashes($params);
	}
}