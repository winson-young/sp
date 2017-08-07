<?php

namespace Core\Interfaces;

interface CacheInterface
{
    /**
     * 设置缓存
     *
     * @param $key string key值
     * @param $expiredSecond int 缓存过期秒数
     *
     * @return boolean 是否设置成功
     */
    function set($key, $value, $expiredSecond);

    /**
     * 获取缓存
     *
     * @param $key string key值
     *
     * @return mixed key对应的缓存
     */
    function get($key);

    /**
     * 删除缓存
     *
     * @param $key string key值
     *
     * @return boolean 是否删除成功
     */
    function delete($key);
}
