<?php
/**
 * Generic class that represents an observable class.
 * 
 * @author fernando
 * @version 1.0
 */
class FernandoMantoan_DesignPatterns_Observer_Observable extends Zend_Db_Table_Abstract
{
	public $data;
	public $where;
	protected static  $_observers = array();
	
	public static function attachObserver($class)
	{
		if (!is_string($class) || !class_exists($class) || !is_callable(array($class, 'observeTable')))
			return false;
		
		if (!isset(self::$_observers[$class]))
			self::$_observers[$class] = true;
		
		return true;
	}
	
	protected function _notifyObservers($event)
	{
		if (!empty(self::$_observers)) {
			foreach (array_keys(self::$_observers) as $observer) {
				$obj_observer = new $observer();
				call_user_func(array($obj_observer, 'observeTable'), $event, $this);
			}
		}
	}
	
	public function insert($data)
	{
		$last_id = parent::insert($data);
		if ($last_id > 0) {
			$this->data = $data;
			$this->data['id'] = $last_id;
			$this->_notifyObservers("insert");
		}
		return $last_id;
	}
	
	public function update($data, $where)
	{
		parent::update($data, $where);
		$this->where = $where;
		$this->data = $data;
		$this->_notifyObservers("update");
	}
	
	public function delete($where)
	{
		$this->where = $where;
		$last_id = parent::delete($this->where);
		if ($last_id > 0) {
			$this->_notifyObservers("delete");
		}
		return $last_id;
	}
}