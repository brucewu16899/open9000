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

class Ahs_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{
    protected $_acl;

    public function __construct()
    {
        $session = new Zend_Session_Namespace('ZendFramework_acl');

        if ( isset($session->acl) ) {
            $this->_acl = $session->acl;
        } else
            $this->_acl = new Ahs_Acl();
            $session->acl = $this->_acl;
    }

    /**
     * @param Zend_Controller_Request_Abstract $request
     * @return boolean
     * @throws Zend_Exception
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        parent::preDispatch($request);

        $auth = Zend_Auth::getInstance();
        $role = $auth->hasIdentity() ? $auth->getStorage()->read()['role'] : Ahs_Acl::ROLE_GUEST; // PHP 5.4!

        $resource = Ahs_Acl::getResource($request->getControllerName(),
                                         $request->getModuleName());

        $privilege = Ahs_Acl::getPrivilege($request->getActionName());

        if ($this->_acl->isAllowed($role, $resource, $privilege)) {
            return true;
        }
        throw new Zend_Exception("Access violation for Role '{$role}': no access to resource '{$resource}' for privilege '{$privilege}'");
    }
}