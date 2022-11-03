<?php
class DB
{
	public static $dsn = 'mysql:dbname=table;host=localhost';
	public static $user = 'user';
	public static $pass = 'password';
 

	public static $dbh = null;

	public static $sth = null;

	public static $query = '';
 
	public static function getDbh()
	{	
		if (!self::$dbh) {
			try {
				self::$dbh = new PDO(
					self::$dsn, 
					self::$user, 
					self::$pass, 
					array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")
				);
				self::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
			} catch (PDOException $e) {
				exit('Error connecting to database: ' . $e->getMessage());
			}
		}
 
		return self::$dbh; 
	}

	public static function destroy()
	{	
		self::$dbh = null;
		return self::$dbh; 
	}
 
	public static function getError()
	{
		$info = self::$sth->errorInfo();
		return (isset($info[2])) ? 'SQL: ' . $info[2] : null;
	}
 
	public static function getStructure($table)
	{
		$res = array();
		foreach (self::getAll("SHOW COLUMNS FROM {$table}") as $row) {
			$res[$row['Field']] = (is_null($row['Default'])) ? '' : $row['Default'];
		}
 
		return $res;
	}
 
	public static function add($query, $param = array())
	{
		self::$sth = self::getDbh()->prepare($query);
		return (self::$sth->execute((array) $param)) ? self::getDbh()->lastInsertId() : 0;
	}
	
	public static function set($query, $param = array())
	{
		self::$sth = self::getDbh()->prepare($query);
		return self::$sth->execute((array) $param);
	}

	public static function getRow($query, $param = array())
	{
		self::$sth = self::getDbh()->prepare($query);
		self::$sth->execute((array) $param);
		return self::$sth->fetch(PDO::FETCH_ASSOC);		
	}

	public static function getAll($query, $param = array())
	{
		self::$sth = self::getDbh()->prepare($query);
		self::$sth->execute((array) $param);
		return self::$sth->fetchAll(PDO::FETCH_ASSOC);	
	}

	public static function getValue($query, $param = array(), $default = null)
	{
		$result = self::getRow($query, $param);
		if (!empty($result)) {
			$result = array_shift($result);
		}
 
		return (empty($result)) ? $default : $result;	
	}
	
	public static function getColumn($query, $param = array())
	{
		self::$sth = self::getDbh()->prepare($query);
		self::$sth->execute((array) $param);
		return self::$sth->fetchAll(PDO::FETCH_COLUMN);	
	}
}