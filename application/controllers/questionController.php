<?php

class QuestionController extends Zend_Controller_Action
{
    public function addAction()
    {	

        $form = new Form_Question();

		if ($this->getRequest()->isPost()) {
			if ($form->isValid($this->getRequest()->getPost())) {
				$question = new Model_Question();
				$question->fill($form->getValues());
				$question->created = date('Y-m-d H:i:s');
				$question->author_id = Zend_Auth::getInstance()->getIdentity()->id;
				$question->save();
			}
		}

		$this->view->form = $form;
    }  

	public function indexAction()
	{
		$db = Zend_Registry::get('db');		
		$select = $db->select()
			->from(array('q' => 'questions'))
			->join(array('u' => 'users'), 'u.id = q.author_id', 'username')
			->joinLeft(array('a' => 'answers'), 'a.question_id = q.id', 
			array('answers_count' => 'COUNT(a.id)'))
			->group('q.id');
		
		$paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($select));
		$paginator->setCurrentPageNumber($this->_getParam('page'));
		$paginator->setItemCountPerPage(5);
		$this->view->paginator = $paginator;
		
	}

	public function viewAction()
	{
		$id = $this->getRequest()->getParam('id');
	    $question = new Model_Question($id);
		$author = $question->getAuthor();
		$answers = $question->getAnswers();
		$form = new Form_Answer();
		
		if ($this->getRequest()->isPost()) {
			if ($form->isValid($this->getRequest()->getPost())) {
				$answer = new Model_Answer();
				$answer->fill($form->getValues());
				$answer->created = date('Y-m-d H:i:s');
				$answer->author_id = Zend_Auth::getInstance()->getIdentity()->id;
				$answer->question_id = $id;
				$answer->save();
				$this->_redirect('/question/view/id/' . $id);
			}
		}
		
		$this->view->form = $form;
		$this->view->question = $question;
		$this->view->author = $author;
		$this->view->answers = $answers;
	}
}