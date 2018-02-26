<?php

namespace core;

	class identity
	{
		protected $session;
		protected $sessionName;

		public function __construct()
		{
			$this->session = new \core\session('identity');
			$this->sessionName = $this->session->getSessionName();
		}
		
		/**
		 * set identity data
		 * @param array $sessionData
		 */
		public function setIdentity($sessionData)
		{
			$session = new self();
			$session->createSession($sessionData);
		}
	
		/**
		 * get the current session identity
		 * @return array
		 */
		public function getIdentity()
		{
			return $this->session->getSession();
		}
		
		/**
		 * check if there is as valid identity session
		 * @return boolean
		 */
		public function isValid()
		{
			return $this->session->hasSession();
		}
		
		/**
		 * destroy the current identity session
		 */
		public function destroyIdentity()
		{
			return $this->session->destroy();
		}
		
		/**
		 * create new identity session
		 * @param array $sessionData
		 * @return number
		 */
		private function createSession($sessionData)
		{
			$items = array();
			$hasSession = $this->session->hasSession();
			if(empty($hasSession))
			{

				/*
					Id
					FacilityId
					NationalId
					FirstName
					LastName
					UserName
					Password
					Disabled
					Created
				*/

				$items = array (
					'UserID' => $sessionData['UserID'],
					'Username' => ucwords(strtolower($sessionData['Username'])),
					'Firstname' =>$sessionData['Firstname'],
					'Othernames' =>$sessionData['Othernames'],
					'Active' =>$sessionData['Active'],
					'userHandle' => ucwords($sessionData['Firstname'] . '.' . $sessionData['Othernames']), 
					'Department' =>$sessionData['Department'],
					'SystemAdmin' =>$sessionData['SystemAdmin'],
					'Email' =>$sessionData['Email'],
					'auth' => array(),
					'objects' => array()
				);
				$this->session->save($items);
				return $sessionData['UserID']; 
	 		}
			return 0;
		}
		
	}