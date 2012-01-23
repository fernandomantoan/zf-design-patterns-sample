<?php
	class Biblioteca_Business_Facade_Membro
	{
		protected $_mapper;
		
		public function __construct()
		{
			$this->_mapper = new Biblioteca_Business_DataMapper_Membro();
		}
		
		public function htmlselectBusiness()
		{
			return $this->_mapper->listSelect();
		}
		
		public function listBusiness()
		{
			return $this->_mapper->listAll();
		}
		
		public function addBusiness($data, $form)
		{
			if ($form->isValid($data))
			{
				$nome = $form->getValue('nome');
				$endereco = $form->getValue('endereco');
				$telefone = $form->getValue('telefone');
				$this->_mapper->add($nome, $endereco, $telefone);
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
				$endereco = $form->getValue('endereco');
				$telefone = $form->getValue('telefone');
				$this->_mapper->edit($id, $nome, $endereco, $telefone);
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
		
		public function deleteBusiness($id)
		{
			if (empty($id))
			{
				return false;
			}
			$this->_mapper->delete($id);
			return true;
		}
	}