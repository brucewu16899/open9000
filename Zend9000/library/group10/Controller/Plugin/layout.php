<?php

class group10_Controller_Plugin_layout extends Zend_Controller_Plugin_Abstract
{
    //protected $_acl;

    public function __construct()
    {
        //$session = new Zend_Session_Namespace('ZendFramework_acl');

        //if ( isset($session->acl) ) {
        //    $this->_acl = $session->acl;
        //} else
        //    $this->_acl = new Ahs_Acl();
        //    $session->acl = $this->_acl;
    }

    public function routeStartup(Zend_Controller_Request_Abstract $request)
    {
        //$this->getResponse()->appendBody("<p>routeStartup() called</p>\n");
    }
 
    public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {
        //$this->getResponse()->appendBody("<p>routeShutdown() called</p>\n");
    }
 
    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
        //$this->getResponse()->appendBody("<p>dispatchLoopStartup() called</p>\n");
    
        if ('backoffice' != $request->getModuleName()) {
            // If not in this module, return early
            return;
        }

        // Change layout
        Zend_Layout::getMvcInstance()->setLayout('html5');

    }
 
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        //$this->getResponse()->appendBody("<p>preDispatch() called</p>\n");
    }
 
    public function postDispatch(Zend_Controller_Request_Abstract $request)
    {
        //$this->getResponse()->appendBody("<p>postDispatch() called</p>\n");
    }
 
    public function dispatchLoopShutdown()
    {
        //$this->getResponse()->appendBody("<p>dispatchLoopShutdown() called</p>\n");
    }
}

// $front = Zend_Controller_Front::getInstance();
// $front->setControllerDirectory('/path/to/controllers')
//       ->setRouter(new Zend_Controller_Router_Rewrite())
//       ->registerPlugin(new MyPlugin());
// $front->dispatch();