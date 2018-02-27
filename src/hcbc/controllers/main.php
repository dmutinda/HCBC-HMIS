<?php 
namespace controllers;

class main extends abstractController 
{ 
	protected $errors = array();
	
	public function __construct($controller,$action) 
	{ 
		parent::__construct($controller, $action); 
	} 
	
	public function index() 
	{ 
		$this->getView()->render($this->controller,  __FUNCTION__);
	}
	
	public function about()
	{
		$this->getView()->render($this->controller,  __FUNCTION__);
	}
	
	public function contact()
	{
		$this->getView()->render($this->controller,  __FUNCTION__);
	}

	public function benefits()
	{
		$this->getView()->render($this->controller,  __FUNCTION__);
	}

	public function start()
	{
		$this->getView()->render($this->controller,  __FUNCTION__);
	}

	
	
} 

