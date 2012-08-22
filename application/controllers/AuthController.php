<?php

class AuthController extends Zend_Controller_Action
{
	public function init()
	{
		$this->facade = FernandoMantoan_DesignPatterns_Factory_FactoryFacade::createInstance(
				FernandoMantoan_DesignPatterns_Factory_FactoryFacade::FACADE_AUTH);
		$this->_helper->layout->disableLayout();
	}

	public function indexAction()
	{
		if ($this->facade->checkLoggedUserBusiness())
			$this->_redirect('/');
		else
			return $this->_helper->redirector('login');
	}

	public function loginAction()
	{
		$form = new Library_Form_Login();
		$this->view->form = $form;

		if ($this->getRequest()->isPost()) {
			$data = $this->getRequest()->getPost();
			$validLogin = $this->facade->loginBusiness($data, $form);

			if ($validLogin === true) $this->_redirect('/');
			else if ($validLogin === false) $form->populate($data);
			else {
				$this->_helper->FlashMessenger('Usuário ou senha inválidos!');
				$this->_redirect('/auth/login');
			}
		}
	}

	public function logoutAction()
	{
		$this->facade->logoutBusiness();
		$this->_redirect('/auth');
	}
}