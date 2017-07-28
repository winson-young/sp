<?php

namespace Core\Cache;

use Core\Interfaces;

class Redis implements Cache
{
    /**
     * 设置缓存
     *
     * @param $key string key值
     * @param $expiredSecond int 缓存过期秒数
     *
     * @return boolean 是否设置成功
     */
    public function set($key, $expiredSecond) {
        return 'redis_set';
    }

    /**
     * 获取缓存
     *
     * @param $key string key值
     *
     * @return mixed key对应的缓存
     */
    public function get($key) {
        return 'redis_get';
    }

    /**
     * 删除缓存
     *
     * @param $key string key值
     *
     * @return boolean 是否删除成功
     */
    public function delete($key) {
        return 'redis_delete';
    }
}