<?php

class Library_Form_LoanItem extends Zend_Form
{
	private $edit = false;
	
	public function __construct($options = null)
	{
		if (isset($options['editar']))
		{
			$this->edit = $options['editar'];
			unset($options['editar']);
		}
		
		parent::__construct($options);
	}
	
	public function init()
	{
		require_once APPLICATION_PATH . '/configs/translations/pt_BR.php';
		
		$translate = new Zend_Translate('array', $translationStrings, 'pt');
		$this->setTranslator($translate);
		
		$this->addElementPrefixPath('FernandoMantoan_Validate', 'FernandoMantoan/Validate/', 'validate');
		
		$this->setName('itememprestimo');
		
		$id = new Zend_Form_Element_Hidden('id');
		
		$emprestimo_id = new Zend_Form_Element_Hidden('emprestimo_id');
		
		$data_prevista = new Zend_Form_Element_Text('data_prevista');
		$data_prevista->setLabel('Data para Devolução:')
				->setRequired(true)
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('NotEmpty')
				->addValidator('Date');
		
		$livroFacade = FernandoMantoan_DesignPatterns_Factory_FactoryFacade::createInstance(FernandoMantoan_DesignPatterns_Factory_FactoryFacade::FACADE_BOOK);
		$livros_options = $livroFacade->htmlselectBusiness();
		$livro_isbn = new Zend_Form_Element_Select('livro_isbn');
		
		$livro_isbn->addMultiOption('', 'Escolha um Livro');
		
		if (sizeof($livros_options) > 0)
		{
			foreach ($livros_options as $livro)
			{
				$livro_isbn->addMultiOption($livro['isbn'], $livro['titulo']);
			}
		}
		
		$livro_isbn->setLabel('Livro:')
					->setRequired(true)
					->addFilter('StripTags')
					->addFilter('StringTrim')
					->addValidator('NotEmpty');
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Adicionar Item')
				->setAttrib('id', 'submitbutton');
		
		$this->addElements(array($id, $emprestimo_id, $data_prevista, $livro_isbn, $submit));
	}
}