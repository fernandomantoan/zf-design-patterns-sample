<?php
	class Zend_View_Helper_FlashMessenger
	{
		public function flashMessenger()
		{
			$flashMessenger = Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger');
			$messages = $flashMessenger->getMessages();
			return $messages;
		}
	}
?>