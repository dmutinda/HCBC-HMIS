<?php

	namespace lib\dao\mssql;

	class SQLClass
	{
		private $host;
		private $port;
		private $dbUser;
		private $dbPassword;
		private $dbName; 
		private $connection; 
		private $result;
		private $connInfo;
		
		/**
		 * create db connection
		 * @param array $conf
		 */
		public function __construct($conf) 
		{
			$this->host =$conf['host'];
			$this->port = "";
			$this->dbUser = $conf['username'];
			$this->dbPassword = $conf['password'];
			$this->dbName = $conf['database'];
			$this->connInfo=array("Database"=>$conf['database'],"uid"=>$this->dbUser,"PWD"=>$this->dbPassword);
			$this->dbConnect();
		}
	
		/**
		 * database connection Mssql
		 */
		public function dbConnect() 
		{
			$this->connection = connectionManager::setConnection($this->host, $this->connInfo);
		}
	
		/**
		 * close the connection
		 * @param ResultResource $result
		 */
		public function dbDisconnect($result = null) 
		{
			if ($this->connection != null) {
				if ($result) {
					@ sqlsrv_free_statement($result);
				}
				if ($this->connection) {
					return @ sqlsrv_close($this->connection);
				}
			}
		}
	
		/**
		 * execute an SQL statement
		 * @param String $sql
		 * @return ResultResource
		 */
		public function sqlQuery($sql) 
		{
			if ((isset ($this->connection)) && ($sql != '')) {
				$this->result = sqlsrv_query($this->connection, $sql);
				if ($this->result) 
				{
					return $this->result;
				}
				if ($this->result === false) 
				{
					return false;
				}
				return false;
			} else 
			{
				return false;
			}
		}
		
		/**
		 * This method will return a row from a result resource
		 * @param ResultResouce $result
		 * @return Array[] Row of field values
		 */
		public function getArray($result) 
		{
			return sqlsrv_fetch_array($result);
		}
		
		/**
		 * return the number of rows that have been affected
		 * @param ResultResouce $result
		 * @return int
		 */
		public function affectedRows($result) 
		{
			return (int) sqlsrv_rows_affected($result);
		}
		
		/**
		 * return the number of rows
		 * @param ResultResouce $result
		 * @return int
		 */
		public function numberOfRows($result) 
		{
			return (int) sqlsrv_num_rows($result);
		}
	}
