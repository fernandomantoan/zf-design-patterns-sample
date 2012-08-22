<?php

class LivroController extends Zend_Controller_Action
{
	public function init()
	{
		if (!Zend_Auth::getInstance()->hasIdentity())
		{
			$this->_redirect('/auth');
		}

		$this->facade = FernandoMantoan_DesignPatterns_Factory_FactoryFacade::createInstance(FernandoMantoan_DesignPatterns_Factory_FactoryFacade::FACADE_BOOK);
	}

	public function indexAction()
	{
		$this->view->headTitle('Livros', 'PREPEND');
		$this->view->livros = $this->facade->listBusiness();
	}

	public function adicionarAction()
	{
		$this->view->headTitle('Novo Livro', 'PREPEND');

		$form = new Library_Form_Book();
		$this->view->form = $form;

		if ($this->getRequest()->isPost())
		{
			$data = $this->getRequest()->getPost();
			if ($this->facade->addBusiness($data, $form))
			{
				$this->_helper->FlashMessenger('Livro cadastrado com sucesso!');
				$this->_redirect('/livro');
			}
			else
			{
				$form->populate($data);
			}
		}
	}

	public function editarAction()
	{
		$this->view->headTitle('Editar Livro', 'PREPEND');

		$form = new Library_Form_Book(array('editar' => true));
		$this->view->form = $form;

		if ($this->getRequest()->isPost())
		{
			$data = $this->getRequest()->getPost();
			if ($this->facade->editBusiness($data, $form))
			{
				$this->_helper->FlashMessenger('Livro atualizado com sucesso!');
				$this->_redirect('/livro');
			}
			else
			{
				$form->populate($data);
			}
		}
		else
		{
			$isbn = $this->_getParam('isbn', 0);
			if (!$data = $this->facade->viewBusiness($isbn, true))
			{
				$this->_redirect('/livro');
			}
			else
			{
				$form->populate($data);
			}
		}
	}

	public function deletarAction()
	{
		if ($this->facade->deleteBusiness($this->_getParam('isbn')))
		{
			$this->_helper->FlashMessenger('Livro excluído com sucesso!');
		}
		$this->_redirect('/livro');
	}

	public function visualizarAction()
	{
		$this->view->headTitle('Visualizar Livro', 'PREPEND');

		$isbn = $this->_getParam('isbn', 0);
		if (!$data = $this->facade->viewBusiness($isbn))
		{
			$this->_redirect('/livro');
		}
		else
		{
			$this->view->livro = $data;
		}
	}
}