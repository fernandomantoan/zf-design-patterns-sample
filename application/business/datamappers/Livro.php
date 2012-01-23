<?php
	class Biblioteca_Business_DataMapper_Livro
	{
		protected $_dbTable;
		
		public function __construct()
		{
			$this->setDbTable(new Biblioteca_Business_DbTable_Livro());
		}
		
		private function setDbTable(Biblioteca_Business_DbTable_Livro $dbtable)
		{
			$this->_dbTable = $dbtable;
		}
		
		private function getDbTable()
		{
			return $this->_dbTable;
		}
		
		public function add($isbn, $editora_id, $autor_id, $titulo, $paginas, $ano, $resenha)
		{
			$data = array(
					'isbn' => $isbn,
					'editora_id' => $editora_id,
					'autor_id' => $autor_id,
					'titulo' => $titulo,
					'paginas' => $paginas,
					'ano' => $ano,
					'resenha' => $resenha
			);
			$this->getDbTable()->insert($data);
		}
		
		public function edit($isbn, $editora_id, $autor_id, $titulo, $paginas, $ano, $resenha)
		{
			$data = array(
					'editora_id' => $editora_id,
					'autor_id' => $autor_id,
					'titulo' => $titulo,
					'paginas' => $paginas,
					'ano' => $ano,
					'resenha' => $resenha
			);
			$this->getDbTable()->update($data, "isbn = '" . $isbn . "'");
		}
		
		public function delete($isbn)
		{
			$this->getDbTable()->delete("isbn = '" . $isbn . "'");
		}
		
		public function get($isbn, $array = false)
		{
			$row = $this->getDbTable()->fetchRow("isbn = '" .  $isbn . "'");
			if ($row)
			{
				$data = $row->toArray();
				if ($array)
				{
					return $data;
				}
				
				$model = new Biblioteca_Business_Model_Livro();
				
				$editora = $row->findParentRow('Biblioteca_Business_DbTable_Editora');
				$autor = $row->findParentRow('Biblioteca_Business_DbTable_Autor');
				
				$editora_model = new Biblioteca_Business_Model_Editora();
				$editora_model->setId($editora->id)
								->setLocalizacao($editora->localizacao)
								->setNome($editora->nome)
								->setWebsite($editora->website);
				
				$autor_model = new Biblioteca_Business_Model_Autor();
				$autor_model->setId($autor->id)
							->setNome($autor->nome)
							->setBiografia($autor->biografia);
				
				$model->setIsbn($row->isbn)
						->setEditora($editora_model)
						->setAutor($autor_model)
						->setTitulo($row->titulo)
						->setPaginas($row->paginas)
						->setAno($row->ano)
						->setResenha($row->resenha);
				
				return $model;
			}
			return false;
		}
		
		public function listAll()
		{
			$rs = $this->getDbTable()->fetchAll();
			$entries = array();
			foreach ($rs as $linha)
			{
				$model = new Biblioteca_Business_Model_Livro();
				$editora = $linha->findParentRow('Biblioteca_Business_DbTable_Editora');
				$autor = $linha->findParentRow('Biblioteca_Business_DbTable_Autor');
				
				$editora_model = new Biblioteca_Business_Model_Editora();
				$editora_model->setId($editora->id)
								->setLocalizacao($editora->localizacao)
								->setNome($editora->nome)
								->setWebsite($editora->website);
				
				$autor_model = new Biblioteca_Business_Model_Autor();
				$autor_model->setId($autor->id)
							->setNome($autor->nome)
							->setBiografia($autor->biografia);
				
				$model->setIsbn($linha->isbn)
						->setEditora($editora_model)
						->setAutor($autor_model)
						->setTitulo($linha->titulo)
						->setPaginas($linha->paginas)
						->setAno($linha->ano)
						->setResenha($linha->resenha);
				
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