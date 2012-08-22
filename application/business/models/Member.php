<?php

class Library_Business_Model_Member
{
	private $_id;
	private $_nome;
	private $_endereco;
	private $_telefone;
	
	public function getId()
	{
		return $this->_id;
	}
	
	public function setId($id)
	{
		$this->_id = $id;
		return $this;
	}

	public function getNome()
	{
		return $this->_nome;
	}
	
	public function setNome($nome)
	{
		$this->_nome = $nome;
		return $this;
	}

	public function getEndereco()
	{
		return $this->_endereco;
	}
	
	public function setEndereco($endereco)
	{
		$this->_endereco = $endereco;
		return $this;
	}

	public function getTelefone()
	{
		return $this->_telefone;
	}
	
	public function setTelefone($telefone)
	{
		$this->_telefone = $telefone;
		return $this;
	}
}