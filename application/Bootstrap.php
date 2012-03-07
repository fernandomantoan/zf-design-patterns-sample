<?php
require_once 'FactoryFacade.php';

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initAutoload()
	{
		$autoloader = new Zend_Application_Module_Autoloader(array(
			'basePath' => dirname(__FILE__),
			'namespace' => 'Biblioteca_'
		));
		$autoloader->removeResourceType('dbtable');
		$autoloader->removeResourceType('model');
		$autoloader->addResourceType('facade', 'business/facades', 'Business_Facade');
		$autoloader->addResourceType('datamapper', 'business/datamappers', 'Business_DataMapper');
		$autoloader->addResourceType('dbtable', 'business/dbtable', 'Business_DbTable');
		$autoloader->addResourceType('model', 'business/models', 'Business_Model');
		return $autoloader;
	}
	
	protected function _initDoctype()
	{
		$this->bootstrap('layout');
		$layout = $this->getResource('layout');
		$view = $layout->getView();
		
		$view->addHelperPath(APPLICATION_PATH . '/views/helpers', 'Zend_View_Helper');
		$view->doctype('XHTML1_STRICT');
		$view->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=UTF-8');
		$view->headTitle()->setSeparator(' | ');
		$view->headTitle('Biblioteca');
	}
	
	protected function _initDatabaseAdapter()
	{
		$this->bootstrap('db');
		$db = $this->getResource('db');
		$db->query("SET NAMES 'utf8'");
	}
}