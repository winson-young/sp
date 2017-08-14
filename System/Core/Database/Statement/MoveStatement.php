<?php

namespace Core\Database\Statement;

use Core\Database\Statement;
use Core\Database\Connection;

class MoveStatement extends Statement
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

        $table = $this->getTable();
        if (empty($table)) {
            echo 'No table is set for insertion';
            exit;
        }

        // 生成sql语句
        $this->sql = 'DELETE FROM ' . $table;

        $where = $this->getWhere();
        if (!empty($where)) {
            $this->sql .= ' WHERE ' . $where;
        }
    }

    /**
     * 执行删除并返回影响行数
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
            // 删除失败
            return false;
        }
    }
}