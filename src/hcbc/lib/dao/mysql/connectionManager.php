<?php

	namespace lib\dao\mysql;
	
	class connectionManager
	{
		private static $adaptor;
		
		public static function setConnection($conf)
		{
			self::$adaptor = empty($conf['port']) 
				? new \mysqli($conf['host'], $conf['username'], $conf['password'], $conf['database']) 
				: new \mysqli($conf['host'], $conf['username'], $conf['password'], $conf['database'], $conf['port']);
			
			if (self::$adaptor->connect_error) 
			{
				if($_SERVER['APPLICATION_ENV'] == 'development')
				{
					die('Connect Error (' . $adaptor->connect_errno . ') ' . $adaptor->connect_error);
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