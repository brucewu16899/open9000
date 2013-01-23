<?php
/******************************************************************************
 *                                                                            *
 *                                                                            *
 *                                                                            *
 *                        aaaAAaaa            HHHHHH                          *
 *                     aaAAAAAAAAAAaa         HHHHHH                          *
 *                    aAAAAAAAAAAAAAAa        HHHHHH                          *
 *                   aAAAAAAAAAAAAAAAAa       HHHHHH                          *
 *                   aAAAAAa    aAAAAAA                                       *
 *                   AAAAAa      AAAAAA                                       *
 *                   AAAAAa      AAAAAA                                       *
 *                   aAAAAAa     AAAAAA                                       *
 *                    aAAAAAAaaaaAAAAAA       HHHHHH                          *
 *                     aAAAAAAAAAAAAAAA       HHHHHH                          *
 *                      aAAAAAAAAAAAAAA       HHHHHH                          *
 *                         aaAAAAAAAAAA       HHHHHH                          *
 *                                                                            *
 *                                                                            *
 *                                                                            *
 *      a r t e v e l d e  u n i v e r s i t y  c o l l e g e  g h e n t      *
 *                                                                            *
 *                                                                            *
 *                                 MEMBER OF GHENT UNIVERITY ASSOCIATION      *
 *                                                                            *
 *                                                                            *
 ******************************************************************************
 *
 * @author     Olivier Parent
 * @copyright  Copyright (c) 2012 Artevelde University College Ghent
 */

//class Backoffice_Application_Module_Bootstrap extends Zend_Application_Module_Bootstrap
class Backoffice_Bootstrap extends Zend_Application_Module_Bootstrap
{
    public function _initFormTranslate()
    {
      //$translate = new Zend_Translate_Adapter_Array();

      //Zend_Registry::set('Zend_Translate', $translate);
    }

    /**
     * Constructor
     *
     * @param  Zend_Application|Zend_Application_Bootstrap_Bootstrapper 
     *     $application
     * @return void
     */
    public function __construct($application)
    {
      //

      parent::__construct($application);

      $bootstrap = $this->getApplication();
      $bootstrap->bootstrap('frontcontroller');

      $front = $bootstrap->getResource('frontcontroller');
      $front->registerPlugin(new group10_Controller_Plugin_layout() );

      //http://offshootinc.com/blog/2011/02/11/modul-bootstrapping-in-zend-framework/

      $this->_loadModuleConfig();
    }
     
    /**
     *
     * load a module specific config file
     */
    protected function _loadModuleConfig()
    {
      // would probably better to use 
      // Zend_Controller_Front::getModuleDirectory() ?
      $configFile = APPLICATION_PATH 
          . '/modules/' 
          . strtolower($this->getModuleName()) //backoffice
          . '/configs/module.ini';

      if (!file_exists($configFile)) {
          return;
      }

      $config = new Zend_Config_Ini($configFile, $this->getEnvironment());
      $this->setOptions($config->toArray());

    }
}