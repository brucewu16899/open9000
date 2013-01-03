<?php

class Backoffice_IndexController extends Zend_Controller_Action
{

	/**
	 * @var Zend_Auth
	 */
	protected $_auth;

	public function init()
	{
	    $this->_auth = Zend_Auth::getInstance();
	}

	public function indexAction()
	{
		$view = $this->view;
		$view->title = 'Backoffice';

	    // if ($this->_auth->hasIdentity()) {
	    //     $this->redirect('backoffice/admin/');
	    // } else {
	    //     $this->redirect('backoffice/admin/login');
	    // }
	}


}

