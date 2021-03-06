<?php

class Library_Form_User extends Zend_Form
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
		
		$this->setName('autor');
		
		$id = new Zend_Form_Element_Hidden('id');
		
		$login = new Zend_Form_Element_Text('login');
		$login->setLabel('Login:')
				->setRequired(true)
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('NotEmpty')
				->setAttrib('maxlength', 10);
		
		$senha = new Zend_Form_Element_Password('senha');
		$senha->setLabel('Senha:')
				->addFilter('StripTags')
				->addFilter('StringTrim');
		
		if (!$this->edit)
		{
			$senha->setRequired(true)
					->addValidator('NotEmpty');
		}
		
		$nome_real = new Zend_Form_Element_Text('nome_real');
		$nome_real->setLabel('Nome Real:')
				->setRequired(true)
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('NotEmpty');
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Salvar')
				->setAttrib('id', 'submitbutton');
		
		$this->addElements(array($id, $login, $senha, $nome_real, $submit));
	}
}