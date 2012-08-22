<?php

class Library_Business_DbTable_Publisher extends Zend_Db_Table_Abstract
{
	protected $_name = 'editora';
	protected $_dependentTables = array('Library_Business_DbTable_Book');
}