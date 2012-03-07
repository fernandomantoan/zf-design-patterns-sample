<?php
	class Biblioteca_Business_Model_ItemEmprestimo
	{
		protected $_id;
		protected $_emprestimo;
		protected $_livro;
		protected $_data_prevista;
		protected $_data_devolvida;
		protected $_valor_pago;
		
		public function getId()
		{
			return $this->_id;
		}
		
		public function setId($id)
		{
			$this->_id = $id;
			return $this;
		}
		
		public function getLivro()
		{
			return $this->_livro;
		}
		
		public function setLivro($livro)
		{
			$this->_livro = $livro;
			return $this;
		}
		
		public function getEmprestimo()
		{
			return $this->_emprestimo;
		}
		
		public function setEmprestimo($emprestimo)
		{
			$this->_emprestimo = $emprestimo;
			return $this;
		}
		
		public function getDataPrevista()
		{
			return $this->_data_prevista;
		}
		
		public function setDataPrevista($data_prevista)
		{
			$this->_data_prevista = $data_prevista;
			return $this;
		}
		
		public function getDataDevolvida()
		{
			return $this->_data_devolvida;
		}
		
		public function setDataDevolvida($data_devolvida)
		{
			$this->_data_devolvida = $data_devolvida;
			return $this;
		}
		
		public function getValorPago()
		{
			return $this->_valor_pago;
		}
		
		public function setValorPago($valor_pago)
		{
			$this->_valor_pago = $valor_pago;
			return $this;
		}
	}
?>