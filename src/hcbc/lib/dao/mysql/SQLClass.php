<?php

	namespace lib\dao\mysql;

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
			$this->connInfo = $conf;
			$this->dbConnect();
		}
	
		/**
		 * database connection Mssql
		 */
		public function dbConnect() 
		{
			$this->connection = connectionManager::setConnection($this->connInfo);
		}
	
		/**
		 * close the connection
		 * @param ResultResource $result
		 */
		public function dbDisconnect() 
		{
			if ($this->connection != null) 
			{
				if ($result) 
				{
					@$result->free();
				}
				if ($this->connection) 
				{
					return @$result->close();
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
			if ((isset ($this->connection)) && (!empty($sql))) 
			{
				$this->nextResult();
				$this->result = $this->connection->query($sql);
				if ($this->result) 
				{
					return $this->result;
				}
			} 
			return false;
		}
		
		public function nextResult()
		{
			while($this->connection->more_results())
			{
				$this->connection->next_result();
				$this->connection->use_result();
			}
		}

		/**
		 * This method will return a row from a result resource
		 * @param ResultResouce $result
		 * @return Array[] Row of field values
		 */
		public function getArray($result) 
		{
			if(!empty($result))
			{
				return $result->fetch_array();
			}
			return array();
			
		}

		/**
		 * return the number of rows that have been affected
		 * SQL statement
		 * @return int
		*/
		public function affectedRows() 
		{
			return $this->connection->affected_rows;
		}
		
		/**
		 * return the number of rows
		 * @param ResultResouce $result
		 * @return int
		 */
		public function numberOfRows($result) 
		{
			return $result->num_rows;
		}
	}
