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
			$this->getView()->render($this->controller,  __FUNCTION__);
		}
		
		public function details($id)
		{
			$this->getView()->render($this->controller,  __FUNCTION__);
		}

		public function facilities()
		{
			$this->getView()->render($this->controller,  __FUNCTION__);
		}

		public function clients()
		{
			$this->getView()->render($this->controller,  __FUNCTION__);
		}

		public function facility()
		{
			$this->getView()->render($this->controller,  __FUNCTION__);
		}
		
	}