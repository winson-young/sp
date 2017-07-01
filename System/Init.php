<?php

// 目录分割符号
defined('DS')          OR define('DS', DIRECTORY_SEPARATOR);
// 项目根目录
defined('SP_PATH')     OR define('SP_PATH', dirname(dirname(__FILE__)) . DS);
// SP框架目录
defined('SYSTEM_PATH') OR define('SYSTEM_PATH', SP_PATH . 'System' . DS);
// SP核心类文件
defined('CORE_PATH')   OR define('CORE_PATH', SYSTEM_PATH . 'Core' . DS);
// SP公共文件目录
defined('COMMON_PATH') OR define('COMMON_PATH', SYSTEM_PATH . 'Common' . DS);
// SP类格式
defined('EXT')         OR define('EXT', '.php');

// 引入函数库
require_once COMMON_PATH . 'functions.php';
// 自动加载类
require_once CORE_PATH . 'Loader.php';

set_error_handler('exceptionErrorHandler', E_ALL);

// 注册自动加载
$autoLoader = new \Core\Loader();
$autoLoader->register();

Core\Sp::start();