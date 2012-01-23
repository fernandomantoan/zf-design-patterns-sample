<?php
	class Biblioteca_Business_Model_Autor
	{
		private $_id;
		private $_nome;
		private $_biografia;
		/**
		 * @return the $_id
		 */
		public function getId()
		{
			return $this->_id;
		}
		/**
		 * @param $_id the $_id to set
		 */
		public function setId($id)
		{
			$this->_id = $id;
			return $this;
		}
		/**
		 * @return the $_nome
		 */
		public function getNome()
		{
			return $this->_nome;
		}
		/**
		 * @param $nome the $nome to set
		 */
		public function setNome($nome)
		{
			$this->_nome = $nome;
			return $this;
		}
		/**
		 * @return the $_biografia
		 */
		public function getBiografia()
		{
			return $this->_biografia;
		}
		/**
		 * @param $biografia the $biografia to set
		 */
		public function setBiografia($biografia)
		{
			$this->_biografia = $biografia;
			return $this;
		}
	}