<?php

class QuizController extends Zend_Controller_Action
{

	protected $tbl_quizzes;
	protected $tbl_responses;
	
    public function init(){
        /* Initialize action controller here */
    	$this->tbl_quizzes = new Application_Model_DbTable_Quizzes();
    	$this->tbl_responses = new Application_Model_DbTable_Responses();
    }

    public function listAction(){
        
        $arr_quizzes = $this->tbl_quizzes->fetchAll();
        $this->view->assign('arr_quizzes', $arr_quizzes);
    }
    
    public function takeAction(){
    	Application_Model_User::enforceLogin();
    	$params = $this->_getAllParams();
    	$int_quiz_id = (int) $params['quiz_id'];
    	
    	// Get the quiz
    	$obj_quiz = $this->tbl_quizzes->fetchRow('intQuizID = ' . $int_quiz_id);
    	
    	// Assign variables to the view
    	$this->view->obj_quiz = $obj_quiz;
    }
    
    public function submitAction(){
    	$params = $this->_getAllParams();
    	$int_quiz_id = (int) $params['quiz_id'];
    	$obj_request = $this->getRequest();
    	$arr_answers = $obj_request->getPost();
    	
    	// Get the quiz
    	$obj_quiz = $this->tbl_quizzes->fetchRow('intQuizID = ' . $int_quiz_id);
    	
    	foreach($obj_quiz->get_questions() as $obj_question){
    		if(isset($arr_answers['question_' . $obj_question->intQuestionID])){
    			//Test to see if the user has responded to this Question before
    			$int_previous_response_id = $obj_question->user_has_answered_before();
    			if($int_previous_response_id > 0){
    				if($obj_question->is_freeform()){
    					// If its freeform, insert as freeform
    					$this->tbl_responses->update(
    							array(
    								'intUserID' => Application_Model_User::getCurrentUser()->intUserID,
		    						'intQuestionID' => $obj_question->intQuestionID,
		    						'intAnswerID' => 0,
		    						'strAnswerValue' => $arr_answers['question_' . $obj_question->intQuestionID]
    							), 
    							'intResponseID = ' . $int_previous_response_id
    					);
    				}else{
    					// If not freeform, save the ID of the answer selected.
    					$this->tbl_responses->update(
    							array(
    									'intUserID' => Application_Model_User::getCurrentUser()->intUserID,
    									'intQuestionID' => $obj_question->intQuestionID,
    									'intAnswerID' => $arr_answers['question_' . $obj_question->intQuestionID],
    									'strAnswerValue' => ''
    							),
    							'intResponseID = ' . $int_previous_response_id
    					);
    				}
    			}else{
	    			if($obj_question->is_freeform()){
	    				// If its freeform, insert as freeform
	    				$this->tbl_responses->insert(array(
	    						'intUserID' => Application_Model_User::getCurrentUser()->intUserID,
	    						'intQuestionID' => $obj_question->intQuestionID,
	    						'intAnswerID' => 0,
	    						'strAnswerValue' => $arr_answers['question_' . $obj_question->intQuestionID]
	    				));
	    			}else{
	    				// If not freeform, save the ID of the answer selected.
	    				$this->tbl_responses->insert(array(
	    						'intUserID' => Application_Model_User::getCurrentUser()->intUserID,
	    						'intQuestionID' => $obj_question->intQuestionID,
	    						'intAnswerID' => $arr_answers['question_' . $obj_question->intQuestionID],
	    						'strAnswerValue' => ''
	    				));
	    			}
    			}
    		}else{
    			// User did not answer the question
    		}
    	}
    	
    	// Assign variables to the view
    	$this->view->obj_quiz = $obj_quiz;
    	
    	
    }

}



