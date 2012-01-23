<?php
	class MembroController extends Zend_Controller_Action
	{
		
		public function init()
		{
			if (!Zend_Auth::getInstance()->hasIdentity())
			{
				$this->_redirect('/auth');
			}
			
			$this->facade = FactoryFacade::obterFacade(FactoryFacade::FACADE_MEMBRO);
		}
		
		public function indexAction()
		{
			$this->view->headTitle('Membros', 'PREPEND');
			$this->view->membros = $this->facade->listBusiness();
		}
		
		public function adicionarAction()
		{
			$this->view->headTitle('Novo Membro', 'PREPEND');
			
			$form = new Biblioteca_Form_Membro();
			$this->view->form = $form;
			
			if ($this->getRequest()->isPost())
			{
				$data = $this->getRequest()->getPost();
				if ($this->facade->addBusiness($data, $form))
				{
					$this->_helper->FlashMessenger('Membro cadastrado com sucesso!');
					$this->_redirect('/membro');
				}
				else
				{
					$form->populate($data);
				}
			}
		}
		
		public function editarAction()
		{
			$this->view->headTitle('Editar Membro', 'PREPEND');
			
			$form = new Biblioteca_Form_Membro();
			$this->view->form = $form;
			
			if ($this->getRequest()->isPost())
			{
				$data = $this->getRequest()->getPost();
				if ($this->facade->editBusiness($data, $form))
				{
					$this->_helper->FlashMessenger('Membro atualizado com sucesso!');
					$this->_redirect('/membro');
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
					$this->_redirect('/membro');
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
				$this->_helper->FlashMessenger('Membro excluído com sucesso!');
			}
			$this->_redirect('/membro');
		}
		
		public function visualizarAction()
		{
			$this->view->headTitle('Visualizar Membro', 'PREPEND');
			
			$id = $this->_getParam('id', 0);
			if (!$data = $this->facade->viewBusiness($id))
			{
				$this->_redirect('/membro');
			}
			else
			{
				$this->view->membro = $data;
			}
		}
	}