<?php

class Library_Business_DbTable_LoanItem extends FernandoMantoan_DesignPatterns_Observer_Observable
{
	protected $_name = 'item_emprestimo';
	protected $_referenceMap = array(
		'Emprestimo' => array(
			'columns' => array('emprestimo_id'),
			'refTableClass' => 'Library_Business_DbTable_Loan',
			'refColumns' => 'id'
		),
		'Livro' => array(
			'columns' => array('livro_isbn'),
			'refTableClass' => 'Library_Business_DbTable_Book',
			'refColumns' => 'isbn'
		),
	);
}