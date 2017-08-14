<?php

namespace Core\Database;

use \PDO;
use \PDOStatement;
use Core\Database\Connection;

/**
 * Class Statement.
 */
class Statement
{
    /**
     * sql语句
     *
     * @var string
     */
    protected $sql;

    /**
     * 字段集合
     *
     * @var array
     */
    protected $columns = [];

    /**
     * 条件表达式
     *
     * @var string
     */
    protected $where;

    /**
     * 表名
     *
     * @var string
     */
    protected $table;

    /**
     * 插入值
     *
     * @var array
     */
    protected $value = [];

    /**
     * 绑定参数
     *
     * @var array
     */
    protected $bind = [];

    /**
     * @var Connection
     */
    protected $connection;

    /**
     * Constructor
     *
     * @param Connection $connection
     */
    protected function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * 绑定多个参数
     *
     * @param  PDOStatement $statement
     * @param  array  $bindings
     * @return void
     */
    protected function bindValues(PDOStatement $statement, $bindings)
    {
        foreach ($bindings as $key => $value) {
            $statement->bindValue(
                is_string($key) ? $key : $key + 1, $value,
                is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR
            );
        }
    }

    /**
     * 设置字段
     *
     * @param array $columns 字段集合
     */
    protected function setColumns(array $columns) {
        $this->columns = array_merge($this->columns, array_values($columns));
    }

    /**
     * 设置条件
     *
     * @param $where string 条件表达式
     */
    protected function setWhere($where) {
        $this->where = $where;
    }

    /**
     * 设置表名
     *
     * @param $table string 表名
     */
    protected function setTable($table) {
        $this->table = $table;
    }

    /**
     * 设置插入值
     *
     * @param $value array 插入值
     */
    protected function setValue(array $value) {
        $this->value = array_merge($this->value, array_values($value));
    }

    /**
     * 设置绑定参数
     *
     * @param $bind array 绑定参数
     */
    protected function setBind(array $bind) {
        $this->bind = $bind;
    }

    /**
     * 获取字段
     *
     * @return array
     */
    protected function getColumns() {
        return $this->columns;
    }

    /**
     * 获取条件
     *
     * @return string
     */
    protected function getWhere() {
        return $this->where;
    }

    /**
     * 获取表名
     *
     * @return string
     */
    protected function getTable() {
        return $this->table;
    }

    /**
     * 获取插入值
     *
     * @return array
     */
    protected function getValue() {
        return $this->value;
    }

    /**
     * 获取sql语句
     *
     * @return string
     */
    protected function sql() {
        return $this->sql;
    }

    /**
     * 补全插入值
     *
     * @param $value int|string 插入值
     *
     * @return int|string
     */
    protected function valueToString($value) {
        return is_int($value) ? $value : "'{$value}'";
    }

    /**
     * 获取PDOStatement执行后的对象
     *
     * @return \PDOStatement
     */
    protected function getStatement() {
        // 预处理sql
        $statement = $this->connection->prepare($this->sql());

        if (!empty($this->bind)) {
            // 绑定参数
            $this->bindValues($statement, $this->bind);
        }

        // 返回statement对象
        return $statement;
    }

}