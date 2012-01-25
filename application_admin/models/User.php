<?php 
class Application_Model_User extends Zend_Db_Table_Row_Abstract{
	static public function getCurrentUser(){
	 	$userSessionNamespace = new Zend_Session_Namespace('User'); 
		if($userSessionNamespace->obj_user){
			return $userSessionNamespace->obj_user;
		}else{
			return NULL;
		}
	}
	
	
	static public function enforceLogin(){
		if(!self::getCurrentUser()){
			$view = new Zend_View();
			header("Location: " .  $view->url(array("controller" => "Login", "action" => "index")));
			exit;
		}
	}
	
	public function get_responses(){
		$tbl_responses = new Application_Model_DbTable_Responses();
		return $tbl_responses->fetchAll('intUserID = ' . $this->intUserID);
	}
	
	public function get_quizzes_completed(){
		$arr_responses = $this->get_responses();
		$arr_quizzes_taken_part_in = array();
		foreach($arr_responses as $obj_response){
			$obj_question = $obj_response->get_question();
			$arr_quizzes_taken_part_in[] = $obj_question->intQuizID;
		}
		$arr_quizzes_taken_part_in = array_unique($arr_quizzes_taken_part_in);
		if(count($arr_quizzes_taken_part_in) > 0){
			$tbl_quizzes = new Application_Model_DbTable_Quizzes();
			$sel_quizzes = $tbl_quizzes->select();
			$sel_quizzes->where('intQuizID IN (?)', $arr_quizzes_taken_part_in);
			#echo $sel_quizzes; exit;
			return $tbl_quizzes->fetchAll($sel_quizzes);
		}else{
			return array();
		}
	}
}
