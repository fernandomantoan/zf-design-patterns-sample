<?php
	class Biblioteca_Form_LivrosSelect extends Zend_Form_Element_Select
	{
		public function init()
		{
			$livroFacade = new Biblioteca_Business_Facade_Livro();
			$livros_options = $livroFacade->htmlselectBusiness();
			
			$this->addMultiOption('', 'Escolha um Livro');
			
			if (sizeof($livros_options) > 0)
			{
				foreach ($livros_options as $livro)
				{
					$this->addMultiOption($livro['isbn'], $livro['titulo']);
				}
			}
			
			$this->setName('livro_isbn');
		}
	}