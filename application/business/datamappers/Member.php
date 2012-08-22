<?php

class Library_Business_DataMapper_Member
{
	protected $_dbTable;

	public function __construct()
	{
		$this->setDbTable(new Library_Business_DbTable_Member());
	}

	private function setDbTable(Library_Business_DbTable_Member $dbtable)
	{
		$this->_dbTable = $dbtable;
	}

	private function getDbTable()
	{
		return $this->_dbTable;
	}

	public function add($name, $address, $telephone)
	{
		$data = array(
				'nome' => $name,
				'endereco' => $address,
				'telefone' => $telephone
		);
		$this->getDbTable()->insert($data);
	}

	public function edit($id, $name, $address, $telephone)
	{
		$data = array(
				'nome' => $name,
				'endereco' => $address,
				'telefone' => $telephone
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
			$data = $row->toArray();
			if ($array)
			{
				return $data;
			}
			$model = new Library_Business_Model_Member();
			$model->setId($data['id'])
					->setNome($data['nome'])
					->setEndereco($data['endereco'])
					->setTelefone($data['telefone']);
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
			$model = new Library_Business_Model_Member();
			$model->setId($row->id)
					->setNome($row->nome)
					->setEndereco($row->endereco)
					->setTelefone($row->telefone);
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