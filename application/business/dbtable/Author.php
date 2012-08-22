<?php

class Library_Business_DbTable_Author extends Zend_Db_Table_Abstract
{
	protected $_name = 'autor';
	protected $_dependentTables = array('Library_Business_DbTable_Book');
}