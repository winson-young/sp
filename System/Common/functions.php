<?php

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
 * 数组转义 不转移数组下标
 * @param string|array $parameters 需转义字符或数组
 * @return string|array 转义结果
 */
function deepAddSlashes($params) {
	if (empty($params)) return $params;
    return is_array($params) ? array_map('deepAddSlashes', $params) : addslashes($params);
}