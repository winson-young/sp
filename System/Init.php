<?php

// 声明常用常量
// 目录分割符号
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
// SP框架目录
defined('SP_PATH') OR define('SP_PATH', dirname(__FILE__) . DS);
// SP核心类文件
defined('SP_CORE_PATH') OR define('SP_CORE_PATH', SP_PATH . 'Core' . DS);
// SP公共文件目录
defined('SP_COMMON_PATH') OR define('SP_COMMON_PATH', SP_PATH . 'Common' . DS);
// SP类格式
defined('SP_CLASS_SUFFIX') OR define('SP_CLASS_SUFFIX', '.class.php');

// 引入Sp公共函数
require_once SP_COMMON_PATH . 'functions.php';
// 自动加载类文件
spl_autoload_register('_autoLoader');

// 项目启动
Sp::start();
?>