<?php

class Library_Business_DbTable_Loan extends FernandoMantoan_DesignPatterns_Observer_Observable
{
	protected $_name = 'emprestimo';
	protected $_referenceMap = array(
		'Membro' => array(
			'columns' => array('membro_id'),
			'refTableClass' => 'Library_Business_DbTable_Member',
			'refColumns' => 'id'
		)
	);
}