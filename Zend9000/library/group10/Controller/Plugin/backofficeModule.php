<?php

class group10_Controller_Plugin_backofficeModule extends Zend_Controller_Plugin_Abstract
{
    public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {
        $activeModuleName = $request->getModuleName();
        $activeBootstrap = $this->_getActiveBootstrap($activeModuleName);
    }
 
    /**
     * return the default bootstrap of the app
     * @return Zend_Application_Bootstrap_Bootstrap
     */
    protected function _getBootstrap()
    {
        $frontController = Zend_Controller_Front::getInstance();
        $bootstrap =  $frontController->getParam('bootstrap');
        return $bootstrap;
    }

    /**
     * return the bootstrap object for the active module
     * @return Offshoot_Application_Module_Bootstrap
     */
    public function _getActiveBootstrap($activeModuleName)
    {
        $moduleList = $this->_getBootstrap()->getResource('modules');
 
        if (isset($moduleList[$activeModuleName])) {
            return $moduleList[$activeModuleName];
        }
 
        return null;
    }
}