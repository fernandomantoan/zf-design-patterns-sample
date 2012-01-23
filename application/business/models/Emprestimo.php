<?php
	class Biblioteca_Business_Model_Emprestimo
	{
		private $_id;
		private $_membro;
		private $_data_emprestimo;
		private $_valor_juros;
		
		public function getId()
		{
			return $this->_id;
		}
		
		public function setId($id)
		{
			$this->_id = $id;
			return $this;
		}
		
		public function getMembro()
		{
			return $this->_membro;
		}
		
		public function setMembro(Biblioteca_Business_Model_Membro $membro)
		{
			$this->_membro = $membro;
			return $this;
		}
		
		public function getDataEmprestimo()
		{
			return $this->_data_emprestimo;
		}
		
		public function setDataEmprestimo($data_emprestimo)
		{
			$this->_data_emprestimo = $data_emprestimo;
			return $this;
		}
		
		public function getValorJuros()
		{
			return $this->_valor_juros;
		}
		
		public function setValorJuros($valor_juros)
		{
			$this->_valor_juros = $valor_juros;
			return $this;
		}
	}