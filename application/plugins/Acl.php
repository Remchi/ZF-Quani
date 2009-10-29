<?php

/**
* 
*/
class Plugin_Acl extends Zend_Controller_Plugin_Abstract
{
	private $_controller = array(
		'controller' => 'error', 
		'action' => 'denied'
	);
	
	public function __construct()
	{
		$acl = new Zend_Acl();
		
		//roles
		$acl->addRole(new Zend_Acl_Role('guest'));
		$acl->addRole(new Zend_Acl_Role('user'), 'guest');
		$acl->addRole(new Zend_Acl_Role('admin'));
		
		//resources
		$acl->add(new Zend_Acl_Resource('users'));
		$acl->add(new Zend_Acl_Resource('index'));
		
		//permissions
		$acl->deny();
		$acl->allow('admin', null);
		
		//Guest rights
		$acl->allow('guest', 'users', array(
			'login', 'registration', 'confirm'
		));
		$acl->allow('guest', 'index');
		
		//User rights
		$acl->allow('user', 'users', array(
			'logout'
		));		
		$acl->deny('user', 'users', array(
			'login', 'registration'
		));	
		
		Zend_Registry::set('acl', $acl);
	}
	
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		$auth = Zend_Auth::getInstance();
		$acl = Zend_Registry::get('acl');
		
		if ($auth->hasIdentity()) {
			$role = $auth->getIdentity()->role;
		} else {
			$role = 'guest';
		}
		
		if (!$acl->hasRole($role)) {
			$role = 'guest';
		}
		
		$controller = $request->controller;
		$action = $request->action;
		
		if (!$acl->has($controller)) {
			$controller = null;
		}
		
		if (!$acl->isAllowed($role, $controller, $action)) {
			$request->setControllerName($this->_controller['controller']);
			$request->setActionName($this->_controller['action']);
		}
	}
}



?>