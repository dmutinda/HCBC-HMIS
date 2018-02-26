<?php
	
	namespace lib\mailer;
	
	class recipient
	{
		protected $emailAddress;
		protected $name;
		
		public function __construct($emailAddress, $name)
		{
			$this->setEmailAddress($emailAddress);
			$this->setName($name);
		}
		
		public function setEmailAddress($value)
		{
			$this->emailAddress = $value;
		}
		
		public function getEmailAddress()
		{
			return $this->emailAddress;
		}
		
		public function setName($value)
		{
			$this->name = $value;
		}
		
		public function getName()
		{
			return $this->name;
		}
		
	}