<?php
	class Zend_View_Helper_LoggedUser extends Zend_View_Helper_Abstract
	{
		public function loggedUser()
		{
			$info = Zend_Auth::getInstance()->getIdentity();
			$infosLoggedUser = sprintf('<div class="profile">
											Logado como %s &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; <a href="%s">Sair</a>
										</div>', $info->nome_real, 
												 $this->view->url(array('controller' => 'auth', 'action' => 'logout'), '', true));
			return $infosLoggedUser;
		}
	}
?>