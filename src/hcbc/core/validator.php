<?php
	namespace core;
	
	class validator extends app
	{
		private static $errors = array();
		
		/**
		 * add a new entry in the erro list
		 * @param string $value
		 */
		private static function setError($value)
		{
			self::$errors = array_merge(self::$errors, $value);
		}
		
		/**
		 * recursive validate all required attributes of an object based on the validation rule
		 * @param unknown $data
		 * @param unknown $validationRule
		 * @return array
		 */
		public static function validate($data, $validationRule)
		{
			foreach ($data as $key => $value)
			{
				foreach ($validationRule as $handle => $rule)
				{
					if($handle == $key)
					{
						$res = self::validateInput($value, $rule['type'], $rule['required']);
						if(empty($res))
						{
							self::setError(array($key => $rule['message']));
							break 2;
						}
					}
				}
			}
			return self::$errors;
		}
		
		/**
		 * validate inputs
		 * @param unknown $value
		 * @param unknown $type - options email, int, date, numeric
		 * @param unknown $required
		 */
		public static function validateInput($value, $type, $required)
		{
			$res = true;
			if (!empty($required))
			{	
				$res = !self::isEmpty($value);
			}
			if(!empty($value)) 
			{
				switch ($type) 
				{
					case 'email':
						$res = self::isEmail($value);
					break;
					case 'int':
						$res = self::isInt($value);
					break;
					case 'date':
						$res = self::isDate($value);
					break;
					case 'numeric':
						$res = self::isNumeric($value);
					break;
					default:
						
					break;
				}
			}
			return $res;
		}
		
		/**
		 * valid email
		 * @param   string
		 * @return  boolean
		 */
		public static function isEmail($val)
	  	{
	  		return (bool)(preg_match("/^([a-z0-9+_-]+)(.[a-z0-9+_-]+)*@([a-z0-9-]+.)+[a-z]{2,6}$/ix", $val));
	  	} 
	  	
	  	/**
	  	 * check if field empty string ,orject,array
	  	 * @param   string
	  	 * @return  boolean
	  	 */
	  	public static function isEmpty($val)
	  	{
	  		return empty($val);
	  	}
	  	
	  	/**
	  	 * validate string length
	  	 * @param   string
	  	 * @return  boolean
	  	 */
	  	public static function isLength($val, $length)
	  	{
	  		return (strlen($val) == (int)$length);
	  	}
	  	
	  	/**
	  	 * validate string length exceeds maximum length
	  	 * @param   string
	  	 * @return  boolean
	  	 */
	  	public static function isMaxlength($val, $max)
	  	{
	  		return (strlen($val) <= (int)$max);
	  	}
	  	
	  	/**
	  	 *validate the string length has minimum length
	  	 * @param   string
	  	 * @return  boolean
	  	 */
	  	public static function isMinlength($val, $min)
	  	{
	  		return (strlen($val) >= (int)$min);
	  	}
	  	
	  	/**
	  	 * validate given string length is between given range
	  	 * @param   string
	  	 * @return  boolean
	  	 */
	  	public static function isRangelength($val, $min = '', $max = '')
	  	{
	  		return (strlen($val) >= $min and strlen($val) <= $max);
	  	}
	  	
	  	/**
	  	 * valid integer
	  	 * @param   string
	  	 * @return  boolean
	  	 */
	  	public static function isInt($val)
	  	{
	  		return is_int((int) $val);
	  	}
	  	
	  	/**
	  	 * validate number between given values
	  	 * @param   string
	  	 * @return  boolean
	  	 */
	  	public static function isRangevalue($number,$min,$max)
	  	{
	  		return ($number > $min and $number < $max);
	  	}
	  	
	  	/**
	  	 * check numeric with
	  	 * @param   string
	  	 * @return  boolean
	  	 */
	  	public static function isNumeric($val)
	  	{
	  		return is_numeric($val);
	  	}
	  	
	  	/**
	  	 * Check if given string matches any format date
	  	 * @param   string
	  	 * @return  boolean
	  	 */
	  	public static function isDate($val)
	  	{
	  		//TODO: require a function to check date validity
	  		return (strtotime($val) !== false);
	  	}
	  	
	  	/**
	  	 * valid IP address
	  	 * @param   string
	  	 * @return  boolean
	  	 */
	  	public static function isIpaddress($val)
	  	{
	  		return (bool)preg_match("/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?).(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?).(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?).(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/",$val);
	  	}
	  	
	  	public static function displayErrors($value)
	  	{
	  		$err = null;
	  		if(!empty($value))
	  		{
		  		if(is_array($value))
		  		{
		  			$err =  "<ol class='err-list'>";
		  			foreach ($value as $key => $value)
		  			{
		  				$err .= "<li>".$value."</li>";
		  			}
		  			$err .= "</ol>";
		  		}
		  		else
		  		{
		  			$err =  $value;
		  		}
	  		}
	  		return $err;
	  	}
	}