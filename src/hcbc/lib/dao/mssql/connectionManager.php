<?php

	namespace lib\dao\mssql;
	
	class connectionManager
	{
		private static $adaptor;
		
		public static function setConnection($host, $connInfo)
		{
			if(!@ self::$adaptor = sqlsrv_connect($host, $connInfo))
			{
				if($_SERVER['APPLICATION_ENV'] == 'development')
				{
					die(print_r(sqlsrv_errors(), true));
				}
				else 
				{
					die('<h4>Database Connection Error. The Server is not found or not accessible.</h4');
				}
			}
			else
			{
				return self::$adaptor;
			}
		}
		
	}