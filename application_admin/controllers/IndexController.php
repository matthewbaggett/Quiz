<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    	$tbl_users = new Application_Model_DbTable_Users();
        $arr_users = $tbl_users->fetchAll();
        $this->view->arr_users = $arr_users;
    }

}



