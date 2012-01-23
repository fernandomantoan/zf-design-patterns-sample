<?php
	class EmprestimoController extends Zend_Controller_Action
	{
	
		public function init()
		{
			if (!Zend_Auth::getInstance()->hasIdentity())
			{
				$this->_redirect('/auth');
			}
			 
			$this->facade = FactoryFacade::obterFacade(FactoryFacade::FACADE_EMPRESTIMO);
		}
	
		public function indexAction()
		{
			$this->view->headTitle('Empréstimos', 'PREPEND');
			$this->view->emprestimos = $this->facade->listBusiness();
		}
	
		public function adicionarAction()
		{
			$this->view->headTitle('Novo Empréstimo', 'PREPEND');
			 
			$form = new Biblioteca_Form_Emprestimo();
			$this->view->form = $form;
			 
			if ($this->getRequest()->isPost())
			{
				$data = $this->getRequest()->getPost();
				if ($id = $this->facade->addBusiness($data, $form))
				{
					$this->_helper->FlashMessenger('Empréstimo adicionado, insira agora os itens deste empréstimo.');
					$this->_redirect('/emprestimo/adicionaritens/id/' . $id);
				}
				else
				{
					$form->populate($data);
				}
			}
		}
	
		public function adicionaritensAction()
		{
			$this->view->headTitle('Adicionar Itens de Empréstimo', 'PREPEND');
			 
			$id = $this->_getParam('id', 0);
			 
			$form = new Biblioteca_Form_ItemEmprestimo();
			$form->getElement('emprestimo_id')->setValue($id);
			$this->view->form = $form;
			 
			if (!$data = $this->facade->viewBusiness($id))
			{
				$this->_redirect('/emprestimo');
			}
			else
			{
				$this->view->itens = $this->facade->listItensBusiness($id);
				$this->view->emprestimo = $data;
			}
			 
			if ($this->getRequest()->isPost())
			{
				$data_post = $this->getRequest()->getPost();
				if ($this->facade->addItemBusiness($data_post, $form))
				{
					$this->_helper->FlashMessenger('Item adicionado com sucesso!');
					$this->_helper->redirector->goToRoute(
						array(
                			'controller' => 'emprestimo',
                			'action' => 'adicionaritens',
                			'id' => $id
						)
					);
				}
				else
				{
					$form->populate($data_post);
				}
			}
		}
	
		public function editarAction()
		{
			$this->_redirect('/emprestimo');
		}
	
		public function deletarAction()
		{
			if ($this->facade->deleteBusiness($this->_getParam('id')))
			{
				$this->_helper->FlashMessenger('Empréstimo excluído com sucesso!');
			}
			$this->_redirect('/emprestimo');
		}
	
		public function devolverAction()
		{
			$this->view->headTitle('Devolver Item de Empréstimo', 'PREPEND');
			 
			$id = $this->_getParam('id', 0);
			 
			if (!$data = $this->facade->viewItemBusiness($id))
			{
				$this->_redirect('/emprestimo');
			}
			else
			{
				if (!is_null($data->getDataDevolvida()))
				{
					$this->_redirect('/emprestimo');
				}
				$form = new Biblioteca_Form_DevolverItem();
				$form->getElement('id')->setValue($id);
				$this->view->form = $form;
				$this->view->item = $data;
			}
			 
			if ($this->getRequest()->isPost())
			{
				$data_post = $this->getRequest()->getPost();
				if ($this->facade->devolveItemBusiness($data_post, $form))
				{
					$this->_helper->FlashMessenger('Item devolvido com sucesso!');
					$this->_helper->redirector->goToRoute(array(
	                		'controller' => 'emprestimo',
	                		'action' => 'adicionaritens',
	                		'id' => $data->getEmprestimo()->getId()
						)
					);
				}
				else
				{
					$form->populate($data_post);
				}
			}
		}
	
		public function calculajurosAction()
		{
			Zend_Layout::getMvcInstance()->disableLayout();
			$this->_helper->viewRenderer->setNoRender(true);
			
			$post = $this->getRequest()->getPost();
			$id = $post['id'];
			$data_devolucao = $post['data'];
			
			if (is_numeric($data = $this->facade->calculaJurosBusiness($id, $data_devolucao)))
			{
				echo "{'valor':'" . number_format($data, 2) . "'}";
			}
			else
			{
				echo "{'valor':''}";
			}
		}
	}