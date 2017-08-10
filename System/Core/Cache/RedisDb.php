<?php

namespace Core\Cache;

use Core\Interfaces\CacheInterface;
use \Redis;

class RedisDb implements CacheInterface
{
    /**
     * redis资源
     *
     * @var resource
     */
    private $Redis;

    /**
     * 是否已成功连接
     *
     * @var bool
     */
    private $connected = false;

    public function __construct($options) {
        // 连接redis
        $this->connect($options);
    }

    /**
     * 连接Redis
     *
     * @param $options array 连接需要的信息
     */
    protected function connect($options) {
        $this->Redis = new Redis();
        if (!isset($options['timeOut']) || !($options['timeOut'] > 0)) $options['timeOut'] = 0;
        if ($this->Redis->connect($options['ip'], $options['port'], $options['timeOut'])) {
            $this->connected = true;
        }
    }

    /**
     * 获取redis资源
     *
     * @return resource
     */
    private function redis() {
        return $this->Redis;
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

        // 永不超时
        if ($expiredSecond > 0) {
            return $this->redis()->setex($key, $expiredSecond, $value);
        } else {
            return $this->redis()->set($key, $value);
        }
    }

    /**
     * 获取缓存
     *
     * @param $key string
     *
     * @return mixed key对应的缓存
     */
    public function get($key) {
        if (!$this->connected){
            return false;
        }

        return $this->redis()->get($key);
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