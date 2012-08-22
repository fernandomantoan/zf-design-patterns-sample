<?php

class Library_Business_DataMapper_User
{
	protected $_dbTable;
	
	public function __construct()
	{
		$this->setDbTable(new Library_Business_DbTable_User());
	}
	
	private function setDbTable(Library_Business_DbTable_User $dbtable)
	{
		$this->_dbTable = $dbtable;
	}
	
	private function getDbTable()
	{
		return $this->_dbTable;
	}
	
	public function add($login, $senha, $nome_real)
	{
		$data = array(
				'login' => $login,
				'senha' => sha1($senha),
				'nome_real' => $nome_real
		);
		$this->getDbTable()->insert($data);
	}
	
	public function edit($id, $login, $nome_real, $senha = null)
	{
		$data = array(
				'login' => $login,
				'nome_real' => $nome_real
		);
		if (!is_null($senha))
		{
			$data['senha'] = sha1($senha);
		}
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
			$model = new Library_Business_Model_User();
			$model->setId($data['id'])
					->setLogin($data['login'])
					->setNomeReal($data['nome_real']);
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
			$model = new Library_Business_Model_User();
			$model->setId($row->id)
					->setLogin($row->login)
					->setNomeReal($row->nome_real);
			$entries[] = $model;
		}
		return $entries;
	}
}