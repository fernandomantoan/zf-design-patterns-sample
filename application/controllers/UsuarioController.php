<?php
	class UsuarioController extends Zend_Controller_Action
	{

		public function init()
		{
			if (!Zend_Auth::getInstance()->hasIdentity())
			{
				$this->_redirect('/auth');
			}
			
			$this->facade = FactoryFacade::obterFacade(FactoryFacade::FACADE_USUARIO);
		}
		
		public function indexAction()
		{
			$this->view->headTitle('Usuários', 'PREPEND');
			$this->view->usuarios = $this->facade->listBusiness();
		}
		
		public function adicionarAction()
		{
			$this->view->headTitle('Novo Usuário', 'PREPEND');
			
			$form = new Biblioteca_Form_Usuario();
			$this->view->form = $form;
			
			if ($this->getRequest()->isPost())
			{
				$data = $this->getRequest()->getPost();
				if ($this->facade->addBusiness($data, $form))
				{
					$this->_helper->FlashMessenger('Usuário cadastrado com sucesso!');
					$this->_redirect('/usuario');
				}
				else
				{
					$form->populate($data);
				}
			}
		}
		
		public function editarAction()
		{
			$this->view->headTitle('Editar Usuário', 'PREPEND');
			
			$form = new Biblioteca_Form_Usuario(array('editar' => true));
			$this->view->form = $form;
			
			if ($this->getRequest()->isPost())
			{
				$data = $this->getRequest()->getPost();
				if ($this->facade->editBusiness($data, $form))
				{
					$this->_helper->FlashMessenger('Usuário atualizado com sucesso!');
					$this->_redirect('/usuario');
				}
				else
				{
					$form->populate($data);
				}
			}
			else
			{
				$id = $this->_getParam('id', 0);
				if (!$data = $this->facade->viewBusiness($id, true))
				{
					$this->_redirect('/usuario');
				}
				else
				{
					$form->populate($data);
				}
			}
		}
		
		public function deletarAction()
		{
			if ($this->facade->deleteBusiness($this->_getParam('id')))
			{
				$this->_helper->FlashMessenger('Usuário excluído com sucesso!');
			}
			$this->_redirect('/usuario');
		}
		
		public function visualizarAction()
		{
			$this->view->headTitle('Visualizar Usuário', 'PREPEND');
			
			$id = $this->_getParam('id', 0);
			if (!$data = $this->facade->viewBusiness($id))
			{
				$this->_redirect('/usuario');
			}
			else
			{
				$this->view->usuario = $data;
			}
		}
	}