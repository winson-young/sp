<?php

use Core\Loader as Loader;

$loader = Loader::instance();

// 加入项目类自动加载规则
$loader->addNamespace(APP_NAME . '\\', SP_PATH . DS . APP_NAME . DS);