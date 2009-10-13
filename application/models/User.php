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
	


}


?>