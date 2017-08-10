<?php

namespace Core\Cache;

use Core\Interfaces\CacheInterface;

class File implements CacheInterface
{

    /**
     * cache目录路径
     *
     * @var string
     */
    private $path;

    /**
     * cache文件路径
     *
     * @var string
     */
    private $cacheFile;

    /**
     * cache临时文件路径
     *
     * @var string
     */
    private $tmpFile;

    /**
     * cache文件最后更新时间
     *
     * @var int
     */
    private $cacheMakeTime;

    /**
     * 是否已成功读取文件
     *
     * @var bool
     */
    private $connected = false;

    public function __construct($options) {
        // 设置缓存路径
        $this->path($options);
    }

    /**
     * 设置缓存路径
     *
     * @param $options array 设置文件缓存路径信息
     */
    protected function path($options) {
        $options['path'] = isset($options['path']) ? rtrim(rtrim($options['path'], '\\'), DS) : '';
        if (!empty($options['path'])) {
            if (!is_dir($options['path'])) {
                mkdir($options['path'], 0777);
            }
            $this->path = $options['path'] . DS;
            return true;
        }
        echo 'the cache path: ' . $options['path'] . ' is not a directer';
        exit;
    }

    /**
     * 获取临时缓存文件句柄
     *
     * @param $fileName
     *
     * @return bool|resource
     */
    private function file($fileName) {
        $fileName = $this->fileName($fileName);
        // 保存cache文件最后更新时间
        $this->setCacheMakeTime($this->getCacheFile());
        // 创建临时缓存文件
        if ($this->twinningCache($fileName)) {
            $this->connected = true;
            // 获取临时缓存文件句柄
            return fopen($this->getTmpFile(), 'w+');
        } else {
            $this->connected = false;
            return false;
        }
    }

    /**
     * 保存缓存文件更新时间
     *
     * @param $cacheFile string 缓存文件路径
     */
    private function setCacheMakeTime($cacheFile) {
        $this->cacheMakeTime = $this->fileMakeTime($cacheFile);
    }

    /**
     * 获取缓存文件更新时间
     *
     * @return int
     */
    private function getCacheMakeTime() {
        return $this->cacheMakeTime;
    }

    /**
     * 设置缓存文件路径
     *
     * @param $fileName string 缓存文件名
     */
    private function setCacheFile($fileName) {
        $this->cacheFile = $this->path . $this->fileName($fileName);
    }

    /**
     * 获取缓存文件路径
     *
     * @return string
     */
    private function getCacheFile() {
        return $this->cacheFile;
    }

    /**
     * 获取缓存文件全名
     *
     * @param $fileName string 缓存文件名
     *
     * @return string
     */
    private function fileName($fileName) {
        return $fileName . EXT;
    }

    /**
     * 生成临时缓存文件路径
     *
     * @param $fileName string 真实缓存文件全名
     */
    private function renamedCache($fileName) {
        $fileName = str_replace(EXT, '', $fileName);
        $rand = time() . substr(md5(microtime()), 0, rand(5, 12));
        $this->setTmpFile($this->path . $fileName . $rand . EXT);
    }

    /**
     * 保存临时缓存文件路径
     *
     * @param $cacheFile string 临时缓存文件路径
     */
    private function setTmpFile($cacheFile) {
        $this->tmpFile = $cacheFile;
    }

    /**
     * 获取临时缓存文件路径
     *
     * @return string
     */
    private function getTmpFile() {
        return $this->tmpFile;
    }

    /**
     * 生成临时缓存文件
     *
     * @param $fileName string 真实缓存文件全名
     *
     * @return bool
     */
    private function twinningCache($fileName) {
        // 循环获取临时缓存文件路径
        while (is_null($this->getTmpFile()) || file_exists($this->getTmpFile())) {
            $this->renamedCache($fileName);
        }
        $cacheFile = $this->getCacheFile();
        if (file_exists($cacheFile)) {
            return copy($cacheFile, $this->getTmpFile());
        }
        return true;
    }

    /**
     * 获取文件最后更新时间（无缓存）
     *
     * @param $file string 文件路径
     *
     * @return int
     */
    private function fileMakeTime($file) {
        clearstatcache();
        return file_exists($file) ? filemtime($file) : 0;
    }

    /**
     * 保存缓存
     *
     * @param $key string 缓存key
     * @param $content mixed 缓存内容
     *
     * @return bool
     */
    private function saveCache($key, $content) {
        // 获取cache句柄
        $file = $this->file($key . EXT);
        if ($this->connected) {
            fwrite($file, $content);
            fclose($file);
            $cacheFile = $this->getCacheFile();
            $fileMakeTime = $this->fileMakeTime($cacheFile);
            $tmpFile = $this->getTmpFile();
            // 比对缓存文件最后更新时间 (如果不相同，则保存途中有其他人修改过内容，保存失败)
            if ($fileMakeTime === $this->getCacheMakeTime()) {
                // 覆盖原cache文件
                $this->rename($tmpFile, $cacheFile);
                return true;
            } else {
                unlink($tmpFile);
            }
        }
        return false;
    }

    /**
     * 重命名原文件（旧文件存在则覆盖）
     *
     * @param $newFile string 新文件
     * @param $oldFile string 旧文件
     *
     * @return bool
     */
    private function rename($newFile, $oldFile) {
        if (file_exists($oldFile)) {
            unlink($oldFile);
        }
        rename($newFile, $oldFile);
        return true;
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
        // 设置缓存文件路径
        $this->setCacheFile($key);
        if (is_string($key) && !empty($value)) {
            $content = array(
                'cache' => $value,
                'makeTime' => time(),
                // 记录过期秒数
                'expiredSecond' => $expiredSecond > 0 ? $expiredSecond : 0
            );
            $content = json_encode($content);
            // 保存缓存
            return $this->saveCache($key, $content);
        }
        return false;
    }

    /**
     * 获取缓存
     *
     * @param $key string|array 支持多个key
     *
     * @return mixed key对应的缓存
     */
    public function get($key) {
        if (is_string($key)) {
            // 设置缓存文件路径
            $this->setCacheFile($key);
            return $this->read($this->getCacheFile());
        }
        return false;
    }

    /**
     * 读取文件内容
     *
     * @param $file string 文件路径
     *
     * @return bool
     */
    private function read($file) {
        if (file_exists($file)) {
            $content = json_decode(file_get_contents($file), true);
            if (!is_null($content)) {
                // 缓存是否过期
                if ((time() - $content['makeTime']) <= $content['expiredSecond']) {
                    return $content['cache'];
                } else {
                    unlink($this->getCacheFile());
                }
            }
        }
        return false;
    }

    /**
     * 删除缓存
     *
     * @param $key string key值
     *
     * @return boolean 是否删除成功
     */
    public function delete($key) {
        $this->setCacheFile($key);
        return unlink($this->getCacheFile());
    }
}