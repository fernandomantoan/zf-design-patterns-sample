<?php

class Library_Business_DataMapper_Publisher
{
	protected $_dbTable;

	public function __construct()
	{
		$this->setDbTable(new Library_Business_DbTable_Publisher());
	}

	private function setDbTable(Library_Business_DbTable_Publisher $dbtable)
	{
		$this->_dbTable = $dbtable;
	}

	private function getDbTable()
	{
		return $this->_dbTable;
	}

	public function add($nome, $localizacao, $website)
	{
		$data = array(
				'nome' => $nome,
				'localizacao' => $localizacao,
				'website' => $website
		);
		$this->getDbTable()->insert($data);
	}

	public function edit($id, $nome, $localizacao, $website)
	{
		$data = array(
				'nome' => $nome,
				'localizacao' => $localizacao,
				'website' => $website
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
			$model = new Library_Business_Model_Publisher();
			$model->setId($data['id'])
					->setLocalizacao($data['localizacao'])
					->setNome($data['nome'])
					->setWebsite($data['website']);
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
			$model = new Library_Business_Model_Publisher();
			$model->setId($row->id)
					->setLocalizacao($row->localizacao)
					->setNome($row->nome)
					->setWebsite($row->website);
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