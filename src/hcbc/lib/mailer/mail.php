<?php

	namespace lib\mailer;
	
	require_once 'agent/PHPMailerAutoload.php';
	
	class mail
	{
		private $mailer;
		public function __construct()
		{
			\core\app::setDefaultTimeZone();
			$app = \core\app::getAppDetails();
			$config = \core\app::getMailConfigs();
			//mail configs values
			$this->mailer = new \PHPMailer;
			$this->mailer->isSMTP();
			$this->mailer->Host = $config['host'];
			$this->mailer->Port = $config['port'];
			$this->mailer->SMTPAuth = true;
			$this->mailer->SMTPDebug = 0;
			$this->mailer->Debugoutput = 'html';
			if(!empty($config['useSsl'])) $this->mailer->SMTPSecure = 'ssl';
			//default mail values
			$this->mailer->Username = $config['username'];
			$this->mailer->Password = $config['password'];
			$this->mailer->setFrom($config['username'], $app['company'].' - '.$app['appTitle']);
			$this->mailer->addReplyTo($config['username'], $app['company'].' - '.$app['appTitle']);
		}
		
		/**
		 * email priority
		 * Options: null (default), 1 = High, 3 = Normal, 5 = low.
		 * @param integer $priority
		 */
		public function setPriority($priority = null)
		{
			$this->mailer->Priority = $priority;
		}
		
		/**
		 * username to use for SMTP authentication
		 * @param string $username
		 */
		private function setUsername($username)
		{
			$this->mailer->Username = $username;
		}
		
		/**
		 * password to use for SMTP authentication
		 * @param string $password
		 */
		private function setPassword($password)
		{
			$this->mailer->Password = $password;
		}
		
		/**
		 * set the address of the mail sender
		 * @param string $address
		 * @param string $password
		 * @param string $name
		 */
		public function setFrom($address, $password, $name = null)
		{
			$this->setUsername($address);
			$this->setPassword($password);
			$this->mailer->setFrom($address, $name);
		}
		
		/**
		 * set an alternative reply-to address
		 * @param string $address
		 * @param string $name
		 */
		public function addReplyTo($address, $name = null)
		{
			$this->mailer->addReplyTo($address, $name);
		}
		
		/**
		 * set the primary mail recipient(s)
		 * @param array $recipient
		 */
		public function addRecipient(recipient $recipient)
		{
			if(!empty($recipient))
			{
				$this->mailer->addAddress($recipient->getEmailAddress(), $recipient->getName());
			}
		}

		/**
		 * add CC recipient(s)
		 * @param recipient $cc
		 */
		public function addCc(recipient $cc)
		{
			if(!empty($cc))
			{
				$this->mailer->addCC($cc->getEmailAddress(), $cc->getName());
			}
		}

		/**
		 * add BCC recipient(s)
		 * @param recipient $bcc
		 */
		public function addBcc(recipient $bcc)
		{
			if(!empty($bcc))
			{
				$this->mailer->addBCC($bcc->getEmailAddress(), $bcc->getName());
			}
		}

		/**
		 * set the subject line
		 * @param string $subject
		 */
		public function setSubject($subject)
		{
			$this->mailer->Subject = $subject;
		}
		
		/**
		 * set message body as either plain text or html
		 * @param string $content
		 * @param string $msgType
		 */
		public function setBody($content = '', $msgType = 'html')
		{
			switch ($msgType) 
			{
				case "html":
					$this->mailer->msgHTML($content);
				break;
				case "text":
					$this->mailer->AltBody = $content;
				break;
				default:
					$this->mailer->msgHTML($content);
				break;
			}
		}
		
		/**
		 * attach file(s)
		 * @param array $files
		 */
		public function addAttachment($files = array())
		{
			if(!empty($files))
			{
				if(is_array($files))
				{
					foreach ($files as $file) 
					{
						$this->mailer->addAttachment($file);
					}
				}
				else 
				{
					$this->mailer->addAttachment($files);
				}
			}
		}
		
		/**
		 * send the message
		 * @return boolean
		 */
		public function send()
		{
			return (!$this->mailer->send()) ? false : true;
		}
		
		/**
		 * get error information generated if there is an exception in the send method
		 * @return string
		 */
		public function getError()
		{
			return $this->mailer->ErrorInfo;
		}
		
	}