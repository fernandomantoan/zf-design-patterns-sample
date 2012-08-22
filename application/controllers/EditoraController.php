<?php

class EditoraController extends Zend_Controller_Action
{
	public function init()
	{
		if (!Zend_Auth::getInstance()->hasIdentity())
		{
			$this->_redirect('/auth');
		}

		$this->facade = FernandoMantoan_DesignPatterns_Factory_FactoryFacade::createInstance(FernandoMantoan_DesignPatterns_Factory_FactoryFacade::FACADE_PUBLISHER);
	}

	public function indexAction()
	{
		$this->view->headTitle('Editoras', 'PREPEND');
		$this->view->editoras = $this->facade->listBusiness();
	}

	public function adicionarAction()
	{
		$this->view->headTitle('Nova Editora', 'PREPEND');

		$form = new Library_Form_Publisher();
		$this->view->form = $form;

		if ($this->getRequest()->isPost())
		{
			$data = $this->getRequest()->getPost();
			if ($this->facade->addBusiness($data, $form))
			{
				$this->_helper->FlashMessenger('Editora cadastrada com sucesso!');
				$this->_redirect('/editora');
			}
			else
			{
				$form->populate($data);
			}
		}
	}

	public function editarAction()
	{
		$this->view->headTitle('Editar Editora', 'PREPEND');

		$form = new Library_Form_Publisher();
		$this->view->form = $form;

		if ($this->getRequest()->isPost())
		{
			$data = $this->getRequest()->getPost();
			if ($this->facade->editBusiness($data, $form))
			{
				$this->_helper->FlashMessenger('Editora atualizada com sucesso!');
				$this->_redirect('/editora');
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
				$this->_redirect('/editora');
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
			$this->_helper->FlashMessenger('Editora excluída com sucesso!');
		}
		$this->_redirect('/editora');
	}

	public function visualizarAction()
	{
		$this->view->headTitle('Visualizar Editora', 'PREPEND');

		$id = $this->_getParam('id', 0);
		if (!$data = $this->facade->viewBusiness($id))
		{
			$this->_redirect('/editora');
		}
		else
		{
			$this->view->editora = $data;
		}
	}
}