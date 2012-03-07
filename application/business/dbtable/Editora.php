<?php
	class Biblioteca_Business_DbTable_Editora extends Zend_Db_Table_Abstract
	{
		protected $_name = 'editora';
		protected $_dependentTables = array('Biblioteca_Business_DbTable_Livro');
	}