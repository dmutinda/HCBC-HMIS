<?php

	namespace core;
	
	class app
	{
		private static $timeZone;
		private static $appConfigs;
		
		function __construct()
		{
			self::$appConfigs = autoloader::getConfig();
		}

		/**
		 * get the application defination array 
		 * without the optional $key param the entire
		 * application array will be returned
		 * @param string $key
		 * @return array|string
		 */
		public static function getAppDetails($key = null)
		{
			$app = array();
			if(empty($key))
			{
				$app = self::$appConfigs['application'];
			}
			else 
			{
				$app = self::$appConfigs['application'][$key];
			}
			
			return $app;
		}
		
		/**
		 * get the current application version
		 * @param string $verbose
		 * @return string
		 */
		public static function getVersion($verbose = false)
		{
			return empty($verbose) 
				? version::VERSION 
				: 'Version: Release (' . version::VERSION .')';
		}
		
		/**
		 * get the name of the project
		 * @return string
		 */
		public static function getProjectName()
		{
			return version::PROJECT_NAME;
		}
		
		/**
		 * get the title of the app
		 * @return string
		 */
		public static function getAppTitle()
		{
			$title = self::getAppDetails('appTitle');
			return !empty($title) ? $title: 'App';
		}
		
		/**
		 * get the title of the app
		 * @return string
		 */
		public static function getAppLogo()
		{
			$path = self::getAppDetails('logoPath');
			return is_file($path) ? '/'.$path : null;
		}
		
		/**
		 * get the name of the company running the Application
		 * @return string
		 */
		public static function getAppCompany()
		{
			$title = self::getAppDetails('company');
			return !empty($title) ? $title: 'App';
		}
		
		/**
		 * helper method to validate authorization
		 * @param unknown $username
		 * @param unknown $requiredPermission
		 * @return boolean
		 */
		public static function authorize($username, $requiredPermission)
		{
			$authRequest = new \rbac\authorization($username);
			return $authRequest->authorize($requiredPermission);
		}
		
		/**
		 * get app menu
		 * @return string,
		 */
		public static function getAppMenu()
		{
			$menu = new \models\menu();
			return $menu->menuLoad();
		}
		
		/**
		 * get mail configs
		 * @return array
		 */
		public static function getMailConfigs()
		{
			$mailConf = array();
			$db = new \models\system();
			$conf = $db->getDbMailConfig();
			$mailConf['host'] = $conf['SMTPServer'];
			$mailConf['port'] = $conf['SMTPPort'];
			$mailConf['username'] = $conf['SenderEmail'];
			$mailConf['password'] = $conf['Password'];
			$mailConf['useSsl'] = $conf['UseSSL'];
			return $mailConf;
		}

		/**
		 * get an boolean yes/no options
		 * @return array
		 */
		public static function getBooleanStatus()
		{
			return self::$appConfigs['set'];
		}
		
	 	/**
	 	 * format date
	 	 * @param datetime $Date
	 	 * @param string $format
	 	 * @return string
	 	 */
		public static function formatDate($date, $format = 'Y-m-d H:i')
		{
			return date($format, strtotime($date));
		}
		
		/**
		 * set default time zone
		 * @param string $value
		 */
		public static function setDefaultTimeZone($value = 'Africa/Nairobi')
		{
			self::$timeZone = date_default_timezone_set($value);
		}
		
		/**
		 * get default time zone
		 * @return string
		 */
		public static function getDefaultTimeZone()
		{
			return self::$timeZone = date_default_timezone_get();
		}
		
		/**
		 * First day of the month.
		 * @param string $date
		 * @return string
		 */
		public static function getFirstMonthDay($date = "")
		{
			$date= !empty($date) ? self::formatDate($date, 'd-M-Y') : date('d-M-Y');
			return date('01-M-Y', strtotime($date));
		}
		
		/**
		 * Last day of the month.
		 * @param string $date
		 * @return string
		 */
		public static function getLastMonthDay($date = "")
		{
			$date= !empty($date) ? self::formatDate($date, 'd-M-Y') : date('d-M-Y');
			return date('t-M-Y', strtotime($date));
		}
		
		/**
		 * generate UUID
		 */
		function generateUuid($replaceHyp = false)
		{
			if (function_exists('com_create_guid'))
			{
				return com_create_guid();
			}
			else
			{
				mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
				$charid = strtoupper(md5(uniqid(rand(), true)));
				$hyphen = chr(45);// "-"
				$uuid = chr(123)// "{"
				.substr($charid, 0, 8).$hyphen
				.substr($charid, 8, 4).$hyphen
				.substr($charid,12, 4).$hyphen
				.substr($charid,16, 4).$hyphen
				.substr($charid,20,12)
				.chr(125);// "}"
				return $uuid;
			}
			return false;
		}
		
		/**
		 * left pad integer values with zeros
		 * @param unknown $len
		 * @param unknown $value
		 * @return string
		 */
		public static function padInt($len, $value)
		{
			return sprintf('%0'.$len.'d', $value);
		}
		
		/**
		 * right pad string values with spaces
		 * @param unknown $len
		 * @param unknown $value
		 * @param string $padChar
		 * @param string $pos
		 * @return string
		 */
		public static function padStr($len, $value, $padChar = ' ',$pos = STR_PAD_LEFT)
		{
			return str_pad($value, $len, $padChar, $pos);
		}
		
		/**
		 * check input = valid
		 * @param unknown $data
		 * @return string
		 */
		public static function prepInput($data) 
		{
			$data = trim($data);
			if (get_magic_quotes_gpc()) $data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}	
		
		/**
		 * get raw numeric value from a formatted number
		 * @param unknown $value
		 * @return mixed
		 */
		public static function escapeNumeric($value)
		{
			return str_replace(",","",$value);
		}
		
		/**
		 * return the base url of server
		 * @return string
		 */
		public static function getBaseUrl()
		{
			if (!empty($_SERVER['HTTPS']) || @$_SERVER['HTTPS'] == 'on')
			{
				$protocol = 'https';
			}
			else
			{
				$protocol = 'http';
			}
			return $protocol.'://'.$_SERVER['HTTP_HOST'];
		}
		
		/**
		 * return the hostname of the server
		 * @return string
		 */
		public static function getHost()
		{
			return $_SERVER['HTTP_HOST'];
		}
		
		/**
		 * mask value passed
		 * @param string $value
		 * @param number $start
		 * @param number $maskLen
		 * @param string $mask
		 * @return mixed|boolean
		 */
		public static function setMask($value, $start = 1, $maskLen = 8, $mask = '*')
		{
			if($value)
			{
				$strLen = strlen($value);
				return substr_replace($value, str_repeat($mask, $maskLen), $start, $maskLen);
			}
			return false;
		}
		
		/**
		 * get the first letter of each word on a string
		 * @param string $strSrc
		 * @return string
		 */
		public static function getStrInitials($strSrc = null)
		{
			$acronym = '';
			if($strSrc)
			{
				$strArray = explode(" ", $strSrc);
				foreach ($strArray as $key => $init)
				{
					$acronym .= strtoupper($init {0});
				}
			}
			return $acronym;
		}
		
		/**
		 * get a subset of a string
		 * @param string $strSrc
		 * @param number $start
		 * @param number $length
		 * @return <string, NULL>
		 */
		public static function getSubString($strSrc, $start = 0, $length = 1)
		{
			$strSrc = trim($strSrc);
			$subStr = null;
			if($strSrc)
			{
				$subStr = substr($strSrc, $start, $length);
			}
			return $subStr;
		}
		
		/**
		 * return ordinal from number
		 * @param integer $number
		 * @return string
		 */
		public static function getOrdinal($number)
		{
			$ends = array('th','st','nd','rd','th','th','th','th','th','th');
			if ((($number % 100) >= 11) && (($number%100) <= 13))
				return $number. 'th';
			else
				return $number. $ends[$number % 10];
		}
		
		/**
		 * create a directory in a specified location
		 * @param string $path
		 * @param number $mode
		 * @return string|boolean
		 */
		public static function createDir($path, $mode = 0755)
		{
			if($path)
			{
				$dir = $path . '/';
				if(is_dir($dir))
				{
					return $dir;
				}
				else
				{
					if(mkdir($dir, $mode))
					{
						return $dir;
					}
				}
			}
			return false;
		}
		
		/**
		 * remove a directory and its contents
		 * @param string $path
		 * @param string $dirName
		 * @return boolean
		 */
		public static function removeDir($path, $dirName)
		{
			if($dirName)
			{
				foreach(glob($path .'/'.$dirName . '/*') as $file)
				{
					if(is_dir($file))
						removeDir($file);
					else
						unlink($file);
				}
				return rmdir($path .'/'.$dirName);
			}
			return false;
		}
		
		/**
		 * delete a file
		 * @param string $file
		 * @return boolean
		 */
		public static function deleteFile($file)
		{
			if($file)
			{
				if(is_file($file))
				{
					return unlink($file);
				}
			}
			return false;
		}
		
		/**
		 * shorten a string to a specified lenth
		 * @param string $strSrc
		 * @param number $limit
		 * @param string $leadText
		 * @param string $chr
		 * @param number $cnt
		 * @return string
		 */
		public function trimString($strSrc, $limit=140, $leadText = "...", $chr="\n", $cnt=2)
		{
			$pos = 0;
			$trimmed = FALSE;
			$output = array();
			for ($i = 1; $i <= $cnt; $i++)
			{
				if ($tmp = strpos($strSrc,$chr,$pos))
				{
					$pos = $tmp;
					$trimmed = TRUE;
				}
				else
				{
					$pos = strlen($strSrc) - 1;
					$trimmed = FALSE;
					break;
				}
			}
			$strSrc = substr($strSrc,0,$pos);
			if (strlen($strSrc) > $limit)
			{
				$strSrc = substr($strSrc,0,$limit);
				$strSrc = substr($strSrc,0,strrpos($strSrc,' '));
				$trimmed = TRUE;
			}
			$output['str'] = ($trimmed) ? $strSrc .= ' ' . $leadText : $strSrc;
			$output['trimmed'] = $trimmed;
			return $output;
		}
		
		/**
		 * redirect
		 * @param string $url
		 * @param string $permanent
		 */
		public static function redirectTo($url, $permanent = false) 
		{
			if($permanent) 
			{
				header('HTTP/1.1 301 Moved Permanently');
			}
			header('Location: '.$url);
			exit();
		}
		
		/**
		 * generate a random string
		 */
		public static function generateRandStr()
		{
			return sha1(uniqid());
		}
		
		/**
		 * generate a random password string
		 */
		public static function generateRandPasswd()
		{
			return uniqid();
		}
		
		/**
		 * Set a cookie
		 * @param string $name
		 * @param string $value
		 * @param number $expire
		 * @param string $path
		 * @return boolean
		 */
		public static function setCookie($name, $value, $cipher = false, $expire = 0)
		{
			$value = !empty($cipher) ? self::cipher($value, 'e') : $value;
			$expire = !empty($expire) ? $expire : time()+60*60*24*14;
			return setcookie($name, $value, $expire, "/" , $_SERVER['HTTP_HOST'], null, true);
		}
		
		/**
		 * get a cookie by name
		 * @param string $value
		 * @return string
		 */
		public static function getCookie($name, $cipher = false)
		{
			$value = isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;
			if(!empty($cipher))
			{
				$value = self::cipher($value, 'd');
			}
			return $value;
		}
		
		/**
		 * delete a cookie
		 * @param string $name
		 * @return boolean
		 */
		public static function deleteCookie($name)
		{
			return setcookie($name, null, -3600);
		}

		/**
		 * hash a string
		 * @param unknown $password
		 * @return string
		 */
		public static function hashString($password)
		{
			if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) 
			{
				$salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
				return crypt($password, $salt);
			}
		}
		
		/**
		 * verify a hashed string
		 * @param unknown $password
		 * @param unknown $hash
		 * @return boolean
		 */
		public static function verifyHashString($password, $hash)
		{
			return crypt($password, $hash) == $hash;
		}
		
		/**
		 * encrypt/decrypt string
		 * @param unknown $string
		 * @param string $action
		 * @return string
		 */
		public static function cipher($string, $action = 'e') 
		{
			$secretKey = 'hcbcmissecretkey';
			$secretIv = '3d0f3b9ddcacec30c4008c5e030e6c13a478cb4f1';
			$output = null;
			$encrypt_method = "AES-256-CBC";
			$key = hash( 'sha256', $secretKey);
			$iv = substr( hash('sha256', $secretIv), 0, 16);
			if($action == 'e') 
			{
				$output = base64_encode(openssl_encrypt( $string, $encrypt_method, $key, 0, $iv));
			}
			else if($action == 'd')
			{
				$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
			}
			return $output;
		}
		
	}