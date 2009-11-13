<?php

class Model_DbTable_Users extends Zend_Db_Table_Abstract
{
	protected $_name = 'users';
	protected $_dependentTables = array(
		'Model_DbTable_Questions',
		'Model_DbTable_Answers'
	);
}


?>