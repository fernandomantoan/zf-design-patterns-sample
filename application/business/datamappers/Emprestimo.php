<?php
	class Biblioteca_Business_DataMapper_Emprestimo
	{
		protected $_dbTable;
		
		public function __construct()
		{
			$this->setDbTable(new Biblioteca_Business_DbTable_Emprestimo());
			$this->getDbTable()->attachObserver("BibliotecaUtils_Observer_Observer");
		}
		
		private function setDbTable(Biblioteca_Business_DbTable_Emprestimo $dbtable)
		{
			$this->_dbTable = $dbtable;
		}
		
		private function getDbTable()
		{
			return $this->_dbTable;
		}
		
		public function add($data_emprestimo, $membro_id, $valor_juros)
		{
			$data = array(
					'data_emprestimo' => $data_emprestimo,
					'membro_id' => $membro_id,
					'valor_juros' => $valor_juros
			);
			$id = $this->getDbTable()->insert($data);
			return $id;
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
				$membro = $row->findParentRow('Biblioteca_Business_DbTable_Membro')->toArray();
				$data = $row->toArray();
				
				if ($array)
				{
					array_push($data, array('membro' => $membro));
					return $data;
				}
				
				$model = new Biblioteca_Business_Model_Emprestimo();
				$model_membro = new Biblioteca_Business_Model_Membro();
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
				$model = new Biblioteca_Business_Model_Emprestimo();
				
				$membro = $row->findParentRow('Biblioteca_Business_DbTable_Membro');
				$membro_model = new Biblioteca_Business_Model_Membro();
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
?>