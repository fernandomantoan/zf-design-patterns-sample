<?php
	class Biblioteca_Form_DevolverItem extends Zend_Form
	{
		public function init()
		{
			require_once APPLICATION_PATH . '/configs/translations/pt_BR.php';
			
			$translate = new Zend_Translate('array', $translationStrings, 'pt');
			$this->setTranslator($translate);
			
			$this->addElementPrefixPath('Biblioteca_Validate', 'Biblioteca/Validate/', 'validate');
			
			$this->setName('devolveritem');
			$this->setAttrib('id', 'devolveritem');
			
			$id = new Zend_Form_Element_Hidden('id');
			
			$data_devolvida = new Zend_Form_Element_Text('data_devolvida');
			$data_devolvida->setLabel('Data de Devolução:')
					->setRequired(true)
					->setAttrib('id', 'data_devolvida')
					->addFilter('StripTags')
					->addFilter('StringTrim')
					->addValidator('NotEmpty')
					->addValidator('Date')
					->setAttrib('maxlength', 10);
			
			
			$valor_pago = new Zend_Form_Element_Text('valor_pago');
			$valor_pago->setLabel('Valor Pago: R$')
					->setRequired(true)
					->setAttrib('id', 'valor_pago')
					->addFilter('StripTags')
					->addFilter('StringTrim')
					->addValidator('NotEmpty')
					->addValidator('Float')
					->setAttrib('readonly', 'readonly');
			
			$submit = new Zend_Form_Element_Submit('submit');
			$submit->setLabel('Devolver Item')
					->setAttrib('id', 'submitbutton')
					->setAttrib('disabled', 'disabled');
			
			$this->addElements(array($id, $data_devolvida, $valor_pago, $submit));
		}
	}
?>