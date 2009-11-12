<?php

/**
* 
*/
class Model_User extends Remchi_Model
{

	public function __construct($id = null)
	{
		parent::__construct(new Model_DbTable_Users, $id);
	}
	
	public function getAllUsers()
	{
		return $this->_dbTable->fetchAll();
	}
	
	public function populateForm()
	{
		return $this->_row->toArray();
	}
	
	public function sendActivationEmail()
	{
		$mail = new Remchi_Mail();
		$mail->addTo($this->_row->email);
		$mail->setSubject('Активация аккаунта');
		$mail->setBodyView('activation', array('user' => $this));
		$mail->send();
	}
	
	public function authorize($username, $password)
	{
		$auth = Zend_Auth::getInstance();
		$authAdapter = new Zend_Auth_Adapter_DbTable(
			Zend_Db_Table::getDefaultAdapter(),
			'users',
			'username',
			'password',
			'sha(?) and activated = 1'
		);
		$authAdapter->setIdentity($username)
			->setCredential($password);
		
		$result = $auth->authenticate($authAdapter);
		if ($result->isValid()) {
			$storage = $auth->getStorage();
			$storage->write($authAdapter->getResultRowObject(null, array('password')));
			return true;
		}
		return false;
	}

}


?>