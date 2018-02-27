<?php

	namespace controllers;
	
	class account extends abstractController
	{
		protected $account;
		protected $errors = array();
		
		public function __construct($controller,$action)
		{
			parent::__construct($controller, $action);
			$this->account = new \models\user();
		}
		
		public function index()
		{
			$this->getView()->render($this->controller,  __FUNCTION__);
		}
		
		public function profile($id)
		{
			$this->getView()->render($this->controller,  __FUNCTION__);
		}
		
		public function login()
		{
			$isValid = $this->auth->isValid();
			if(!empty($isValid)) $this->app->redirectTo('/login');
			
			if(isset($_POST['lgusr']))
			{
				$data = $_POST;
				$username = trim($data['UserName']);
				$password = trim($data['password']);
				$remMe = isset($data['remMe']) ? 1 : 0;
				
				if(empty($username))
				{
					$this->account->setError(array('UserName' => 'The Username is required.'));
				}
				elseif(empty($password))
				{
					$this->account->setError(array('password' => 'The Password is required.'));
				}
				$this->errors = $this->account->getErrors();
				if(empty($this->errors))
				{
					$res = $this->account->login($username, $password);
					if (!empty($res))
					{
						if(empty($res['Disabled']))
						{
							$this->account->setError(array('Disabled' => 'Your Account has been disabled.'));
						}
						else 
						{
							$this->auth->setIdentity($res);
							if(!empty($remMe)) $this->app->setCookie('_hlpusd_', $res['UserName'], 1);
							$this->app->redirectTo('/main');
						}
					}
					else
					{
						$this->account->setError(array('Password' => 'Invalid Login credentials.'));
						$this->errors = $this->account->getErrors();
					}
				}
				else
				{
					$this->account->setError(array('UserName' => 'Please check your username and password and try again.'));
				}
			}
			return json_encode($this->errors);
		}
		
		public function password()
		{
			$data = $_POST;
			if(empty($this->identity))
			{
				$this->app->redirectTo('/logout');
			}
			else
			{
				$id = $this->identity['Username'];
			}
			if(isset($_POST['pasusr']))
			{
				if(empty($data['Id']))
				{
					$this->account->setError(array('Id' => 'The User is required.'));
				}
				elseif(empty($oldpassword))
				{
					$this->account->setError(array('oldpassword' => 'Your current User password is required.'));
				}
				elseif(empty($data['password']))
				{
					$this->account->setError(array('password' => 'The User password is required.'));
				}
				elseif($data['password']!= $data['confirmpassword'])
				{
					$this->account->setError(array('confirmpassword' => 'Password mismatch.'));
				}
				else
				{
					$valid = $this->account->validatePassword($data['UserName'], $data['oldpassword']);
					if(empty($valid))
					{
						$this->account->setError(array('oldpassword' => 'Your current password is invalid.'));
					}
				}
				
				$this->errors = $this->account->getErrors();
				if(empty($this->errors))
				{
					$this->account->exchangeArray($data);
					$pass = $this->account->changeUserPassword($data['Id'], $data['password']);
					if ($pass)
					{
						//TODO: email notification
						\core\app::redirectTo('/main/pas');
					}
				}
				else
				{
					header("HTTP/1.0 202 Accepted");
				}
			}
			$this->account = $this->getModel('models\user')->find($id);
			return json_encode($this->account);
		}
		
		public function reset()
		{
			$this->getView()->render($this->controller,  __FUNCTION__);
		}

		public function logout()
		{
			$this->auth->destroyIdentity();
			$this->app->redirectTo('/main');
		}
		
	}
