<?php
/**
 * Observer class, logs the data notified by observables.
 * 
 * @author fernando
 * @version 1.0
 */
class FernandoMantoan_DesignPatterns_Observer_Observer
{
	protected $_data;
	protected $_logger;
	
	protected function setLogger(Zend_Log $logger)
	{
		$this->_logger = $logger;
	}
	
	protected function getLogger()
	{
		return $this->_logger;
	}
	
	protected function setData($data)
	{
		$this->_data = $data;
	}
	
	protected function getData()
	{
		return $this->_data;
	}
	
	public function observeTable($event, $class)
	{
		$this->createData($event, $class);
		$this->initLog();
		$this->logMessage();
	}
	
	protected function initLog()
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$columns = $this->parseColumns();
		$writer = new Zend_Log_Writer_Db($db, 'historico', $columns);
		$this->setLogger(new Zend_Log($writer));
	}
	
	protected function createData($event, $class)
	{
		$data = array();
		$data['operacao'] = ($event == 'insert') ? "Novo" : "Atualização";
		if ($event != 'delete') {
			foreach ($class->data as $key => $value) {
				$data[$key] = $value;
			}
		} else {
			$data['operacao'] = "Exclusão";
		}
		
		if ($event != 'insert') {
			$where = explode('=', $class->where);
			$data['id'] = trim($where[1]);
		}
		$usuario = Zend_Auth::getInstance()->getIdentity();
		$data['efetuado_por'] = $usuario->id;
		$this->setData(Zend_Json::encode($data));
	}
	
	protected function parseColumns()
	{
		$columns = array('prioridade' => 'priority', 'mensagem' => 'message');
		return $columns;
	}
	
	protected function logMessage()
	{
		$this->getLogger()->info($this->getData());
	}
}