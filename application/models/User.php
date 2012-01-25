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
}
