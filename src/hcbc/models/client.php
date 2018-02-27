<?php

	namespace models;
	
	class client extends abstractModel
	{	
		private $Id;
		private $Code;
		private $FirstName;
		private $LastName;
		private $SurName;
		private $PostalAddress;
		private $PostalCode;
		private $Phone1;
		private $Phone2;
		private $Email;
		private $PhysicalLocation;
		private $City;
		private $CountryCode;
		private $NextOfKin;
		private $NOKPhone1;
		private $NOKPhone2;
		private $NOKPhysicalLocation;
		private $Imagepath;
		private $IsPatient;
		private $LastUpdated;

		private $errors = array();
		
		public function __construct() 
		{
			parent::__construct();
		}
		
		public function setError($value)
		{
			$this->errors = array_merge($this->errors, $value);
		}
		
		public function getErrors()
		{
			return !empty($this->errors) ? $this->errors : false;
		}
	
		/**
		 * return client records
		 * @param string $strSearch
		 * @return array 
		 */
		public function get($strSearch = null)
		{
			$data = array();
			if(!empty($strSearch))
			{
				$results = $this->db->sqlQuery("SELECT * FROM Clients WHERE SurName LIKE '%".$strSearch."%';");
			}
			else
			{
				$results = $this->db->sqlQuery("SELECT * FROM Clients;");
			}
			while($row = $this->db->getArray($results))
			{
				$data [] = $row;
			}
			return $data;
		}

		/**
		 * find client by Id
		 * @param int $id
		 * @return array
		 */
		public function find($id)
		{
			$data = array();
			if(!empty($id))
			{
				$results = $this->db->sqlQuery("SELECT * FROM Clients WHERE Id = '".$id."';");
				while($row = $this->db->getArray($results))
				{
					$data = $row;
				}
			}
			return $data;
		}

		/**
		 * save client data
		 * @param array $client
		 * @return array
		 */
		public function save(client $client)
		{
			$client->Name = strtoupper($client->Name);
			
			$data = "
			$client->Id,
			'$client->Name'";
			
			/*
			Id;
			Code;
			FirstName;
			LastName;
			SurName;
			PostalAddress;
			PostalCode;
			Phone1;
			Phone2;
			Email;
			PhysicalLocation;
			City;
			CountryCode;
			NextOfKin;
			NOKPhone1;
			NOKPhone2;
			NOKPhysicalLocation;
			Imagepath;
			IsPatient;
			LastUpdated;
			*/

			$Id = (int) $client->Id;
			if ($Id == 0)
			{
				$results = $this->db->sqlQuery('INSERT INTO Clients VALUES ('.$data.');');
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
					$results = $this->db->sqlQuery('UPDATE Clients SET ('.$data.');');
					return true;
				}
			}
			return false;
		}
		
		/**
		 * delete client record
		 * @param int $id
		 * @return bool
		 */
		public function delete($id)
		{
			if (!empty($id))
			{
				$row = $this->find($id);
				if ($row)
				{
					$results = $this->db->sqlQuery('DELETE FROM Clients WHERE Id = '.$id.';');
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
			$this->Code = (!empty($data['Code'])) ? $data['Code'] : null;
			$this->FirstName = (!empty($data['FirstName'])) ? $data['FirstName'] : null;
			$this->LastName = (!empty($data['LastName'])) ? $data['LastName'] : null;
			$this->SurName = (!empty($data['SurName'])) ? $data['SurName'] : null;
			$this->PostalAddress = (!empty($data['PostalAddress'])) ? $data['PostalAddress'] : null;
			$this->PostalCode = (!empty($data['PostalCode'])) ? $data['PostalCode'] : null;
			$this->Phone1 = (!empty($data['Phone1'])) ? $data['Phone1'] : null;
			$this->Phone2 = (!empty($data['Phone2'])) ? $data['Phone2'] : null;
			$this->Email = (!empty($data['Email'])) ? $data['Email'] : null;
			$this->PhysicalLocation = (!empty($data['PhysicalLocation'])) ? $data['PhysicalLocation'] : null;
			$this->City = (!empty($data['City'])) ? $data['City'] : null;
			$this->CountryCode = (!empty($data['CountryCode'])) ? $data['CountryCode'] : null;
			$this->NextOfKin = (!empty($data['NextOfKin'])) ? $data['NextOfKin'] : null;
			$this->NOKPhone1 = (!empty($data['NOKPhone1'])) ? $data['NOKPhone1'] : null;
			$this->NOKPhone2 = (!empty($data['NOKPhone2'])) ? $data['NOKPhone2'] : null;
			$this->NOKPhysicalLocation = (!empty($data['NOKPhysicalLocation'])) ? $data['NOKPhysicalLocation'] : null;
			$this->Imagepath = (!empty($data['Imagepath'])) ? $data['Imagepath'] : null;
			$this->IsPatient = (!empty($data['IsPatient'])) ? $data['IsPatient'] : 0;
			$this->LastUpdated = (!empty($data['LastUpdated'])) ? $data['LastUpdated'] : date('Y-m-d H:i:s');
		}
		
		/**
		 * validate client details inputs
		 * @param array $data
		 * @return array
		 */
		public function validateTtDetails($data)
		{
			$validationRule = array(
				'Code' => array('required' => true, 'type' => 'string', 'message' => 'The Client Code is required.'),
				'FirstName' => array('required' => true, 'type' => 'string', 'message' => 'First Name is required.'),
				'LastName' => array('required' => true, 'type' => 'string', 'message' => 'Last Name is required.'),
				'Phone1' => array('required' => true, 'type' => 'string', 'message' => 'The primary phone number is required.'),
				'PhysicalLocation' => array('required' => true, 'type' => 'string', 'message' => 'The resident location is required.'),
				'NextOfKin' => array('required' => true, 'type' => 'string', 'message' => 'The Next of Kin is required.'),
				'NOKPhone1' => array('required' => true, 'type' => 'string', 'message' => 'The Next of Kin primary phone number is required.'),
			);
			$this->setError(\core\validator::validate($data, $validationRule));
		}
	}