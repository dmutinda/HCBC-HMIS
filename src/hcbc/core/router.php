<?php 

	namespace core;

	use controllers;
	
	class router 
	{
		public static function route($url) 
		{ 
			$identity= new \core\identity();
			$uId = $identity->getIdentity();
			$uName = !empty($uId['UserName']) ? $uId['UserName'] : null;
			$anonymous= autoloader::getConfig()['anonymous'];
			// Split the URL
			$url_array = array(); $url_array = explode("/",$url); 
			//get controller name 
			$controller = isset($url_array[0]) ? $url_array[0] : ''; 
			array_shift($url_array); 
			//get action/method name 
			$action = isset($url_array[0]) ? $url_array[0] : ''; 
			array_shift($url_array); 
			//get query string parameters 
			$queryString = $url_array;
			if(empty($controller)) 
			{ 
				$controller = 'main'; 
			}  
			if(empty($action)) 
			{ 
				$action = 'index'; 
			}
			//allow anonymous access for selected controller-action else validate
			$rescource = $controller.'-'.$action;
			if(!in_array($rescource, $anonymous))
			{
				/*
				if(empty($uId))
				{
					$controller = 'account';
					$action = 'login';
				}
				else
				{
					//authorize
				}
				*/
			}
			//route request
			$controller_name = $controller; 
			$controller = strtolower($controller); 
			$dispatch = new controllers\abstractController($controller_name,$action); 
			$callable = new $dispatch->call($controller_name,$action);
			if ((int)method_exists($callable, $action)) 
			{ 
				call_user_func_array(array($callable,$action),$queryString);
			}
			else 
			{ 
				/* throw exception */ 
			} 
		}
		
	}
