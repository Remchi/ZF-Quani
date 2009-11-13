<?php


class Model_DbTable_Answers extends Zend_Db_Table_Abstract
{
	protected $_name = 'answers';
	protected $_referenceMap = array(
		'User' => array(
			'columns' => 'author_id',
			'refTableClass' => 'Model_DbTable_Users',
			'refColumns' => 'id',
			'onDelete' => self::CASCADE
		),
		'Question' => array(
			'columns' => 'question_id',
			'refTableClass' => 'Model_DbTable_Questions',
			'refColumns' => 'id',
			'onDelete' => self::CASCADE
		)
	);
}