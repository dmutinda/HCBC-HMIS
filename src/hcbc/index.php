<?php 
session_start();
// directory separator
define('DS', DIRECTORY_SEPARATOR); 
// root directory
define('ROOT', dirname(__FILE__)); 

//attempt to detect if the request is an Ajax request
$isAjax = (isset($_SERVER['HTTP_X_REQUESTED_WITH'])
		&& !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
		&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == "xmlhttprequest") ? true : false;
define('IS_AJAX', $isAjax);

// Display all errors when APPLICATION_ENV is development.
if ($_SERVER['APPLICATION_ENV'] == 'development') 
{
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
}

//get url location
$url = !empty($_GET['url']) ? $_GET['url'] : 'main';

require_once(ROOT . DS . 'core' . DS . 'bootstrap.php');