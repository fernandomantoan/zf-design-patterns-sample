<?php
	class Biblioteca_Form_Editora extends Zend_Form
	{
		public function init()
		{
			require_once APPLICATION_PATH . '/configs/translations/pt_BR.php';
			
			$translate = new Zend_Translate('array', $translationStrings, 'pt');
			$this->setTranslator($translate);
			
			$this->addElementPrefixPath('BibliotecaUtils_Validate', 'BibliotecaUtils/Validate/', 'validate');
			
			$this->setName('editora');
			
			$id = new Zend_Form_Element_Hidden('id');
			
			$nome = new Zend_Form_Element_Text('nome');
			$nome->setLabel('Nome:')
					->setRequired(true)
					->addFilter('StripTags')
					->addFilter('StringTrim')
					->addValidator('NotEmpty');
			
			$localizacao = new Zend_Form_Element_Text('localizacao');
			$localizacao->setLabel('Localização:')
					->setRequired(true)
					->addFilter('StripTags')
					->addFilter('StringTrim')
					->addValidator('NotEmpty');
			
			$website = new Zend_Form_Element_Text('website');
			$website->setLabel('Website:')
					->setRequired(true)
					->addFilter('StripTags')
					->addFilter('StringTrim')
					->addValidator('NotEmpty')
					->addValidator('Url');
			
			$submit = new Zend_Form_Element_Submit('submit');
			$submit->setLabel('Salvar')
					->setAttrib('id', 'submitbutton');
			
			$this->addElements(array($id, $nome, $localizacao, $website, $submit));
		}
	}