<?php 
class Application_Model_Question extends Zend_Db_Table_Row_Abstract{
	public function get_answers(){
		$tbl_answers = new Application_Model_DbTable_Answers();
		return $tbl_answers->fetchAll('intQuestionID = ' . $this->intQuestionID);
	}
	
	public function is_freeform(){
		if($this->bolIsFreeform > 0){
			return TRUE;
		}
		return FALSE;
	}
	
	
	public function user_has_answered_before(){
		$user_id = Application_Model_User::getCurrentUser()->intUserID;
		$tbl_responses = new Application_Model_DbTable_Responses();
		$sel_find_matches = $tbl_responses->select();
		$sel_find_matches->where('intUserID = ?',$user_id);
		$sel_find_matches->where('intQuestionID = ?',$this->intQuestionID);
		$arr_matches = $tbl_responses->fetchAll($sel_find_matches)->toArray();
		
		if(count($arr_matches) > 0){
			$obj_last_response = $arr_matches[0];
			return $obj_last_response['intResponseID'];
		}else{
			return FALSE;
		}
	}
	
	public function get_response(){
		$tbl_responses = new Application_Model_DbTable_Responses();
		$int_response_id = $this->user_has_answered_before();
		if($int_response_id > 0){
			$obj_response = $tbl_responses->fetchRow('intResponseID = ' . $int_response_id);
			return $obj_response;
		}
		return FALSE;
	}
}
