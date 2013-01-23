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

class Backoffice_Form_Login extends Zend_Form
{
    private $username = '';

    public function setUsername($usern) 
    {
        $this->$username = $usern;
        return $this;
    }

    public function __construct(array $params = array())
    {
      $this->username = $params['username'];
      parent::__construct(); // <---- INSTEAD of $this->init()
    }

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

        $text_username = new Zend_Form_Element_Text('username');

        $text_username->setLabel('User name')
                      ->setValue($this->username)
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

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Login')
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
        $register->setDescription('Register')
                 ->setDecorators( array (
                     array('Description', array('tag'  => 'a',
                                                'href'  => $view->baseUrl('backoffice/admin/register'),
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
             ->addElement($text_username)
             ->addElement($password_raw )
             ->addElement($submit       )
             ->addElement($register     )
        ;
    }

    /**
     * @param mixed $data Form data.
     * @return boolean
     */
    public function isValid($data)
    {
        $valid = parent::isValid($data);

        foreach ($this->getElements() as $element) {
            if ($element->hasErrors()) {

                $decorator = $element->getDecorator('outer');

                $options = $decorator->getOptions();
                $options['class'] .= ' error';

                $decorator->setOptions($options);
            }
        }

        return $valid;
    }
}