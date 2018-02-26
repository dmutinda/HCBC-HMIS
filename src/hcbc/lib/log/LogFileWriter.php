<?php
	
namespace lib\log;

	class LogFileWriter 
	{
	
		function writeLogDB($exceptionString) 
		{
			$this->exception_string = $exceptionString;
			$somecontent = $this->exception_string;
			$filename = dirname(__FILE__).'/logDB.txt';
			
		    if (!$handle = fopen($filename, 'a+')) {
		    }
		
		    if (fwrite($handle, $this->exception_string) === FALSE) {
		    }
		 
	    	fclose($handle);
	                    
		}
	
	}
