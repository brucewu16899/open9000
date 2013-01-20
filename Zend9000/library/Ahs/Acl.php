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

class Ahs_Acl extends Zend_Acl
{
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_ALL   =  null       ;
    const ROLE_GUEST = 'ROLE_GUEST';
    const ROLE_USER  = 'ROLE_USER' ;

    public function __construct()
    {
        $this->addRole(self::ROLE_GUEST                         )
             ->addRole(self::ROLE_USER , array(self::ROLE_GUEST))
             ->addRole(self::ROLE_ADMIN, array(self::ROLE_USER ))
             ->allow(  self::ROLE_ADMIN)
             ->_addModuleDefault()
             ->_addModuleBackoffice()
        ;
    }

    protected function _addModuleDefault()
    {
        $r = array();
        $r['error'] = self::getResource('error');
        $r['index'] = self::getResource('index');

        return $this->addResources($r)
                    ->allow(self::ROLE_ALL, $r['error'])
                    ->allow(self::ROLE_ALL, $r['index'])
        ;
    }

    protected function _addModuleBackoffice()
    {
        $module = 'backoffice';
        $r = array();
        $r['admin'] = self::getResource('admin', $module);
        $r['index'] = self::getResource('index', $module);

        $p = array();
        $p['edit'    ] = self::getPrivilege('edit'    );
        $p['index'   ] = self::getPrivilege('index'   );
        $p['login'   ] = self::getPrivilege('login'   );
        $p['logout'  ] = self::getPrivilege('logout'  );
        $p['register'] = self::getPrivilege('register');

        $this->addResources($r)
             ->allow(self::ROLE_GUEST, $r['admin'], array(
                 $p['index'   ],
                 $p['login'   ],
                 $p['register'],
             ))
             ->allow(self::ROLE_ADMIN, $r['admin'], array(
                 $p['edit'    ],
             ))
             ->deny( self::ROLE_ADMIN, $r['admin'], array(
                 $p['login'   ],
                 $p['register'],
             ))
             ->allow(self::ROLE_GUEST, $r['index'])
        ;
    }

    /**
     * @param array $resources
     * @return Ahs_Acl
     */
    public function addResources($resources = array()) {
        foreach ($resources as $resource) {
            $this->addResource($resource);
        }

        return $this;
    }

    /**
     * @param string $controller Controller name.
     * @param string $module Module name.
     * @return string Class name of Controller.
     */
    public static function getResource($controller = 'index', $module = 'default')
    {
        $class_name = ucfirst($controller) . 'Controller';

        if ($module != 'default') {
            $class_name = ucfirst($module) . "_{$class_name}";
        }

        return $class_name;
    }

    /**
     * @param string $action Action method name.
     * @return string Method name of Action method.
     */
    public static function getPrivilege($action = 'index')
    {
        $method_name = lcfirst($action) . 'Action';

        return $method_name;
    }
}