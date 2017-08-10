<?php

namespace Core\Database;

use Core\Database\Statement\FindStatement;
use \PDO;

class Connection extends PDO
{

    /**
     * 实例化
     *
     * @param $dsn string dsn配置
     * @param $user string 用户名
     * @param $password string 密码
     * @param $options array 其他配置选项
     */
    public function __construct($dsn, $user = null, $password = null, array $options = []) {
        $options = $options + $this->getDefaultOptions();
        parent::__construct($dsn, $user, $password, $options);
    }

    /**
     * PDO默认配置
     *
     * @return array
     */
    private function getDefaultOptions() {
        return array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        );
    }

    /**
     * @param $name string 调用函数名
     * @param $arguments array 参数
     * @return mixed
     */
    public function __call($name, array $arguments) {
        $className = 'Core\\Database\\Statement\\' . ucfirst($name) . 'Statement';
        return (new $className($this, $arguments[0]))->execute();
    }
}