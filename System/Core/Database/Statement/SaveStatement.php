<?php

namespace Core\Database\Statement;

use Core\Database\Statement;
use Core\Database\Connection;

class SaveStatement extends Statement
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
     * 设置插入数据
     *
     * @param array $data 插入数据
     */
    private function data(array $data) {
        $this->setColumns(array_keys($data));
        $this->setValue(array_values($data));
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
     * 设置绑定参数
     *
     * @param array $bind 绑定参数
     */
    private function bind(array $bind) {
        $this->setBind($bind);
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

        // 字段与修改值数量是否对应
        if (count($columns) !== count($values)) {
            echo 'Columns\' number not equal to value';
            exit;
        }

        $table = $this->getTable();
        if (empty($table)) {
            echo 'No table is set for insertion';
            exit;
        }

        // 生成sql语句
        $this->sql = 'UPDATE ' . $table . ' SET ';

        foreach ($columns as $key => $column) {
            $value = is_int($values[$key]) ? $values[$key] : "'{$values[$key]}'";
            $this->sql .= $column . ' = ' . $value;
        }

        $where = $this->getWhere();
        if (!empty($where)) {
            $this->sql .= ' WHERE ' . $where;
        }
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
        if ($statement->execute()) {
            // 返回影响行数
            return $statement->rowCount();
        } else {
            // 更新失败
            return false;
        }

    }
}