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