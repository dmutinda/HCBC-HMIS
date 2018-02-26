<?php

	namespace controllers;
	
	class company extends abstractController
	{
		protected $company;
		protected $errors = array();
		
		public function __construct($controller,$action)
		{
			parent::__construct($controller, $action);
			$this->company = new \models\company();
		}
		
		public function index()
		{
			return json_encode(__FUNCTION__);
		}
		
		public function details($id)
		{
			return json_encode(__FUNCTION__);
		}

		public function facilities()
		{
			return json_encode(__FUNCTION__);
		}

		public function facility()
		{
			return json_encode(__FUNCTION__);
		}
		
	}