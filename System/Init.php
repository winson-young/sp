<?php

// 目录分割符号
defined('DS') OR define('DS', DIRECTORY_SEPARATOR);
// SP框架目录
defined('SP_PATH') OR define('SP_PATH', dirname(__FILE__) . DS);
// SP核心类文件
defined('CORE_PATH') OR define('CORE_PATH', SP_PATH . 'Core' . DS);
// SP公共文件目录
defined('COMMON_PATH') OR define('COMMON_PATH', SP_PATH . 'Common' . DS);
// SP类格式
defined('PHP_SUFFIX') OR define('PHP_SUFFIX', '.php');

// 引入Sp公共函数
require_once COMMON_PATH . 'functions.php';
// 自动加载类文件
spl_autoload_register('_autoLoader');

// 项目启动
require_once SP_PATH . DS . 'Core' . DS . 'Sp.php';

Core\Sp::start();