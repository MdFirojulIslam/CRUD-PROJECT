<?php
	include 'config.php';

	class DB{
		public static $pdo = null;
		public static function connection()
		{
			if(self::$pdo === null)
			{
				try
				{
					self::$pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PASS);
				}
				catch(PDOException $e)
				{
					echo "Connection failed: ".$e->getMessage();
				}
			}
			return self::$pdo;
		}
		public static function prepare($sql)
		{
			return self::connection()->prepare($sql);
		}
		public static function lastInsertId()
		{
			return self::connection()->lastInsertId();
		}
	}
?>
