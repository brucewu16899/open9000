<?php
  class Backoffice_Form_Register extends Zend_Form
  {
      public function init()
      {
          $decorators = array(
              'ViewHelper',
              array('Errors', array ('class' => 'help-inline')),
              array(
                  array('inner' => 'HtmlTag'),
                  array('tag'   => 'div',
                        'class' => 'controls',
                  )
              ),
              array('Label',
                  array('placement' => 'prepend',
                        'class'     => 'control-label',
                  )
              ),
              array(
                  array('outer' => 'HtmlTag'),
                  array('tag'   => 'div',
                        'class' => 'control-group')),
          );

          $text_givenname = new Zend_Form_Element_Text('givenname');
          $text_givenname->setLabel('Given name')
                         ->addFilter('StringTrim')                                // Zend/Filter/StringTrim.php
                         ->addValidator('NotEmpty', true)                         // Zend/Validate/NotEmpty.php
                         ->setDecorators($decorators)
          ;

          $text_familyname = new Zend_Form_Element_Text('familyname');
          $text_familyname->setLabel('Family name')
                          ->addFilter('StringTrim')                               // Zend/Filter/StringTrim.php
                          ->addValidator('NotEmpty', true)                        // Zend/Validate/NotEmpty.php
                          ->setDecorators($decorators)
          ;

          $text_email = new Zend_Form_Element_Text('email');
          $text_email->setLabel('Email address')
                     ->addFilter('StringTrim')                                    // Zend/Filter/StringTrim.php
                     ->addValidator('EmailAddress', true)                         // Zend/Validate/EmailAddress.php
                     ->addValidator('NotEmpty', true)                             // Zend/Validate/NotEmpty.php
                     ->setDecorators($decorators)
          ;

          $text_username = new Zend_Form_Element_Text('username');
          $text_username->setLabel('User name')
                        ->setRequired()
                        ->addFilter('StringTrim')                                 // Zend/Filter/StringTrim.php
                        ->addValidator('NotEmpty', true)                          // Zend/Validate/NotEmpty.php
                        ->setDecorators($decorators)
          ;

          $password_raw = new Zend_Form_Element_Password('passwordraw');
          $password_raw->setLabel('Password')
                       ->setRequired()
                       ->addValidator('NotEmpty', true)                           // Zend/Validate/NotEmpty.php
                       ->setDecorators($decorators)
          ;

          $password_repeat = new Zend_Form_Element_Password('passwordrepeat');
          $password_repeat->setLabel('Password (repeat)')
                          ->setRequired()
                          ->addValidator('NotEmpty', true)                        // Zend/Validate/NotEmpty.php
                          ->setDecorators($decorators)
          ;

          $submit = new Zend_Form_Element_Submit('submit');
          $submit->setLabel('Registreren')
                 ->setOptions(array('class' => 'btn btn-primary'))
                 ->setDecorators(array('ViewHelper',
                     array(
                        array('inner'     => 'HtmlTag'),
                        array('tag'       => 'div',
                              'openOnly'  => true,
                              'class'     => 'controls'),
                     ),
                     array(
                         array('outer'    => 'HtmlTag'),
                         array('tag'      => 'div',
                               'openOnly' => true,
                               'class'    => 'control-group'),
                     ),
                 ))
          ;

          $view = Zend_Layout::getMvcInstance()->getView();

          $register = new Zend_Form_Element_Button('register');
          $register->setDescription('Aanmelden')
                   ->setDecorators( array (
                       array('Description', array('tag'  => 'a',
                                                  'href'  => $view->baseUrl('supervisor/supervisor/login'),
                                                  'class' => 'btn btn-link')),
                       array(
                           array('closeInner' =>'HtmlTag'),
                           array('tag'        => 'div',
                                 'closeOnly'  => true)
                       ),
                       array(
                           array('closeOuter' =>'HtmlTag'),
                           array('tag'        => 'div',
                                 'closeOnly'  => true)
                       ),
                   ))
          ;

          $this->setOptions(array('class' => 'form-horizontal'))
               ->setDecorators(array('FormElements', 'Form'))
               ->setMethod('post')
               ->setAction('')
               ->addElement($text_givenname )
               ->addElement($text_familyname)
               ->addElement($text_email     )
               ->addElement($text_username  )
               ->addElement($password_raw   )
               ->addElement($password_repeat)
               ->addElement($submit         )
          ;
      }
  }