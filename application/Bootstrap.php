<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	protected function _initAutoload() 
	{
		$moduleLoader = new Zend_Application_Module_Autoloader(array( 
			'namespace' => '', 
			'basePath'  => APPLICATION_PATH)); 
			
		$autoloader = Zend_Loader_Autoloader::getInstance();
		$autoloader->registerNamespace(array('Remchi_'));
		
		return $moduleLoader;
	}
	
	protected function _initAcl()
	{
		
	
	}
	
	protected function _initPlugins()
	{
		$front = Zend_Controller_Front::getInstance();
		$front->registerPlugin(new Plugin_Acl());
	}

	protected function _initViewHelpers() 
	{ 
		$this->bootstrap('layout');
		$layout = $this->getResource('layout');
		$view = $layout->getView();

		$view->doctype('XHTML1_STRICT'); 
		$view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8'); 
		$view->headTitle()->setSeparator(' - '); 
		$view->headTitle('Quani'); 
		
		if (!Zend_Auth::getInstance()->hasIdentity()) {
			$view->identity = false;
		} else {
			$view->identity = Zend_Auth::getInstance()->getIdentity();
		}		
	}
	
	protected function _initEmail()
	{
		$email_config = array(
			'auth' => 'plain',
			'username' => 'username',
			'password' => 'password',
			'ssl' => 'tls',
			'port' => 25
		);
		$transport = new Zend_Mail_Transport_Smtp('mail.domain.com',
			$email_config);
		Zend_Mail::setDefaultTransport($transport);
	}	

}

