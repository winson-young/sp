<?php
/**
 * Created by IntelliJ IDEA.
 * User: Msi
 * Date: 2017/4/20 0020
 * Time: 14:36
 */

namespace SP;
use SP\DB;

class Model
{
	protected static $db;
	protected static $instance;
	protected $dbConf;
	
	private function __construct ()
	{
		$this->setDbConf();
		self::$db = DB::getInstance($this->dbConf);
	}
	
	public static function getInstance ()
	{
		if (!self::$instance instanceof self)
		{
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	public function setDbConf ()
	{
		$this->dbConf = _getDBConf()['DB_CONF'];
	}
}