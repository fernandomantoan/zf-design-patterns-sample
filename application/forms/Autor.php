<?php
	class Biblioteca_Form_Autor extends Zend_Form
	{
		public function init()
		{
			require_once APPLICATION_PATH . '/configs/translations/pt_BR.php';
			
			$translate = new Zend_Translate('array', $translationStrings, 'pt');
			$this->setTranslator($translate);
			
			$this->addElementPrefixPath('Biblioteca_Validate', 'Biblioteca/Validate/', 'validate');
			
			$this->setName('autor');
			
			$id = new Zend_Form_Element_Hidden('id');
			
			$nome = new Zend_Form_Element_Text('nome');
			$nome->setLabel('Nome:')
					->setRequired(true)
					->addFilter('StripTags')
					->addFilter('StringTrim')
					->addValidator('NotEmpty');
			
			$biografia = new Zend_Form_Element_Textarea('biografia');
			$biografia->setLabel('Biografia:')
					->setRequired(true)
					->addFilter('StripTags')
					->addFilter('StringTrim')
					->addValidator('NotEmpty');
			
			$submit = new Zend_Form_Element_Submit('submit');
			$submit->setLabel('Salvar')
					->setAttrib('id', 'submitbutton');
			
			$this->addElements(array($id, $nome, $biografia, $submit));
		}
	}