<?php 
class Application_Model_Response extends Zend_Db_Table_Row_Abstract{
	
	public function get_question(){
		$tbl_questions = new Application_Model_DbTable_Questions();
		return $tbl_questions->fetchRow('intQuestionID = ' . $this->intQuestionID);
	}
	
	public function __toString(){
		if($this->intAnswerID > 0){
			$tbl_answers = new Application_Model_DbTable_Answers();
			$obj_answer = $tbl_answers->fetchRow('intAnswerID = ' . $this->intAnswerID);
			return $obj_answer->strAnswer;
			
		}else{
			return $this->strAnswerValue;
		}
		
	}
}
