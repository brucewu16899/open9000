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

/*
 * The default bootstrap:
 *
 * The default bootstrap sets up paths, loads any resources, and prep’s your application — all before your application even knows what module has been requested. 
 *
 * The module bootstrap:
 *
 * The module bootstrap can set up paths and add to or alter loaded resources like an ACL or navigation, but they’re unable to load module specific resources or execute any module specific code.
 *
 */

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    public function _initLocale()
    {
        try {
            $session = new Zend_Session_Namespace('nmdadIII_language');
            if ( isset($session->lang) ) {
                $locale = new Zend_Locale($session->lang);
            } else {
                $locale = new Zend_Locale();
            }
        } catch (Zend_Locale_Exception $e) {
            $locale = new Zend_Locale('en');
        }

        Zend_Registry::set('Zend_Locale', $locale);
    }

    public function _initTranslate()
    {
        $translate = new Zend_Translate(
                array(
                    //'adapter' => 'array',
                    'adapter' => 'Xliff',
                    'content' => APPLICATION_PATH . '/languages',
                    //'locale'  => 'auto',
                    'locale'  => Zend_Registry::get('Zend_Locale')->getLanguage(),
                    'scan'    => Zend_Translate::LOCALE_DIRECTORY,
                )
        );

        Zend_Registry::set('Zend_Translate', $translate);
    }

    public function _initValidate()
    {
        //Zend_Debug::dump(APPLICATION_PATH);
        try {
            $translate = new Zend_Translate(
                array(
                    'adapter' => 'array',
                    'content' => APPLICATION_PATH . '/../../../ZendFramework-1.12.0/resources/languages',
                    'locale'  => 'auto',
                    'scan'    => Zend_Translate::LOCALE_DIRECTORY,
                )
            );
            Zend_Validate::setDefaultTranslator($translate);
        } catch (Zend_Translate_Exception $e) {
            // Do nothing
        }
    }

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
             ->appendName('viewport', 'width=device-width, initial-scale=1')
        ;

        $view->headTitle($view->title, 'PREPEND') // Zend_View_Helper_HeadTitle
             ->setDefaultAttachOrder('PREPEND')
             ->setSeparator(' ← ')
        ;

        $view->headLink() // Zend_View_Helper_HeadLink
             ->appendStylesheet($view->baseUrl('css/normalize.css'))
             ->appendStylesheet($view->baseUrl('jquery.mobile-1.2.0/jquery.mobile-1.2.0.min.css'))
             ->appendStylesheet($view->baseUrl('bootstrap-2.1.1/css/bootstrap.min.css'))
             ->appendStylesheet($view->baseUrl('bootstrap-2.1.1/css/bootstrap-responsive.min.css'))
             ->appendStylesheet($view->baseUrl('css/main.css'))
        ;

        $view->headScript()
             ->appendFile($view->baseUrl('js/modernizr-2.6.2.min.js'))
        ;

        $view->inlineScript()
             ->appendFile('http://code.jquery.com/jquery-1.8.3.min.js')
             ->appendFile($view->baseUrl('jquery.mobile-1.2.0/jquery.mobile-1.2.0.min.js'))
             ->appendFile($view->baseUrl('bootstrap-2.1.1/js/bootstrap.min.js'))
             ->appendFile('http://maps.googleapis.com/maps/api/js?key=AIzaSyCN02ut-Z3iVvlbo8pSpR9E4Pob-Wu_kkE&sensor=true')
             ->appendFile($view->baseUrl('js/markerclusterer.js'))
	         ->appendFile('http://d3js.org/d3.v3.min.js')
             ->appendFile($view->baseUrl('js/main.js'))
        ;
    }

    protected function _initViewHelperNavigation()
    {
        $yaml = APPLICATION_PATH . '/configs/navigation.yml';
        $pages = new Zend_Config_Yaml($yaml);
        $navigation = new Zend_Navigation($pages);

        $auth = Zend_Auth::getInstance();
        $role = $auth->hasIdentity() ? $auth->getStorage()->read()['role'] : Ahs_Acl::ROLE_GUEST; // PHP 5.4!

        $this->bootstrap('layout'); // Make a _initLayout()
        $view = $this->getResource('layout')->getView();
        $view->navigation($navigation)
             ->setAcl(new Ahs_Acl())
             ->setRole($role)
        ;
        $view->navigation()->breadcrumbs()
                           ->setPartial('partials/breadcrumbs.phtml')
                           ->setSeparator(' / ')
        ;
        $view->navigation()->menu()
                           ->setPartial('partials/menu.phtml')
                           ->setUlClass('nav')
        ;
    }
}