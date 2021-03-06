<?php

class Library_Business_DataMapper_LoanItem
{
	protected $_dbTable;
	
	public function __construct()
	{
		$this->setDbTable(new Library_Business_DbTable_LoanItem());
	}
	
	private function setDbTable(Library_Business_DbTable_LoanItem $dbtable)
	{
		$this->_dbTable = $dbtable;
	}
	
	private function getDbTable()
	{
		return $this->_dbTable;
	}
	
	public function add($emprestimo_id, $data_prevista, $livro_isbn)
	{
		$data = array(
				'emprestimo_id' => $emprestimo_id,
				'data_prevista' => $data_prevista,
				'livro_isbn' => $livro_isbn,
				'valor_pago' => 0
		);
		$this->getDbTable()->insert($data);
	}
	
	public function devolucao($id, $data_devolvida, $valor_pago)
	{
		$data = array(
				'data_devolvida' => $data_devolvida,
				'valor_pago' => (float) $valor_pago
		);
		$this->getDbTable()->update($data, 'id = ' . (int) $id);
	}
	
	public function delete($id)
	{
		$this->getDbTable()->delete('id = ' . (int) $id);
	}
	
	public function get($id, $array = false)
	{
		$row = $this->getDbTable()->fetchRow('id = ' . (int) $id);
		if ($row) {
			$emprestimo = $row->findParentRow('Library_Business_DbTable_Loan');
			$membro = $emprestimo->findParentRow('Library_Business_DbTable_Member')->toArray();
			$emprestimo = $emprestimo->toArray();
			
			$livro = $row->findParentRow('Library_Business_DbTable_Book')->toArray();
			
			$data = $row->toArray();
			if ($array)
				return $data;
			
			$livro_model = new Library_Business_Model_Book();
			$livro_model->setIsbn($livro['isbn'])
							->setTitulo($livro['titulo']);
			
			$membro_model = new Library_Business_Model_Member();
			$membro_model->setId($membro['id'])
							->setNome($membro['nome'])
							->setEndereco($membro['endereco'])
							->setTelefone($membro['telefone']);
			
			$emprestimo_model = new Library_Business_Model_Loan();
			$emprestimo_model->setId($emprestimo['id'])
								->setDataEmprestimo($emprestimo['data_emprestimo'])
								->setValorJuros($emprestimo['valor_juros'])
								->setMembro($membro_model);
			
			$model = new Library_Business_Model_LoanItem();
			$model->setId($data['id'])
					->setDataDevolvida($data['data_devolvida'])
					->setDataPrevista($data['data_prevista'])
					->setEmprestimo($emprestimo_model)
					->setLivro($livro_model)
					->setValorPago($data['valor_pago']);
			
			return $model;
		}
		return false;
	}
	
	public function getByIsbn($isbn)
	{
		$row = $this->getDbTable()->fetchRow("livro_isbn = '$isbn'");
		if ($row) {
			$model = new Library_Business_Model_LoanItem();
			$model->setId($row->id)
					->setDataDevolvida($row->data_devolvida)
					->setDataPrevista($row->data_prevista)
					->setValorPago($row->valor_pago);
			
			return $model;
		}
		return false;
	}
	
	public function listAll($emprestimo_id)
	{
		$rs = $this->getDbTable()->fetchAll('emprestimo_id = ' . (int) $emprestimo_id);
		$entries = array();
		foreach ($rs as $row) {
			$model = new Library_Business_Model_LoanItem();
			
			$livro = $row->findParentRow('Library_Business_DbTable_Book');
			$livro_model = new Library_Business_Model_Book();
			$livro_model->setIsbn($livro->isbn)
							->setTitulo($livro->titulo);
			
			$model->setId($row->id)
					->setLivro($livro_model)
					->setDataPrevista($row->data_prevista)
					->setDataDevolvida($row->data_devolvida)
					->setValorPago($row->valor_pago);
			$entries[] = $model;
		}
		return $entries;
	}
	
	public function listSelect()
	{
		$rs = $this->getDbTable()->fetchAll()->toArray();
		return $rs;
	}
}