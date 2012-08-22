<?php

class Library_Business_DataMapper_Author
{
	protected $_dbTable;

	public function __construct()
	{
		$this->setDbTable(new Library_Business_DbTable_Author());
	}

	private function setDbTable(Library_Business_DbTable_Author $dbtable)
	{
		$this->_dbTable = $dbtable;
	}

	private function getDbTable()
	{
		return $this->_dbTable;
	}

	public function add($nome, $biografia)
	{
		$data = array(
				'nome' => $nome,
				'biografia' => $biografia
		);
		$this->getDbTable()->insert($data);
	}

	public function edit($id, $nome, $biografia)
	{
		$data = array(
				'nome' => $nome,
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
			$data = $row->toArray();
			if ($array)
			{
				return $data;
			}
			$model = new Library_Business_Model_Author();
			$model->setId($data['id'])
					->setNome($data['nome'])
					->setBiografia($data['biografia']);
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
			$model = new Library_Business_Model_Author();
			$model->setId($row->id)
					->setNome($row->nome)
					->setBiografia($row->biografia);
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