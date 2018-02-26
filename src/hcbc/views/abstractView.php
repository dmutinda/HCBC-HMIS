<?php 
	
	namespace views;
	use core;

	class abstractView 
	{ 
		protected $variables = array(); 
		protected $app;
		protected $auth;
		protected $identity = array();
		
		function __construct()
		{
			$this->app = new \core\app();
			$this->auth= new \core\identity();
			$this->identity = $this->auth->getIdentity();
		}
		
		public function set($name,$value) 
		{ 
			$this->variables[$name] = $value; 
		} 
		
		public function render($controller, $action, $partial = IS_AJAX) 
		{ 
			extract($this->variables); 
			
			$header = ROOT . DS . 'views' .DS . 'layout'. DS .'header';
			$footer = ROOT . DS . 'views' .DS . 'layout'. DS .'footer';
			$view = ROOT . DS . 'views' .DS . $controller. DS .$action;

			if (!$partial) require_once($header.'.php');
			if(file_exists($view.'.phtml'))
			{
				include ($view.'.phtml');
			}
			elseif(file_exists($view.'.php'))
			{
				include ($view.'.php');
			}
			else
			{
				/* throw exception */
			}
			if (!$partial) require_once($footer.'.php');
		}
		
	}