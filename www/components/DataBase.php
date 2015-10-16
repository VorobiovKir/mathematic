<?php 

	class 	DataBase
	{
		public static function 	connectDB() 
		{
			$param = require_once ROOT.'/config/database.php';
			
			try {
				
				if (@mysql_connect($param['host'], $param['user'], $param['pswd']) === false) { 
					
					throw new Exception("Ошибка подключения к СУБД (".
						mysql_errno()." : ".mysql_error());
				}
				
				if (mysql_select_db($param['db_name']) === false) { 
					throw new Exception("Ошибка подключения к БД (".
						mysql_errno().") : ".mysql_error());
				}
				
				if (mysql_query("SET Names UTF8") === false) {
					throw new Exception("Ошибка с кодировкой (".
						mysql_errno().") : ".mysql_error());
				}

			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}

		public static function 	closeDB() 
		{
			mysql_close();
		}

	}

 ?>