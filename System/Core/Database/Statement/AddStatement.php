<?php

namespace Core\Database\Statement;

use Core\Database\Statement;
use Core\Database\Connection;

class AddStatement extends Statement
{
    // 是否批量插入
    private $batch = false;

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
     * 设置插入值
     *
     * @param array $value 插入值
     */
    private function value(array $value) {
        if(count($value) === count($value, COUNT_RECURSIVE)) {
            $value = [$value];
        } else {
            // 批量插入
            $this->batch = true;
        }
        $this->setValue($value);
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
            exit;
        }

        $values = $this->getValue();
        if (empty($values)) {
            echo 'Missing value for insertion';
            exit;
        }

        $table = $this->getTable();
        if (empty($table)) {
            echo 'No table is set for insertion';
            exit;
        }

        // 生成sql语句
        $this->sql = 'INSERT INTO ' . $table . ' (' . implode(', ', $columns) . ') VALUES ';

        foreach ($values as $value) {
            // 字段与修改值数量是否对应
            if (count($columns) !== count($value)) {
                echo 'Columns\' number not equal to value';
                exit;
            }
            $this->sql .= '(';
            foreach ($value as $item) {
                $this->sql .= $this->valueToString($item) . ', ';
            }
            $this->sql = rtrim($this->sql, ', ');
            $this->sql .= '), ';
        }
        $this->sql = rtrim($this->sql, ', ');
    }

    /**
     * 执行并返回影响行数
     *
     * @return int|boolean
     */
    public function execute() {
        // 生成sql
        $this->makeSql();
        // 获取预处理语句后的statement对象
        $statement = $this->getStatement();
        // 执行
        $status = $statement->execute();
        if ($status && !$this->batch) {
            // 返回最后插入ID
            return $this->connection->lastInsertId();
        } else {
            return $status;
        }
    }
}