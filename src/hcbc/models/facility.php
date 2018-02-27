<?php

	namespace models;
	
	class facility extends abstractModel
	{	
		private $Id;
		private $FacilityCode;
		private $CompanyId;
		private $FacilityName;
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
		 * return facility records
		 * @param string $strSearch
		 * @return array 
		 */
		public function get($strSearch = null)
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
		 * @param int $id
		 * @return array
		 */
		public function find($id)
		{
			$data = array();
			if(!empty($id))
			{
				$results = $this->db->sqlQuery("SELECT * FROM Facilities WHERE Id = '".$id."';");
				while($row = $this->db->getArray($results))
				{
					$data = $row;
				}
			}
			return $data;
		}

		/**
		 * save facility data
		 * @param array $facility
		 * @return array
		 */
		public function save(facility $facility)
		{
			$facility->Name = strtoupper($facility->Name);
			
			$data = "
			$facility->Id,
			'$facility->Name'";
			
			/*
			Id;
			FacilityCode;
			CompanyId;
			FacilityName;
			Created;
			*/

			$Id = (int) $facility->Id;
			if ($Id == 0)
			{
				$results = $this->db->sqlQuery('INSERT INTO Facilities VALUES ('.$data.');');
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
					$results = $this->db->sqlQuery('UPDATE Facilities SET ('.$data.');');
					return true;
				}
			}
			return false;
		}
		
		/**
		 * delete facility record
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
					$results = $this->db->sqlQuery('DELETE FROM Facilities WHERE Id = '.$id.';');
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
			$this->FacilityCode = (!empty($data['FacilityCode'])) ? $data['FacilityCode'] : null;
			$this->CompanyId = (!empty($data['CompanyId'])) ? $data['CompanyId'] : 0;
			$this->FacilityName = (!empty($data['FacilityName'])) ? $data['FacilityName'] : 0;
			$this->Created = (!empty($data['Created'])) ? $data['Created'] : date('Y-m-d H:i:s');
		}
		
		/**
		 * validate facility details inputs
		 * @param array $data
		 * @return array
		 */
		public function validateTtDetails($data)
		{
			$validationRule = array(
				'FacilityCode' => array('required' => true, 'type' => 'string', 'message' => 'The Facility Code is required.'),
				'CompanyId' => array('required' => true, 'type' => 'int', 'message' => 'The Institution is required.'),
				'FacilityName' => array('required' => true, 'type' => 'string', 'message' => 'The Facility name is required.'),
			);
			$this->setError(\core\validator::validate($data, $validationRule));
		}
	}