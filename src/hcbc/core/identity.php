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
				$items = array (
					'UserID' => $sessionData['Id'],
					'Username' => ucwords(strtolower($sessionData['UserName'])),
					'Firstname' =>$sessionData['FirstName'],
					'Othernames' =>$sessionData['LastName'],
					'Active' =>$sessionData['Disabled'],
					'userHandle' => ucwords($sessionData['FirstName'] . '.' . $sessionData['LastName']), 
					'FacilityId' =>$sessionData['FacilityId'],
					'Department' =>$sessionData['JobTitleId'],
					'SystemAdmin' =>$sessionData['Root'],
					'Email' =>$sessionData['Email'],
					'auth' => array(),
					'objects' => array()
				);
				$this->session->save($items);
				return $sessionData['Id']; 
	 		}
			return 0;
		}
		
	}