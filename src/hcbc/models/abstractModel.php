<?php 
	
	namespace models;	

	use core;
	require_once ROOT .DS .'lib' . DS . 'dao' .DS. 'mysql' . DS . 'SQLClass.php';
	
	class abstractModel 
	{ 
		protected $db;
		protected $coreDb;
		protected $config;
		protected $app;
		protected $auth= array();
		protected $identity = array();

		public function __construct() 
		{
			$this->config = new \lib\dao\mysql\SQLClass(core\autoloader::getConfig()['db']);
			$this->setDbAdaptor($this->config);
			$this->app = new \core\app();
			$this->auth= new \core\identity();
			$this->identity = $this->auth->getIdentity();
		}
		
		/**
		 * set application database configurations
		 * @param array $value
		 */
		public function setDbAdaptor($value)
		{
			$this->db = $value;
		}
		
		/**
		 * get application database configurations
		 * @return array
		 */
		public function getDbAdaptor()
		{
			return $this->db;
		}
		
	} 