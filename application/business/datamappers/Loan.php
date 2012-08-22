<?php

class Library_Business_DataMapper_Loan
{
	protected $_dbTable;
	
	public function __construct()
	{
		$this->setDbTable(new Library_Business_DbTable_Loan());
		$this->getDbTable()->attachObserver("FernandoMantoan_DesignPatterns_Observer_Observer");
	}
	
	private function setDbTable(Library_Business_DbTable_Loan $dbtable)
	{
		$this->_dbTable = $dbtable;
	}
	
	private function getDbTable()
	{
		return $this->_dbTable;
	}
	
	public function add($loanDate, $memberId, $valor_juros)
	{
		$data = array(
				'data_emprestimo' => $loanDate,
				'membro_id' => $memberId,
				'valor_juros' => $valor_juros
		);
		$id = $this->getDbTable()->insert($data);
		return $id;
	}
	
	public function edit($id, $name, $biografia)
	{
		$data = array(
				'nome' => $name,
				'biografia' => $biografia
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
		if ($row)
		{
			$membro = $row->findParentRow('Library_Business_DbTable_Member')->toArray();
			$data = $row->toArray();
			
			if ($array)
			{
				array_push($data, array('membro' => $membro));
				return $data;
			}
			
			$model = new Library_Business_Model_Loan();
			$model_membro = new Library_Business_Model_Member();
			$model_membro->setId($membro['id'])
							->setEndereco($membro['endereco'])
							->setNome($membro['nome'])
							->setTelefone($membro['telefone']);
			$model->setId($data['id'])
					->setMembro($model_membro)
					->setDataEmprestimo($data['data_emprestimo'])
					->setValorJuros($data['valor_juros']);
			
			return $model;
		}
		return false;
	}
		
	public function listAll()
	{
		$rs = $this->getDbTable()->fetchAll();
		$entries = array();
		foreach ($rs as $row)
		{
			$model = new Library_Business_Model_Loan();
			
			$membro = $row->findParentRow('Library_Business_DbTable_Member');
			$membro_model = new Library_Business_Model_Member();
			$membro_model->setId($membro->id)
							->setNome($membro->nome)
							->setEndereco($membro->endereco)
							->setTelefone($membro->telefone);
			
			$model->setId($row->id)
					->setMembro($membro_model)
					->setDataEmprestimo($row->data_emprestimo)
					->setValorJuros($row->valor_juros);
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