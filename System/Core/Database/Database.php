<?php

namespace Core\Database;

use \pdo as Pdo;

class Database extends Pdo
{
    private static $instance = [];

    const INSERT = 'INSERT INTO';

    private $data;

    private $table;

    private $fields;

    /**
     * 实例化
     *
     * @return void
     */
    public function __construct($dsn, $usr, $password, $options) {
        $options = $options + $this->getDefaultOptions();
        parent::__construct($dsn, $usr, $password, $options);
    }

    /**
     * pdo默认配置
     *
     * @return array
     */
    private function getDefaultOptions()
    {
        return array(
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES => false
        );
    }

    public function insert($table = '',array $data = []) {
        if (empty($data) && (empty($this->data) || empty($this->fields))) {
            return false;
        }
        if (empty($table) && empty($this->table)) {
            return false;
        }
        if (!empty($data)) {
            $this->fields = array_keys($data);
            $this->data = array_values($data);
        }
        //$this->commit('insert');
    }

    public function batchInsert($table,array $data) {}

    public function update($table,array $data) {}

    public function replace($table,array $data) {}

    public function delete($table, $where) {}

    public function select($fields) {}

    public function from($table) {}

    public function where($where) {}

    public function join($table, $on, $joinType) {}

    public function group($field) {}

    public function having($having) {}

    public function order($field, $orderType) {}
}