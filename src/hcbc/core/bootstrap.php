<?php 

	namespace core;

	/*
	 * Autoload classes, Load configuration and helper functions
	 */  
	class autoloader 
	{
		/**
		 * get the application configs
		 * @return array
		 */
		static public function getConfig()
		{
			return array_merge_recursive(
				include ROOT . DS . 'config' . DS . 'config.php', 
				include ROOT . DS . 'config' . DS . 'settings.php',
				include ROOT . DS . 'config' . DS . 'anonymous.php',
				include ROOT . DS . 'config' . DS . 'local.php'
			);
		}
		
		/**
		 * Autoload class
		 * @param unknown $className
		 */
	    static public function autoload($className)
	    {
	    	$className = ltrim($className, '\\');
	    	$fileName  = '';
	    	$namespace = '';
	    	if ($lastNsPos = strrpos($className, '\\')) {
	    		$namespace = substr($className, 0, $lastNsPos);
	    		$className = substr($className, $lastNsPos + 1);
	    		$fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
	    	}
	    	$fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
	    	if (file_exists(ROOT . DS . $fileName))
	    	{
	    		require ROOT . DS . $fileName;
	    	}
	    }  
	}
	
	spl_autoload_register('core\autoloader::autoload');
	
 	//Route the request 
 	router::route($url); 