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

class Ahs_Auth_Adapter_Admin extends Zend_Auth_Adapter_DbTable
{
    /**
     * @param string $username User name.
     * @param string $password Password.
     */
    public function __construct($username, $password)
    {
        parent::__construct();
        $this->setTableName('Admins') // WARNING: case sensitive!
             ->setIdentityColumn(  'adm_username')
             ->setCredentialColumn('adm_password')
             ->setIdentity(  $username)
             ->setCredential($password)
             ->getDbSelect()->where('adm_active = TRUE')
                            ->where('adm_deleted = FALSE')
        ;
//        Zend_Debug::dump($this); exit;
    }
}