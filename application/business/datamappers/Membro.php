<?php
	class Biblioteca_Business_DataMapper_Membro
	{
		protected $_dbTable;
		
		public function __construct()
		{
			$this->setDbTable(new Biblioteca_Business_DbTable_Membro());
		}
		
		private function setDbTable(Biblioteca_Business_DbTable_Membro $dbtable)
		{
			$this->_dbTable = $dbtable;
		}
		
		private function getDbTable()
		{
			return $this->_dbTable;
		}
		
		public function add($nome, $endereco, $telefone)
		{
			$data = array(
					'nome' => $nome,
					'endereco' => $endereco,
					'telefone' => $telefone
			);
			$this->getDbTable()->insert($data);
		}
		
		public function edit($id, $nome, $endereco, $telefone)
		{
			$data = array(
					'nome' => $nome,
					'endereco' => $endereco,
					'telefone' => $telefone
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
				$model = new Biblioteca_Business_Model_Membro();
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
				$model = new Biblioteca_Business_Model_Membro();
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