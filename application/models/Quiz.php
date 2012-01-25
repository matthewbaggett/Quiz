<?php 
class Application_Model_Quiz extends Zend_Db_Table_Row_Abstract{
	public function get_questions(){
		$tbl_questions = new Application_Model_DbTable_Questions();
		return $tbl_questions->fetchAll('intQuizID = ' . $this->intQuizID);
	}
}
