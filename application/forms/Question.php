<?php

class Form_Question extends Zend_Form
{
	public function __construct()
	{
		$this->setName('question_form');
		parent::__construct();

		$title = new Zend_Form_Element_Text('title');
		$title->setLabel('Вопрос');
		
		$description = new Zend_Form_Element_Textarea('description');
		$description->setLabel('Подробное описание вопроса');
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Добавить вопрос');
		
		$this->addElements(array($title, $description, $submit));
	}
}