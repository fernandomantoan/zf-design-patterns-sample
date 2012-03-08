<?php

class Library_Business_Facade_Auth
{
	private $_auth;
	
	public function __construct()
	{
		$this->_auth = Zend_Auth::getInstance();
	}
	
	protected function getAuthAdapter()
	{
		return $this->_auth;
	}
	
	public function checkLoggedUserBusiness()
	{
		return $this->getAuthAdapter()->hasIdentity();
	}
	
	public function loginBusiness($data, $form)
	{
		if ($form->isValid($data)) {
			$login = $form->getValue('login');
			$senha = $form->getValue('senha');
			
			$dbAdapter = Zend_Db_Table::getDefaultAdapter();
			$authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
			
			$authAdapter->setTableName('usuario')
						->setIdentityColumn('login')
						->setCredentialColumn('senha')
						->setCredentialTreatment('SHA1(?)');
			
			$authAdapter->setIdentity($login)
						->setCredential($senha);
			
			$auth = Zend_Auth::getInstance();
			$result = $auth->authenticate($authAdapter);
			
			if ($result->isValid()) {
				$info = $authAdapter->getResultRowObject(null, 'senha');
				
				$storage = $auth->getStorage();
				$storage->write($info);
				
				return true;
			}
			else
				return 'error';
		}
		else
			return false;
	}
	
	public function logoutBusiness()
	{
		$this->getAuthAdapter()->clearIdentity();
	}
}