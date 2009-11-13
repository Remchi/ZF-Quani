<?php


class Form_Answer extends Zend_Form
{
	public function __construct()
	{
		$this->setName('answer_form');
		parent::__construct();

		$answer = new Zend_Form_Element_Textarea('answer');
		$answer->setLabel('Введите свой ответ');
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Добавить ответ');
		
		$this->addElements(array($answer, $submit));
	}
}