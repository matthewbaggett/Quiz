<?php

class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract
{

    protected $_name = 'tblusers';
    protected $_rowClass = 'Application_Model_User';


}

