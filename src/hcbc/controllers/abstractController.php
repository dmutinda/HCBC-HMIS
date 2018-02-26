<?php 

	namespace controllers;

	use core\settings;
	use views;
	use core;
	
	class abstractController extends settings 
	{ 
		protected $controller; 
		public 	  $call;
		protected $action; 
		protected $models; 
		protected $view;
		protected $app;
		protected $auth;
		protected $identity = array();
		
		public function __construct($controller, $action) 
		{ 
			parent::__construct();
			$this->controller = $controller;
			$this->setCall(__NAMESPACE__ .'\\'. $this->controller);
			$this->action = $action; 
			$this->view = new views\abstractView();
			$this->app = new \core\app();
			$this->auth= new \core\identity();
			$this->identity = $this->auth->getIdentity();
		} 
		
		// Load model class 
		protected function loadModel($model) 
		{ 
			if(class_exists($model)) $this->models[$model] = new $model(); 
		} 
		
		// Get the instance of the loaded model class 
		protected function getModel($model) 
		{ 
			$this->loadModel($model);
			if(is_object($this->models[$model])) return $this->models[$model]; 

			return false; 
		} 
		
		public function setCall($value)
		{
			$this->call = $value;
		}
		
		public function getCall()
		{
			return $this->call;
		}

		protected function getView() 
		{ 
			return $this->view; 
		} 

	}
