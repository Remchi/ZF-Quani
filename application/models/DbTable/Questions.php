<?php

class Model_DbTable_Questions extends Zend_Db_Table_Abstract
{
	protected $_name = 'questions';
	protected $_dependentTables = array('Model_DbTable_Answers');
	protected $_referenceMap = array(
		'User' => array(
			'columns' => 'author_id',
			'refTableClass' => 'Model_DbTable_Users',
			'refColumns' => 'id',
			'onDelete' => self::CASCADE
		)
	);
}