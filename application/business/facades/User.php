<?php

class Library_Business_Facade_User
{
	protected $_mapper;
	
	public function __construct()
	{
		$this->_mapper = new Library_Business_DataMapper_User();
	}
	
	public function listBusiness()
	{
		return $this->_mapper->listAll();
	}
	
	public function addBusiness($data, $form)
	{
		if ($form->isValid($data))
		{
			$login = $form->getValue('login');
			$senha = $form->getValue('senha');
			$nome_real = $form->getValue('nome_real');
			$this->_mapper->add($login, $senha, $nome_real);
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function editBusiness($data, $form)
	{
		if ($form->isValid($data))
		{
			$id = (int) $form->getValue('id');
			$login = $form->getValue('login');
			$senha = $form->getValue('senha');
			$nome_real = $form->getValue('nome_real');
			if (empty($senha))
			{
				$this->_mapper->edit($id, $login, $nome_real);
			}
			else
			{
				$this->_mapper->edit($id, $login, $nome_real, $senha);
			}
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function viewBusiness($id, $array = false)
	{
		if (empty($id))
		{
			return false;
		}
		$model = $this->_mapper->get($id, $array);
		if ($model)
		{
			return $model;
		}
		return false;
	}
	
	public function deleteBusiness($id)
	{
		if (empty($id))
		{
			return false;
		}
		$this->_mapper->delete($id);
		return true;
	}
}