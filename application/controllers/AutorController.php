<?php
	class AutorController extends Zend_Controller_Action
	{
		
		public function init()
		{
			if (!Zend_Auth::getInstance()->hasIdentity())
			{
				$this->_redirect('/auth');
			}
			
			$this->facade = FactoryFacade::createInstance(FactoryFacade::FACADE_AUTOR);
		}
		
		public function indexAction()
		{
			$this->view->headTitle('Autores', 'PREPEND');
			$this->view->autores = $this->facade->listBusiness();
		}
		
		public function adicionarAction()
		{
			$this->view->headTitle('Novo Autor', 'PREPEND');
			
			$form = new Biblioteca_Form_Autor();
			$this->view->form = $form;
			
			if ($this->getRequest()->isPost())
			{
				$data = $this->getRequest()->getPost();
				if ($this->facade->addBusiness($data, $form))
				{
					$this->_helper->FlashMessenger('Autor cadastrado com sucesso!');
					$this->_redirect('/autor');
				}
				else
				{
					$form->populate($data);
				}
			}
		}
		
		public function editarAction()
		{
			$this->view->headTitle('Editar Autor', 'PREPEND');
			
			$form = new Biblioteca_Form_Autor();
			$this->view->form = $form;
			
			if ($this->getRequest()->isPost())
			{
				$data = $this->getRequest()->getPost();
				if ($this->facade->editBusiness($data, $form))
				{
					$this->_helper->FlashMessenger('Autor atualizado com sucesso!');
					$this->_redirect('/autor');
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
					$this->_redirect('/autor');
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
				$this->_helper->FlashMessenger('Autor excluído com sucesso!');
			}
			$this->_redirect('/autor');
		}
		
		public function visualizarAction()
		{
			$this->view->headTitle('Visualizar Autor', 'PREPEND');
			
			$id = $this->_getParam('id', 0);
			if (!$data = $this->facade->viewBusiness($id))
			{
				$this->_redirect('/autor');
			}
			else
			{
				$this->view->autor = $data;
			}
		}
	}
