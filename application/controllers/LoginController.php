<?php

class LoginController extends Zend_Controller_Action
{

   

    
    protected function _process_login($values)
    {
		
    	// Get the Email address from the form
		$str_email = $values['emailaddress'];
		
		//Get our users table object
		$tbl_users = new Application_Model_DbTable_Users();
		
		// Get a selector from that table
		$sel_user_auth = $tbl_users->select();
		
		// Add the WHERE condition for the email address.
		$sel_user_auth->where('strEmail = ?', $str_email);

		// Run it.
		$obj_user = $tbl_users->fetchRow($sel_user_auth);
		if($obj_user){
			$userSessionNamespace = new Zend_Session_Namespace('User');
			$userSessionNamespace->obj_user = $obj_user;
			return TRUE;
		}else{
			return FALSE;
		}
    }
    
    public function init()
    {
		/* Initialize action controller here */
    }

    public function indexAction()
    {
    	
		$form = new Application_Form_Login();
		$request = $this->getRequest();
		if ($request->isPost()) {
			if ($form->isValid($request->getPost())) {
				if ($this->_process_login($form->getValues())) {
					// We're authenticated! Redirect to the home page
					$this->_helper->redirector('index', 'index');
				}
			}
		}
		$this->view->form = $form;
    }

    public function logoutAction()
    {
    	$userSessionNamespace = new Zend_Session_Namespace('User');
    	$userSessionNamespace->obj_user = null;
		$this->_helper->redirector('index'); // back to login page
    }

}





