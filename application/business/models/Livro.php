<?php
	class Biblioteca_Business_Model_Livro
	{
		private $_isbn;
		private $_titulo;
		private $_paginas;
		private $_ano;
		private $_resenha;
		private $_editora;
		private $_autor;
		
		public function getIsbn()
		{
			return $this->_isbn;
		}
		
		public function setIsbn($isbn)
		{
			$this->_isbn = $isbn;
			return $this;
		}
	
		public function getTitulo()
		{
			return $this->_titulo;
		}
		
		public function setTitulo($titulo)
		{
			$this->_titulo = $titulo;
			return $this;
		}
	
		public function getPaginas()
		{
			return $this->_paginas;
		}
		
		public function setPaginas($paginas)
		{
			$this->_paginas = $paginas;
			return $this;
		}
	
		public function getAno()
		{
			return $this->_ano;
		}
		
		public function setAno($ano)
		{
			$this->_ano = $ano;
			return $this;
		}
	
		public function getResenha()
		{
			return $this->_resenha;
		}
		
		public function setResenha($resenha)
		{
			$this->_resenha = $resenha;
			return $this;
		}
	
		public function getEditora()
		{
			return $this->_editora;
		}
		
		public function setEditora(Biblioteca_Business_Model_Editora $editora)
		{
			$this->_editora = $editora;
			return $this;
		}
	
		public function getAutor()
		{
			return $this->_autor;
		}
		
		public function setAutor(Biblioteca_Business_Model_Autor $autor)
		{
			$this->_autor = $autor;
			return $this;
		}
	}