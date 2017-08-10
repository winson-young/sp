<?php

namespace Core\Database;

use \PDO;

class Connection extends PDO
{

    /**
     * 实例化
     *
     * @return void
     */
    public function __construct($dsn, $user = null, $password = null, array $options = array()) {
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

    public function test($test){
        var_dump($this);
        var_dump($test);
    }
}