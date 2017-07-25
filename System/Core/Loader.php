<?php

namespace Core;

class Loader
{
    /**
     * @desc 自动加载带命名空间类规则集
     *
     * @var array
     */
    protected $maps = array(
        'Core\\' => array(CORE_PATH)
    );

    /**
     * @desc 初始化自动加载类
     *
     * @return void
     */
    public function __construct() {
        // 加入项目类自动加载规则
        $this->addNamespace(APP_NAME . '\\', SP_PATH . DS . APP_NAME . DS);
    }

    /**
     * @desc 注册自动加载方法
     *
     * @return void
     */
    public function register() {
        spl_autoload_register(array($this, 'loadClass'), true);
    }

    /**
     * @desc 增加自动加载的命名空间规则
     *
     * @param string $prefix 命名空间前缀
     * @param string $baseDir 命名空间所指向的目录
     * @param bool $prepend 优先级, 决定该目录是否优先被搜索
     * @return void
     */
    public function addNamespace($prefix, $baseDir, $prepend = false) {
        // 格式化命名空间前缀书写
        $prefix = trim($prefix, '\\') . '\\';

        // 格式化目录书写
        $baseDir = rtrim($baseDir, DS) . DS;

        // 初始化命名空间规则集
        if (isset($this->maps[$prefix]) === false) {
            $this->maps[$prefix] = array();
        }

        // 根据优先级插入规则集
        if ($prepend) {
            array_unshift($this->maps[$prefix], $baseDir);
        } else {
            array_push($this->maps[$prefix], $baseDir);
        }
    }

    /**
     * @desc 自动加载方法
     *
     * @param string $class 类名
     * @return bool|string 成功则返回文件路径, 非则返回false
     */
    public function loadClass($class) {
        // 当前命名空间前缀
        $prefix = $class;

        // 通过类名查找已映射的文件名
        while (false !== $pos = strrpos($prefix, '\\')) {

            // 截取命名空间
            $prefix = substr($class, 0, $pos + 1);

            // 声明的类名
            $relativeClass = substr($class, $pos + 1);

            // 尝试在命名空间规则中加载文件
            $mapped_file = $this->loadMappedFile($prefix, $relativeClass);
            if ($mapped_file) {
                return $mapped_file;
            }

            // 去除右命名空间分隔符, 以免死循环
            $prefix = rtrim($prefix, '\\');
        }

        // 加载失败
        return false;
    }

    /**
     * @desc 根据命名空间规则集获取文件目录并加载文件
     *
     * @param string $prefix 命名空间前缀
     * @param string $relativeClass 类名
     * @return string|bool 如果没有此文件则返回false, 有则返回文件路径
     */
    protected function loadMappedFile($prefix, $relativeClass) {
        // 没有此命名空间的规则集
        if (isset($this->maps[$prefix]) === false) {
            return false;
        }

        // 搜索规则集中是否存在此文件
        foreach ($this->maps[$prefix] as $baseDir) {

            // 拼接文件路径
            $file = $baseDir . str_replace('\\', DS, $relativeClass) . EXT;

            // 如果文件存在则载入
            if (import($file)) {
                return $file;
            }
        }

        return false;
    }
}
