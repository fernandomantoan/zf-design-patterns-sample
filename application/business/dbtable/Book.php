<?php

class Library_Business_DbTable_Book extends Zend_Db_Table_Abstract
{
	protected $_name = 'livro';
	protected $_primary = 'isbn';
	protected $_referenceMap = array(
		'Autor' => array(
			'columns' => array('autor_id'),
			'refTableClass' => 'Library_Business_DbTable_Author',
			'refColumns' => 'id'
		),
		'Editora' => array(
			'columns' => array('editora_id'),
			'refTableClass' => 'Library_Business_DbTable_Publisher',
			'refColumns' => 'id'
		),
	);
}