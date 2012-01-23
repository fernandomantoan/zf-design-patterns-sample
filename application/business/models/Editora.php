<?php
	class Biblioteca_Business_Model_Editora
	{
		private $_id;
		private $_nome;
		private $_localizacao;
		private $_website;
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
		public function setId($id) {
			$this->_id = $id;
			return $this;
		}
		/**
		 * @return the $_nome
		 */
		public function getNome() {
			return $this->_nome;
		}
		/**
		 * @param $nome the $nome to set
		 */
		public function setNome($nome) {
			$this->_nome = $nome;
			return $this;
		}
		/**
		 * @return the $_localizacao
		 */
		public function getLocalizacao() {
			return $this->_localizacao;
		}
		/**
		 * @param $localizacao the $localizacao to set
		 */
		public function setLocalizacao($localizacao) {
			$this->_localizacao = $localizacao;
			return $this;
		}
		/**
		 * @return the $_website
		 */
		public function getWebsite() {
			return $this->_website;
		}
		/**
		 * @param $website the $website to set
		 */
		public function setWebsite($website) {
			$this->_website = $website;
			return $this;
		}
	}