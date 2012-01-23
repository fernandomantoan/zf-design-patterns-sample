<?php
	class Biblioteca_Form_Livro extends Zend_Form
	{
		private $editar = false;
		
		public function __construct($options = null)
		{
			if (isset($options['editar']))
			{
				$this->editar = $options['editar'];
				unset($options['editar']);
			}
			
			parent::__construct($options);
		}
		
		public function init()
		{
			require_once APPLICATION_PATH . '/configs/translations/pt_BR.php';
			
			$translate = new Zend_Translate('array', $translationStrings, 'pt');
			$this->setTranslator($translate);
			
			$this->addElementPrefixPath('Biblioteca_Validate', 'Biblioteca/Validate/', 'validate');
			
			$this->setName('livro');
			
			$isbn = new Zend_Form_Element_Text('isbn');
			$isbn->setLabel('ISBN:')
					->setRequired(true)
					->addFilter('StripTags')
					->addFilter('StringTrim')
					->addValidator('NotEmpty');
			
			if ($this->editar === false)
			{
				$isbn->addValidator(new Zend_Validate_Db_NoRecordExists('livro', 'isbn'));
			}
			else
			{
				$isbn->setAttrib('readonly', 'readonly');
			}
			
			$editoraFacade = new Biblioteca_Business_Facade_Editora();
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
			
			$autorFacade = new Biblioteca_Business_Facade_Autor();
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