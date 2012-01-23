<?php
	class Biblioteca_Business_DbTable_ItemEmprestimo extends BibliotecaUtils_Observer_Observable
	{
		protected $_name = 'item_emprestimo';
		protected $_referenceMap = array(
			'Emprestimo' => array(
				'columns' => array('emprestimo_id'),
				'refTableClass' => 'Biblioteca_Business_DbTable_Emprestimo',
				'refColumns' => 'id'
			),
			'Livro' => array(
				'columns' => array('livro_isbn'),
				'refTableClass' => 'Biblioteca_Business_DbTable_Livro',
				'refColumns' => 'isbn'
			),
		);
	}