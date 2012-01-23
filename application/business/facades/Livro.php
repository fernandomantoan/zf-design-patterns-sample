<?php
	class Biblioteca_Business_Facade_Livro
	{
		protected $_mapper;
		
		public function __construct()
		{
			$this->_mapper = new Biblioteca_Business_DataMapper_Livro();
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
				$isbn = $form->getValue('isbn');
				$editora_id = $form->getValue('editora_id');
				$autor_id = $form->getValue('autor_id');
				$titulo = $form->getValue('titulo');
				$paginas = $form->getValue('paginas');
				$ano = $form->getValue('ano');
				$resenha = $form->getValue('resenha');
				$this->_mapper->add($isbn, $editora_id, $autor_id, $titulo, $paginas, $ano, $resenha);
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
				$isbn = $form->getValue('isbn');
				$editora_id = $form->getValue('editora_id');
				$autor_id = $form->getValue('autor_id');
				$titulo = $form->getValue('titulo');
				$paginas = $form->getValue('paginas');
				$ano = $form->getValue('ano');
				$resenha = $form->getValue('resenha');
				$this->_mapper->edit($isbn, $editora_id, $autor_id, $titulo, $paginas, $ano, $resenha);
				return true;
			}
			else
			{
				return false;
			}
		}
		
		public function viewBusiness($isbn, $array = false)
		{
			if (empty($isbn))
			{
				return false;
			}
			$model = $this->_mapper->get($isbn, $array);
			if ($model)
			{
				return $model;
			}
			return false;
		}
		
		public function deleteBusiness($isbn)
		{
			if (empty($isbn))
			{
				return false;
			}
			$this->_mapper->delete($isbn);
			return true;
		}
	}