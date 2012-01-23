<?php
	class Biblioteca_Form_Login extends Zend_Form
	{
		public function init()
		{
			require_once APPLICATION_PATH . '/configs/translations/pt_BR.php';
			
			$translate = new Zend_Translate('array', $translationStrings, 'pt');
			$this->setTranslator($translate);
			
			$this->addElementPrefixPath('Biblioteca_Validate', 'Biblioteca/Validate/', 'validate');
			
			$this->setName('login');
			
			$id = new Zend_Form_Element_Hidden('id');
			
			$login = new Zend_Form_Element_Text('login');
			$login->setLabel('Login:')
					->setRequired(true)
					->addFilter('StripTags')
					->addFilter('StringTrim')
					->addValidator('NotEmpty');
			
			$senha = new Zend_Form_Element_Password('senha');
			$senha->setLabel('Senha:')
					->setRequired(true)
					->addFilter('StripTags')
					->addFilter('StringTrim')
					->addValidator('NotEmpty');
			
			$submit = new Zend_Form_Element_Submit('submit');
			$submit->setLabel('Logar')
					->setAttrib('id', 'submitbutton');
			
			$this->addElements(array($id, $login, $senha, $submit));
		}
	}
?>