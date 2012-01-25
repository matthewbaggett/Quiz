<?php 
class Application_Model_Answer extends Zend_Db_Table_Row_Abstract{
	public function is_pre_selected(){
		$tbl_responses = new Application_Model_DbTable_Responses();
		$int_response_id = $this->get_question()->user_has_answered_before();
		if($int_response_id > 0){
			$obj_response = $tbl_responses->fetchRow('intResponseID = ' . $int_response_id);
			if($int_response_id > 0){
				if($this->intAnswerID == $obj_response->intAnswerID){
					return TRUE;
				}
			}
		}
		return FALSE;
	}
	
	public function get_question(){
		$tbl_questions = new Application_Model_DbTable_Questions();
		return $tbl_questions->fetchRow('intQuestionID = ' . $this->intQuestionID);
	}
	
	
}
