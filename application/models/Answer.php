<?php

class Model_Answer extends Remchi_Model
{
	public function __construct($id = null)
	{
		parent::__construct(new Model_DbTable_Answers, $id);
	}
}