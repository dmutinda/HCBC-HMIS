<?php

namespace core;

	class session
	{
		protected $sessionName;
		protected $items = array();
		protected $errors = array();

		public function __construct($sessionName)
		{
			$this->setSessionName($sessionName);
			$this->items = isset($_SESSION[$this->sessionName]) ? $_SESSION[$this->sessionName] : array();
		}
		
		/**
		 * set the session name
		 * @param string $value
		 */
		private function setSessionName($value)
		{
			$this->sessionName = $value;
		}
		
		/**
		 * get the session name
		 */
		public function getSessionName()
		{
			return $this->sessionName;
		}
		
		/**
		 * set session errors
		 * @param string $value
		 */
		public function setErrors($value)
		{
			$this->errors [] = $value;
		}
		
		/**
		 * get errors
		 */
		public function getErrors()
		{
			return !empty($this->errors) ? $this->errors : array();
		}
		
		/**
		 * saves the identity session data to a session variable
		 */
		public function save($sessionData)
		{
			$_SESSION[$this->sessionName] = $sessionData;
		}
		
		/**
		 * get identity session items
		 */
		public function getSession()
		{
			return $this->items;
		}
		
		/**
		 * checks to see if there are items in the session
		 * @return boolean
		 */
		public function hasSession()
		{
			return (bool) $this->items;
		}
		
		/**
		 * clear the current entire session
		 */
		public function destroy ()
		{
			$this->items = null;
			if(!empty($_SESSION[$this->sessionName]))
			{
				unset($_SESSION[$this->sessionName]);
			}
		}
		
	}
