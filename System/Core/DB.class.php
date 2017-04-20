<?php
namespace  SP;
/**
 * Class Model
 * 公共model类
 * 封装部分数据库操作方法
 * @package SP
 */

class DB
{
	
	private static $pdo;
	
	private function __construct(){
		//code
	}
	
	private function __clone(){
		//code
	}
	
	/**
	 * 获取实例化的PDO，单例模式
	 * @return object
	 */
	public static function getInstance($dbConf){
		if(!(self::$pdo instanceof \PDO)){
			$dsn = $dbConf['TYPE'].":host=".$dbConf['HOST'].";port=".$dbConf['PORT'].";dbname=".$dbConf['DBNAME'].";charset=".$dbConf['CHARSET'];
			try {
				self::$pdo = new \PDO($dsn,$dbConf['USER'], $dbConf['PASSWORD'], array(\PDO::ATTR_PERSISTENT => true,\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); //保持长连接
				if (strtolower($dbConf['type']) == 'mysql')
				{
					// 使用缓冲查询
					self::$pdo->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, TRUE);
					//设置超时3秒
					self::$pdo->setAttribute(\PDO::ATTR_TIMEOUT, 3);
				}
				self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);
			} catch (\PDOException $e) {
				print "Error:".$e->getMessage()."<br/>";
				die(); }
		}
		return self::$pdo;
	}
}