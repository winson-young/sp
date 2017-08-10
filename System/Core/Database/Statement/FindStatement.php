<?php

namespace Core\Database\Statement;

use Core\Database\Statement;
use Core\Database\Connection;

class FindStatement extends Statement
{
    /**
     * Constructor
     *
     * @param Connection $connection pdo连接句柄
     * @param array $condition 查找条件
     */
    public function __construct(Connection $connection, array $condition = []) {
        parent::__construct($connection);

        foreach ($condition as $method => $argument) {
            if (is_callable([$this, $method])) {
                $this->$method($argument);
            }
        }
    }

    /**
     * 设置字段
     *
     * @param array $columns 字段名
     */
    private function column(array $columns) {
        $this->setColumns($columns);
    }

    /**
     * 设置条件
     *
     * @param string $where 条件表达式
     */
    private function where($where = '') {
        $this->setWhere($where);
    }

    /**
     * 设置表名
     *
     * @param string $table 表名
     */
    private function table($table = '') {
        $this->setTable($table);
    }

    /**
     * 生成sql
     */
    protected function makeSql() {
        $columns = $this->getColumns();
        if (empty($columns)) {
            echo 'Missing columns for insertion';
        }

        $table = $this->getTable();
        if (empty($table)) {
            echo 'No table is set for insertion';
        }

        $this->sql = 'SELECT ' . $columns . ' FROM ' . $table;

        $where = $this->getWhere();
        if (!empty($where)) {
            $this->sql .= ' WHERE ' . $where;
        }
    }

    /**
     * 执行并返回结果
     *
     * @return array
     */
    public function execute() {
        // 生成sql
        $this->makeSql();
        // 获取预处理语句后的statement对象
        $statement = $this->getStatement();
        // 执行
        $statement->execute();
        // 获取结果集
        $result = $statement->fetchAll();
        return $result;
    }
}