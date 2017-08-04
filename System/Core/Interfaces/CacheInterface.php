<?php

namespace Core\Interfaces;

interface CacheInterface
{
    /**
     * 连接缓存
     *
     * @param $options array 连接需要的信息
     *
     * @return mixed
     */
    public function connect($options);

    /**
     * 设置缓存
     *
     * @param $key string key值
     * @param $expiredSecond int 缓存过期秒数
     *
     * @return boolean 是否设置成功
     */
    public function set($key, $value, $expiredSecond);

    /**
     * 获取缓存
     *
     * @param $key string key值
     *
     * @return mixed key对应的缓存
     */
    public function get($key);

    /**
     * 删除缓存
     *
     * @param $key string key值
     *
     * @return boolean 是否删除成功
     */
    public function delete($key);
}
