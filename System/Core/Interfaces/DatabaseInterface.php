<?php

namespace Core\Interfaces;

interface DatabaseInterface
{
    function insert($table,array $data);

    function batchInsert($table,array $data);

    function update($table,array $data);

    function replace($table,array $data);

    function delete($table, $where);

    function select($fields);

    function from($table);

    function where($where);

    function join($table, $on, $joinType);

    function group($field);

    function having($having);

    function order($field, $orderType);
}
