<?php

class Library_Business_Model_User
{
	private $_id;
	private $_login;
	private $_senha;
	private $_nome_real;
	
	public function getId()
	{
		return $this->_id;
	}
	
	public function setId($id)
	{
		$this->_id = $id;
		return $this;
	}

	public function getLogin()
	{
		return $this->_login;
	}
	
	public function setLogin($login)
	{
		$this->_login = $login;
		return $this;
	}

	public function getSenha()
	{
		return $this->_senha;
	}
	
	public function setSenha($senha)
	{
		$this->_senha = $senha;
		return $this;
	}

	public function getNomeReal()
	{
		return $this->_nome_real;
	}
	
	public function setNomeReal($nome_real)
	{
		$this->_nome_real = $nome_real;
		return $this;
	}
}