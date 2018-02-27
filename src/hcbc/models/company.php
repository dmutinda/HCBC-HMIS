<?php

	namespace models;
	
	class company extends abstractModel
	{	
		private $Id;
		private $Code;
		private $Name;
		private $Contact;
		private $PostalAddress;
		private $PostalCode;
		private $Phone1;
		private $Phone2;
		private $Email;
		private $Website;
		private $PhysicalLocation;
		private $City;
		private $CountryCode;
		private $TaxNumber;
		private $Logopath;
		private $Disabled;
		private $DefaultCompany;
		private $Created;

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
		 * return company records
		 * @param string $strSearch
		 * @return array 
		 */
		public function get($strSearch = null)
		{
			$data = array();
			if(!empty($strSearch))
			{
				$results = $this->db->sqlQuery("SELECT * FROM Companies WHERE Name LIKE '%".$strSearch."%';");
			}
			else
			{
				$results = $this->db->sqlQuery("SELECT * FROM Companies;");
			}
			while($row = $this->db->getArray($results))
			{
				$data [] = $row;
			}
			return $data;
		}

		/**
		 * return facilities records
		 * @param string $strSearch
		 * @return array 
		 */
		public function getFacilities($strSearch = null)
		{
			$data = array();
			if(!empty($strSearch))
			{
				$results = $this->db->sqlQuery("SELECT * FROM Facilities WHERE FacilityName LIKE '%".$strSearch."%';");
			}
			else
			{
				$results = $this->db->sqlQuery("SELECT * FROM Facilities;");
			}
			while($row = $this->db->getArray($results))
			{
				$data [] = $row;
			}
			return $data;
		}

		/**
		 * find facility by Id
		 * @param string $facilityId
		 * @return array 
		 */
		public function findFacility($facilityId)
		{
			$data = array();
			if(!empty($facilityId))
			{
				$results = $this->db->sqlQuery("SELECT * FROM Facilities WHERE Id = '".$facilityId."';");
			}
			else
			{
				$results = $this->db->sqlQuery("SELECT * FROM Atms;");
			}
			while($row = $this->db->getArray($results))
			{
				$data = $row;
			}
			return $data;
		}

		/**
		 * find company by Id
		 * @param int $id
		 * @return array
		 */
		public function find($id)
		{
			$data = array();
			if(!empty($id))
			{
				$results = $this->db->sqlQuery("SELECT * FROM Companies WHERE Id = '".$id."';");
				while($row = $this->db->getArray($results))
				{
					$data = $row;
				}
			}
			return $data;
		}

		/**
		 * save company data
		 * @param array $company
		 * @return array
		 */
		public function save(company $company)
		{
			$company->Name = strtoupper($company->Name);
			
			$data = "
			$company->Id,
			'$company->Name'";
			
			/*
			Id;
			Code;
			Name;
			Contact;
			PostalAddress
			PostalCode;
			Phone1;
			Phone2;
			Email;
			Website;
			PhysicalLocation;
			City;
			CountryCode;
			TaxNumber;
			Logopath;
			Disabled;
			DefaultCompany;
			Created;
			*/


			$Id = (int) $company->Id;
			if ($Id == 0)
			{
				$results = $this->db->sqlQuery('INSERT INTO Companies VALUES ('.$data.');');
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
					$results = $this->db->sqlQuery('UPDATE Companies SET ('.$data.');');
					return true;
				}
			}
			return false;
		}
		
		//delete company record
		public function delete($id)
		{
			if (!empty($id))
			{
				$row = $this->find($id);
				if ($row)
				{
					$results = $this->db->sqlQuery('DELETE FROM Companies WHERE Id = '.$id.';');
					return true;
				}
			}
			return false;
		}

		//delete facility record
		public function deleteFacility($id)
		{
			if (!empty($id))
			{
				$row = $this->find($id);
				if ($row)
				{
					$results = $this->db->sqlQuery('DELETE FROM Facilities WHERE Id = '.$id.';');
					return true;
				}
			}
			return false;
		}


		/*
			Id;
			Code;
			Name;
			Contact;
			PostalAddress
			PostalCode;
			Phone1;
			Phone2;
			Email;
			Website;
			PhysicalLocation;
			City;
			CountryCode;
			TaxNumber;
			Logopath;
			Disabled;
			DefaultCompany;
			Created;
			*/


		/**
		 * object data assignment from input data
		 * @param array $data
		 */
		public function exchangeArray($data)
		{
			$this->Id = (!empty($data['Id'])) ? $data['Id'] : 0;
			$this->Name = (!empty($data['Name'])) ? $data['Name'] : null;
		}
		
		/**
		 * validate company details inputs
		 * @param array $data
		 * @return array
		 */
		public function validateTtDetails($data)
		{
			$validationRule = array(
				'Name' => array('required' => true, 'type' => 'string', 'message' => 'The Company name is required.'),
			);
			$this->setError(\core\validator::validate($data, $validationRule));
		}
	}