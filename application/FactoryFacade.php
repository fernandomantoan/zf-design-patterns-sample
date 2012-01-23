<?php
	class FactoryFacade
	{
		const FACADE_EDITORA = 1;
		const FACADE_AUTOR = 2;
		const FACADE_LIVRO = 3;
		const FACADE_EMPRESTIMO = 4;
		const FACADE_USUARIO = 5;
		const FACADE_MEMBRO = 6;
		const FACADE_AUTH = 7;
		
		public static function obterFacade($facade)
		{
			switch ($facade)
			{
				case self::FACADE_EDITORA:
					return new Biblioteca_Business_Facade_Editora();
				break;
				case self::FACADE_AUTOR:
					return new Biblioteca_Business_Facade_Autor();
				break;
				case self::FACADE_LIVRO:
					return new Biblioteca_Business_Facade_Livro();
				break;
				case self::FACADE_EMPRESTIMO:
					return new Biblioteca_Business_Facade_Emprestimo();
				break;
				case self::FACADE_USUARIO:
					return new Biblioteca_Business_Facade_Usuario();
				break;
				case self::FACADE_MEMBRO:
					return new Biblioteca_Business_Facade_Membro();
				break;
				case self::FACADE_AUTH:
					return new Biblioteca_Business_Facade_Auth();
				break;
				default:
					throw new Exception('Facade inválida!');
				break;
			}
		}
	}
?>