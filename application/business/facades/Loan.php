<?php
	class Library_Business_Facade_Loan
	{
		protected $_mapper;
		protected $_mapperItem;
		
		public function __construct()
		{
			$this->_mapper = new Library_Business_DataMapper_Loan();
			$this->_mapperItem = new Library_Business_DataMapper_LoanItem();
		}
		
		public function listBusiness()
		{
			return $this->_mapper->listAll();
		}
		
		public function listItensBusiness($emprestimo_id)
		{
			return $this->_mapperItem->listAll($emprestimo_id);
		}
		
		public function addBusiness($data, $form)
		{
			if ($form->isValid($data))
			{
				$data_emprestimo = $form->getValue('data_emprestimo');
				$membro_id = $form->getValue('membro_id');
				$valor_juros = $form->getValue('valor_juros');
				return $this->_mapper->add($data_emprestimo, $membro_id, $valor_juros);
			}
			else
			{
				return false;
			}
		}
		
		public function addItemBusiness($data, $form)
		{
			if ($form->isValid($data))
			{
				$emprestimo_id = $form->getValue('emprestimo_id');
				$data_prevista = $form->getValue('data_prevista');
				$livro_isbn = $form->getValue('livro_isbn');
				if (!$this->verificaItemEmprestadoBusiness($livro_isbn))
				{
					$this->_mapperItem->add($emprestimo_id, $data_prevista, $livro_isbn);
				}
				return true;
			}
			else
			{
				return false;
			}
		}
		
		public function editBusiness($data, $form)
		{
			if ($form->isValid($data))
			{
				$id = (int) $form->getValue('id');
				$nome = $form->getValue('nome');
				$biografia = $form->getValue('biografia');
				$this->_mapper->edit($id, $nome, $biografia);
				return true;
			}
			else
			{
				return false;
			}
		}
		
		public function viewBusiness($id, $array = false)
		{
			if (empty($id))
			{
				return false;
			}
			$model = $this->_mapper->get($id, $array);
			if ($model)
			{
				return $model;
			}
			return false;
		}
		
		public function viewItemBusiness($item_id)
		{
			if (empty($item_id))
			{
				return false;
			}
			$model = $this->_mapperItem->get($item_id, false);
			if ($model)
			{
				return $model;
			}
			return false;
		}
		
		public function deleteBusiness($id)
		{
			if (empty($id))
			{
				return false;
			}
			$this->_mapper->delete($id);
			return true;
		}
		
		public function calculaJurosBusiness($id, $data_devolucao)
		{
			$item = $this->_mapperItem->get($id);
			$date_validator = new Zend_Validate_Date();
			if ($date_validator->isValid($data_devolucao))
			{
				$valor_juros = $item->getEmprestimo()->getValorJuros();
				$data_prevista = $item->getDataPrevista();
				
				$timestamp_data_devolucao = mktime(0, 0, 0, substr($data_devolucao, 5, 2), substr($data_devolucao, 8, 2), substr($data_devolucao, 0, 4));
				$timestamp_data_prevista = mktime(0, 0, 0, substr($data_prevista, 5, 2), substr($data_prevista, 8, 2), substr($data_prevista, 0, 4));
				
				$diferenca = ($timestamp_data_devolucao - $timestamp_data_prevista);
				if ($diferenca <= 0)
				{
					return 0;
				}
				else
				{
					$dias_decorridos = ceil($diferenca / 86400);
					return $valor_juros * $dias_decorridos;
				}
			}
			return false;
		}
		
		public function devolveItemBusiness($data, $form)
		{
			if ($form->isValid($data))
			{
				$id = $form->getValue('id');
				$data_devolvida = $form->getValue('data_devolvida');
				$valor_pago = $this->calculaJurosBusiness($id, $data_devolvida);
				
				$this->_mapperItem->devolucao($id, $data_devolvida, $valor_pago);
				
				return true;
			}
			else
			{
				return false;
			}
		}
		
		/**
		 * Lógica para fazer a verificação se um determinado livro já foi emprestado
		 * 
		 * @param $isbn ISBN do livro que se deseja verificar
		 * @return boolean TRUE se o livro já foi emprestado e FALSE se não
		 */
		protected function verificaItemEmprestadoBusiness($isbn)
		{
			if ($item = $this->_mapperItem->getByIsbn($isbn))
			{
				if (is_null($item->getDataDevolvida()))
				{
					return true;
				}
				return false;
			}
			return false;
		}
	}
?>