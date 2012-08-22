<?php

class Library_Form_Member extends Zend_Form
{
	public function init()
	{
		require_once APPLICATION_PATH . '/configs/translations/pt_BR.php';
		
		$translate = new Zend_Translate('array', $translationStrings, 'pt');
		$this->setTranslator($translate);
		
		$this->addElementPrefixPath('FernandoMantoan_Validate', 'FernandoMantoan/Validate/', 'validate');
		
		$this->setName('membro');
		
		$id = new Zend_Form_Element_Hidden('id');
		
		$nome = new Zend_Form_Element_Text('nome');
		$nome->setLabel('Nome:')
				->setRequired(true)
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('NotEmpty');
		
		$endereco = new Zend_Form_Element_Text('endereco');
		$endereco->setLabel('Endereço:')
				->setRequired(true)
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('NotEmpty');
		
		$telefone = new Zend_Form_Element_Text('telefone');
		$telefone->setLabel('Telefone:')
				->setRequired(true)
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('NotEmpty')
				->addValidator('Digits')
				->setAttrib('maxlength', 8);
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Salvar')
				->setAttrib('id', 'submitbutton');
		
		$this->addElements(array($id, $nome, $endereco, $telefone, $submit));
	}
}