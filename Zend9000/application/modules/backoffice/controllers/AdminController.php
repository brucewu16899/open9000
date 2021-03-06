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
 * 
 * Improved by Group 10: Van de Calseyde Louis & Van der Eecken Pierre
 */

class Backoffice_AdminController extends Zend_Controller_Action
{
    protected $_auth = null;

    public function init()
    {
        $this->_auth = Zend_Auth::getInstance();

        //$layout = Zend_Layout::getMvcInstance();
        // Set a layout script path:
        //$layout->setLayoutPath('/path/to/you/default/module/layouts');
        // choose a different layout script:
        //$layout->setLayout('html5');

        //$this->_flashMessenger =
        //    $this->_helper->getHelper('FlashMessenger');
    }

    public function indexAction()
    {
        //Zend_Debug::dump($this->_auth->hasIdentity());
        //Zend_Debug::dump($this->_auth->getIdentity());

        $this->view->messages = $this->_helper->flashMessenger->getMessages();

        $view = $this->view;
        $view->title = 'Backoffice index';

        if ( $this->_auth->hasIdentity() ) {
            $auth = Zend_Auth::getInstance();
            $id = $auth->getStorage()->read()['id']; // PHP 5.4 feature

            $adminMapper = new Backoffice_Model_AdminMapper();
            
            $array = $adminMapper->read($id);
            $view->userInfo = $array;

            $role = $this->_auth->getIdentity();
            $view->userRole = $role;
        } else {
            return $this->redirect('backoffice');
        }
    }

    public function loginAction()
    {
        $bla = $this->_getParam('username');

        $form = new Backoffice_Form_Login( array('username' => $bla) );

        //$translate = Zend_Registry::get('Zend_Translate');

        $view = $this->view;
        $view->title = 'Backoffice Login';

        $request = $this->getRequest();

        if ($request->isPost() ) {
            if ($form->isValid( $request->getPost() )) {
                $values = $form->getValues();

                $admin = new Backoffice_Model_Admin($values);

                $adapter = new Ahs_Auth_Adapter_Admin($admin->getUsername(),
                                                      $admin->getPassword());

                $this->_auth->authenticate($adapter);

                if ($this->_auth->hasIdentity() ) {
                    $admin_data = $adapter->getResultRowObject();

                    $this->_auth->getStorage()->write(array('role' => Ahs_Acl::ROLE_ADMIN,
                                                            'id'   => (int) $admin_data->adm_id,
                                              ));
                    return $this->redirect('backoffice/index/');
                } else {
                    // Unable to authenticate
                    return $this->redirect('backoffice');
                }
            }
        }
        
        $view->form = $form;
    }

    public function logoutAction()
    {
        $this->_auth->clearIdentity();

        return $this->redirect('backoffice');
    }

    public function registerAction()
    {
        $form = new Backoffice_Form_Register();

        $view = $this->view;
        $view->title = 'Backoffice Registreren';

        $request = $this->getRequest();

        if ($request->isPost() ) {
            if ($form->isValid( $request->getPost() )) {
                $values = $form->getValues();

                //Zend_Debug::dump($values);

                $admin = new Backoffice_Model_Admin($values);

                //Zend_Debug::dump($admin);

                $adminMapper = new Backoffice_Model_AdminMapper();
                $adminMapper->save($admin);

                return $this->redirect('backoffice/admin/login/username/' . $values['username'] );
            }
        }
        $view->form = $form;
    }

    public function editAction()
    {
        $form = new Backoffice_Form_Register();

        $view = $this->view;
        $view->title = 'Backoffice Edit';
        
        //set the title in the html <head>
        $view->headTitle()->append('Edit');

        $auth = Zend_Auth::getInstance();
        $id = $auth->getStorage()->read()['id']; // PHP 5.4 feature

        $adminMapper = new Backoffice_Model_AdminMapper();
        $array = $adminMapper->read($id);

        $form->populate($array);

        $request = $this->getRequest();

        if ($request->isPost() ) {
            if ($form->isValid( $request->getPost() )) {

                $values = $form->getValues();

                $admin = new Backoffice_Model_Admin($values);
                $admin->setId($id);
                $adminMapper->save($admin);

                // http://akrabat.com/zend-framework/zend-frameworks-flash-messenger-action-helper/
                $this->_helper->flashMessenger->addMessage('Task saved');
                $this->_helper->redirector('index');
            }
        }
        $view->form = $form;
    }
}