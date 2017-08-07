<?php

namespace Core\Cache;

use Core\Interfaces\CacheInterface as CacheInterface;
use \Memcache;

class MemcacheDb implements CacheInterface
{
    /**
     * memcache资源
     *
     * @var resource
     */
    private $Memcache;

    /**
     * 是否已成功连接
     *
     * @var bool
     */
    private $connected = false;

    public function __construct($options) {
        // 连接memcache
        $this->connect($options);
    }

    /**
     * 连接Redis
     *
     * @param $options array 连接需要的信息
     */
    protected function connect($options) {
        $this->Memcache = new Memcache();
        if (isset($options['ip']) && isset($options['port'])) {
            $this->connected = $this->Memcache->connect($options['ip'], $options['port']);
        }
    }

    /**
     * 获取memcache资源
     *
     * @return resource
     */
    private function memcache() {
        return $this->Memcache;
    }

    /**
     * 设置缓存
     *
     * @param $key string key值
     * @param $expiredSecond int 缓存过期秒数
     *
     * @return boolean 是否设置成功
     */
    public function set($key, $value, $expiredSecond = 0) {
        if (!$this->connected){
            return false;
        }

        if ($expiredSecond > 0) {
            $expiredSecond = $expiredSecond >  2592000 ?  2592000 : $expiredSecond;
        } else {
            $expiredSecond = 0;
        }
        return $this->memcache()->add($key, $value, false, $expiredSecond);
    }

    /**
     * 获取缓存
     *
     * @param $key string|array 支持多个key
     *
     * @return mixed key对应的缓存
     */
    public function get($key) {
        if (!$this->connected){
            return false;
        }

        // 是否一次取多个值
        $get    = is_array($key) ? 'mGet': 'get';
        return $this->redis()->{$get}($key);
    }

    /**
     * 删除缓存
     *
     * @param $key string key值
     *
     * @return boolean 是否删除成功
     */
    public function delete($key) {
        if (!$this->connected){
            return false;
        }

        return $this->redis()->delete($key);
    }
}