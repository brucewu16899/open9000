<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	public function _initViewHelpers()
	{
	    $this->bootstrap('layout'); // Make a _initLayout()
	    $view = $this->getResource('layout')->getView();

	    // To make $view->baseUrl() available in this bootstrap
	    $front = $this->getResource('frontController');
	    $front->setRequest(new Zend_Controller_Request_Http());

	    $view->doctype('HTML5'); // http://framework.zend.com/manual/en/zend.view.helpers.html#zend.view.helpers.initial.doctype
	    $view->headMeta()
	         ->setCharset('utf-8')
	         ->appendName('viewport', 'width=device-width')
	         ->appendName('description', 'the zend description')
	    ;

	    $view->headTitle($view->title, 'PREPEND') // Zend_View_Helper_HeadTitle
	         ->setDefaultAttachOrder('PREPEND')
	         ->setSeparator(' ← ')
	    ;

	    // $view->headLink() // Zend_View_Helper_HeadLink
	    //      ->appendStylesheet($view->baseUrl('bootstrap-2.1.1/css/bootstrap.min.css'))
	    //      ->appendStylesheet($view->baseUrl('bootstrap-2.1.1/css/bootstrap-responsive.min.css'))
	    //      ->appendStylesheet($view->baseUrl('css/main.css'))
	    // ;

	    // $view->inlineScript()
	    //      ->appendFile('http://code.jquery.com/jquery-latest.js')
	    //      ->appendFile($view->baseUrl('bootstrap-2.1.1/js/bootstrap.min.js'))
	    // ;
	}

}

