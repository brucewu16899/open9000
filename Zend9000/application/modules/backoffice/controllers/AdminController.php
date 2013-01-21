 <?php

 class Backoffice_AdminController extends Zend_Controller_Action
 {

    protected $_auth = null;

    public function init()
    {
        $this->_auth = Zend_Auth::getInstance();
    }

    public function indexAction()
    {
        Zend_Debug::dump($this->_auth->hasIdentity());
        Zend_Debug::dump($this->_auth->getIdentity());

        if ($this->_auth->hasIdentity()) {



        } else {
            $this->_helper->redirector->gotoRoute(
            	array(
                'controller'=> 'Admin',
                'action' =>'register'
              )
            );
        }
    }

        public function loginAction()
        {
            $form = new Backoffice_Form_Login();

            $translate = Zend_Registry::get('Zend_Translate');

            $view = $this->view;
            $view->title = $translate->_('Login') . ' - Backoffice';

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

                        $this->_auth->getStorage()->write(
                            array('role' => Ahs_Acl::ROLE_ADMIN,
                                  'id'   => (int) $admin_data->adm_id,
                            )
                        );
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
            $view->title = 'Registreren - Backoffice';

            $request = $this->getRequest();

            if ($request->isPost() ) {
                if ($form->isValid( $request->getPost() )) {
                    $values = $form->getValues();
                    //Zend_Debug::dump($values);

                    $admin = new Backoffice_Model_Admin($values);

                    //Zend_Debug::dump($admin);

                    $adminMapper = new Backoffice_Model_AdminMapper();
                    $adminMapper->save($admin);
                }
            }
            $view->form = $form;
        }

        public function editAction()
        {
            $form = new Backoffice_Form_Register();

            $view = $this->view;
            $view->title = 'Edit - Backoffice';


            $auth = Zend_Auth::getInstance();
            $id = $auth->getStorage()->read()['id']; // PHP 5.4 feature

            $adminMapper = new Backoffice_Model_AdminMapper();
            $array = $adminMapper->read($id);

            Zend_Debug::dump($array);

            $form->populate($array);

            $request = $this->getRequest();

            if ($request->isPost() ) {
                if ($form->isValid( $request->getPost() )) {
                    $values = $form->getValues();

                    $admin = new Backoffice_Model_Admin($values);
                    $admin->setId($id);
                    $adminMapper->save($admin);
                }
            }
            $view->form = $form;
        }
    }