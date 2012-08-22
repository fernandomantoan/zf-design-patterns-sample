<?php

class Library_Form_Book extends Zend_Form
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

		$this->setName('livro');

		$isbn = new Zend_Form_Element_Text('isbn');
		$isbn->setLabel('ISBN:')
				->setRequired(true)
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('NotEmpty');

		if ($this->edit === false)
		{
			$isbn->addValidator(new Zend_Validate_Db_NoRecordExists('livro', 'isbn'));
		}
		else
		{
			$isbn->setAttrib('readonly', 'readonly');
		}



		$editoraFacade = FernandoMantoan_DesignPatterns_Factory_FactoryFacade::createInstance(FernandoMantoan_DesignPatterns_Factory_FactoryFacade::FACADE_PUBLISHER);
		$editoras_options = $editoraFacade->htmlselectBusiness();
		$editora_id = new Zend_Form_Element_Select('editora_id');

		$editora_id->addMultiOption('', 'Escolha uma Editora');

		if (sizeof($editoras_options) > 0)
		{
			foreach ($editoras_options as $editora)
			{
				$editora_id->addMultiOption($editora['id'], $editora['nome']);
			}
		}

		$editora_id->setLabel('Editora:')
					->setRequired(true)
					->addFilter('StripTags')
					->addFilter('StringTrim')
					->addValidator('NotEmpty');

		$autorFacade = FernandoMantoan_DesignPatterns_Factory_FactoryFacade::createInstance(FernandoMantoan_DesignPatterns_Factory_FactoryFacade::FACADE_AUTHOR);
		$autores_options = $autorFacade->htmlselectBusiness();
		$autor_id = new Zend_Form_Element_Select('autor_id');

		$autor_id->addMultiOption('', 'Escolha um Autor');

		if (sizeof($autores_options) > 0)
		{
			foreach ($autores_options as $autor)
			{
				$autor_id->addMultiOption($autor['id'], $autor['nome']);
			}
		}

		$autor_id->setLabel('Autor:')
					->setRequired(true)
					->addFilter('StripTags')
					->addFilter('StringTrim')
					->addValidator('NotEmpty');

		$titulo = new Zend_Form_Element_Text('titulo');
		$titulo->setLabel('Título:')
				->setRequired(true)
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('NotEmpty');

		$paginas = new Zend_Form_Element_Text('paginas');
		$paginas->setLabel('Páginas:')
				->setRequired(true)
				->addValidator('NotEmpty')
				->addValidator('Digits');

		$ano = new Zend_Form_Element_Text('ano');
		$ano->setLabel('Ano:')
				->setRequired(true)
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('NotEmpty')
				->addValidator('Digits');

		$resenha = new Zend_Form_Element_Textarea('resenha');
		$resenha->setLabel('Resenha:')
				->setRequired(true)
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('NotEmpty');

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Salvar')
				->setAttrib('id', 'submitbutton');

		$this->addElements(array($isbn, $titulo, $editora_id, $autor_id, $paginas, $ano, $resenha, $submit));
	}
}