<?php

class Library_Form_Loan extends Zend_Form
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

		$this->setName('emprestimo');

		$id = new Zend_Form_Element_Hidden('id');

		$data_emprestimo = new Zend_Form_Element_Text('data_emprestimo');
		$data_emprestimo->setLabel('Data do Empréstimo:')
				->setRequired(true)
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('NotEmpty')
				->addValidator('Date');

		$membroFacade = FernandoMantoan_DesignPatterns_Factory_FactoryFacade::createInstance(
			FernandoMantoan_DesignPatterns_Factory_FactoryFacade::FACADE_MEMBER);
		$membros_options = $membroFacade->htmlselectBusiness();
		$membro_id = new Zend_Form_Element_Select('membro_id');

		$membro_id->addMultiOption('', 'Escolha um Membro');

		if (sizeof($membros_options) > 0)
		{
			foreach ($membros_options as $membro)
			{
				$membro_id->addMultiOption($membro['id'], $membro['nome']);
			}
		}

		$membro_id->setLabel('Membro:')
					->setRequired(true)
					->addFilter('StripTags')
					->addFilter('StringTrim')
					->addValidator('NotEmpty');

		$valor_juros = new Zend_Form_Element_Text('valor_juros');
		$valor_juros->setLabel('Valor do Juros: R$')
				->setRequired(true)
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('NotEmpty')
				->addValidator('Float');

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Salvar')
				->setAttrib('id', 'submitbutton');

		$this->addElements(array($id, $data_emprestimo, $membro_id, $valor_juros, $submit));
	}
}