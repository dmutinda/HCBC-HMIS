<?php

	namespace models;
	
	class user extends abstractModel
	{	
		private $Id;
		private $FacilityId;
		private $NationalId;
		private $FirstName;
		private $LastName;
		private $UserName;
		private $Password;
		private $Disabled;
		private $Created;

		private $errors = array();
		
		public function __construct() 
		{
			parent::__construct();
		}
		
		public function setError($value) { $this->errors = array_merge($this->errors, $value); }
		public function getErrors() { return !empty($this->errors) ? $this->errors : false; }
		
		/**
		 * get user details
		 * @param unknown $userId
		 * @return array
		 */
		public function find($userId)
		{
			$data = array();
			if(!empty($userId))
			{
				$results = $this->db->sqlQuery("SELECT * FROM users WHERE Id = '".$userId."';");
				while($row = $this->db->getArray($results))
				{
					$data = $row;
				}
			}
			return $data;
		}

		/**
		 * save user data
		 * @param array $user
		 * @return array
		 */
		public function save(user $user)
		{
			$user->Name = strtoupper($user->Name);
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
			$data = "
			$user->Id,
			'$user->Name'";
			
			$Id = (int) $user->Id;
			if ($Id == 0)
			{
				$results = $this->db->sqlQuery('INSERT INTO users VALUES ('.$data.');');
				while($row = $this->db->getArray($results))
				{
					$res = $row;
				}
				return $res;
			}
			else
			{
				if ($this->find($Id))
				{
					$results = $this->db->sqlQuery('UPDATE users SET ('.$data.');');
					return true;
				}
			}
			return false;
		}

		/**
		 * change user password
		 * @param unknown $userId
		 * @param unknown $newPassword
		 * @return boolean
		 */
		public function changePassword($userId, $newPassword)
		{
			if (!empty($userId) && !empty($newPassword))
			{
				$row = $this->find($userId);
				if ($row)
				{
					$results = $this->db->sqlQuery('UPDATE users SET Password = '.$newPassword.' WHERE UserName = '.$userId.';');
					return true;
				}
			}
			return false;
		}
		
		/**
		 * user login
		 * @param string $username
		 * @param string $password
		 * @return boolean
		 */
		public function login($username, $password)
		{
			$identity = array();
			if(!empty($username) && !empty($password))
			{
				$results = $this->db->sqlQuery("SELECT * FROM users WHERE UserName = '".$username."' AND Password = '".$password."';");
				while($row = $this->db->getArray($results))
				{
					$identity= $row;
				}
			}
			return $identity;
		}

		/**
		 * disable user record
		 * @param int $userId
		 * @param bool $disable
		 * @return bool
		 */
		public function disable($userId, $disable = false)
		{
			if (!empty($userId))
			{
				$row = $this->find($userId);
				if ($row)
				{
					$results = $this->db->sqlQuery('UPDATE users SET Disabled = '.$disable.' WHERE Id = '.$userId.';');
					return true;
				}
			}
			return false;
		}
		
		/**
		 * delete user record
		 * @param int $userId
		 * @return bool
		 */
		public function delete($userId)
		{
			if (!empty($userId))
			{
				$row = $this->find($userId);
				if ($row)
				{
					$results = $this->db->sqlQuery('DELETE FROM users WHERE Id = '.$userId.';');
					return true;
				}
			}
			return false;
		}

		/**
		 * object data assignment from input data
		 * @param array $data
		 */
		public function exchangeArray($data)
		{
			$this->Id = (!empty($data['Id'])) ? $data['Id'] : 0;
			$this->FacilityId = (!empty($data['FacilityId'])) ? $data['FacilityId'] : null;
			$this->NationalId = (!empty($data['NationalId'])) ? $data['NationalId'] : null;
			$this->FirstName = (!empty($data['FirstName'])) ? $data['FirstName'] : null;
			$this->LastName = (!empty($data['LastName'])) ? $data['LastName'] : null;
			$this->UserName = (!empty($data['UserName'])) ? $data['UserName'] : null;
			$this->Password = (!empty($data['Password'])) ? $data['Password'] : null;
			$this->Disabled = (!empty($data['Disabled'])) ? $data['Disabled'] : 0;
			$this->Created = (!empty($data['Created'])) ? $data['Created'] : date("Y-m-d H:i:s");
		}
		
		/**
		 * validate user inputs
		 * @param array $data
		 * @return array
		 */
		public function validateTtDetails($data)
		{
			$validationRule = array(
				'FacilityId' => array('required' => true, 'type' => 'int', 'message' => 'The Facility is required.'),
				'NationalId' => array('required' => true, 'type' => 'string', 'message' => 'The National IdNo. is required.'),
				'FirstName' => array('required' => true, 'type' => 'string', 'message' => 'The First Name is required.'),
				'LastName' => array('required' => true, 'type' => 'string', 'message' => 'The Last Name is required.'),
				'UserName' => array('required' => true, 'type' => 'string', 'message' => 'The Username is required.'),
				'Password' => array('required' => true, 'type' => 'string', 'message' => 'The Password is required.'),
			);
			$this->setError(\core\validator::validate($data, $validationRule));
		}
	}