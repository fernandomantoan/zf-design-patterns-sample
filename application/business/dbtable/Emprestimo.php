<?php
	class Biblioteca_Business_DbTable_Emprestimo extends BibliotecaUtils_Observer_Observable
	{
		protected $_name = 'emprestimo';
		protected $_referenceMap = array(
			'Membro' => array(
				'columns' => array('membro_id'),
				'refTableClass' => 'Biblioteca_Business_DbTable_Membro',
				'refColumns' => 'id'
			)
		);
	}