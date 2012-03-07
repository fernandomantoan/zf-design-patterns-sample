<?php

/**
 * Implementation of the Factory design pattern, using a 
 * very simple approach. Creates a new Facade instance 
 * based on constants passed to createInstance.
 * 
 * @author fernando
 */
class FactoryFacade
{
	const FACADE_PUBLISHER = 1;
	const FACADE_AUTHOR = 2;
	const FACADE_BOOK = 3;
	const FACADE_LOAN = 4;
	const FACADE_USER = 5;
	const FACADE_MEMBER = 6;
	const FACADE_AUTH = 7;

	public static function createInstance($facade)
	{
		switch ($facade) {
			case self::FACADE_PUBLISHER:
				return new Biblioteca_Business_Facade_Editora();
			break;
			case self::FACADE_AUTHOR:
				return new Biblioteca_Business_Facade_Autor();
			break;
			case self::FACADE_BOOK:
				return new Biblioteca_Business_Facade_Livro();
			break;
			case self::FACADE_LOAN:
				return new Biblioteca_Business_Facade_Emprestimo();
			break;
			case self::FACADE_USER:
				return new Biblioteca_Business_Facade_Usuario();
			break;
			case self::FACADE_MEMBER:
				return new Biblioteca_Business_Facade_Membro();
			break;
			case self::FACADE_AUTH:
				return new Biblioteca_Business_Facade_Auth();
			break;
			default:
				throw new Exception('The facade specified is invalid.');
			break;
		}
	}
}