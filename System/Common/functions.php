<?php

/**
 * 自动加载类
 * @param string clsssName 类名
 */
function _autoLoader($class) {
	$coreClass = SP_CORE_PATH . $class . SP_CLASS_SUFFIX;
	if (import($coreClass)) {
		return true;
	}
	return false;
}

/**
 * 加载文件
 * 检查文件是否存在
 * @param string fileName 载入完整文件名
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
 * @param string||array paramers 需转义字符或数组
 * @return string||array 转义结果
 */
function _addslashes($paramers) {
	if (empty($paramers)) return;
	if (is_array($paramers)) {
		foreach ($paramers as $key => $value) {
			$newKey = addslashes($key);
			$newValue = addslashes($value);
			$slashedParamer[$newKey] = $newValue;
		}
		return $slashedParamer;
	} else {
		return addslashes($paramers);
	}
}

function _getDBConf()
{
	return SP_COMMON_PATH.'/config.php';
}