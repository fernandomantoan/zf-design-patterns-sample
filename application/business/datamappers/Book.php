<?php

class Library_Business_DataMapper_Book
{
	protected $_dbTable;

	public function __construct()
	{
		$this->setDbTable(new Library_Business_DbTable_Book());
	}

	private function setDbTable(Library_Business_DbTable_Book $dbtable)
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

			$model = new Library_Business_Model_Book();

			$editora = $row->findParentRow('Library_Business_DbTable_Publisher');
			$autor = $row->findParentRow('Library_Business_DbTable_Author');

			$editora_model = new Library_Business_Model_Publisher();
			$editora_model->setId($editora->id)
							->setLocalizacao($editora->localizacao)
							->setNome($editora->nome)
							->setWebsite($editora->website);

			$autor_model = new Library_Business_Model_Author();
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
			$model = new Library_Business_Model_Book();
			$editora = $linha->findParentRow('Library_Business_DbTable_Publisher');
			$autor = $linha->findParentRow('Library_Business_DbTable_Author');

			$editora_model = new Library_Business_Model_Publisher();
			$editora_model->setId($editora->id)
							->setLocalizacao($editora->localizacao)
							->setNome($editora->nome)
							->setWebsite($editora->website);

			$autor_model = new Library_Business_Model_Author();
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