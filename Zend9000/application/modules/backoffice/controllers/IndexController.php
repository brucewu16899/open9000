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
		$layout = $this->layout();
		$layout->headTitle = 'test';

		$view = $this->view;
		$view->title = 'Backoffice';



	    // if ($this->_auth->hasIdentity()) {
	    //     $this->redirect('backoffice/admin/');
	    // } else {
	    //     $this->redirect('backoffice/admin/login');
	    // }

	}
	public function testAction()
	{
		$view = $this->view;
		$view->title = 'test';

	    // if ($this->_auth->hasIdentity()) {
	    //     $this->redirect('backoffice/admin/');
	    // } else {
	    //     $this->redirect('backoffice/admin/login');
	    // }

	}


}

