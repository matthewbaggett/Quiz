<?php

class Application_Form_Login extends Zend_Form
{
    public function init()
    {
        $this->setName("login");
        $this->setMethod('post');
             
        $this->addElement('text', 'emailaddress', array(
            'filters'    => array('StringTrim', 'StringToLower'),
            'validators' => array(
                array('StringLength', false, array(0, 50)),
            ),
            'required'   => true,
            'label'      => 'Email:',
        ));

        $this->addElement('submit', 'login', array(
            'required' => false,
            'ignore'   => true,
            'label'    => 'Login',
        ));        
    }
}