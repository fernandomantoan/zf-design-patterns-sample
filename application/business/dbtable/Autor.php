<?php
	class Biblioteca_Business_DbTable_Autor extends Zend_Db_Table_Abstract
	{
		protected $_name = 'autor';
		protected $_dependentTables = array('Biblioteca_Business_DbTable_Livro');
	}