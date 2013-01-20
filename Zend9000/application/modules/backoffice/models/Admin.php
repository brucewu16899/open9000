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

class Backoffice_Model_Admin
{
    /**
     * ID
     *
     * @var integer
     */
    protected $_id;

    /**
     * Given name
     *
     * @var string
     */
    protected $_givenname;

    /**
     * Family name
     *
     * @var string
     */
    protected $_familyname;

    /**
     * Email address
     *
     * @var string
     */
    protected $_email;

    /**
     * User name
     *
     * @var string
     */
    protected $_username;

    /**
     * Password (hashed)
     *
     * @var string
     */
    protected $_password;

    /**
     * @param array $values
     */
    public function __construct(array $values) {
        foreach($values as $key => $value) {
            $setter = 'set' . ucfirst($key);
            $this->{$setter}($value);
        }
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param integer $id
     */
    public function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * @return string
     */
    public function getGivenname()
    {
        return $this->_givenname;
    }

    /**
     * @param string $givenname
     */
    public function setGivenname($givenname)
    {
        $this->_givenname = $givenname;
    }

    /**
     * @return string
     */
    public function getFamilyname()
    {
        return $this->_familyname;
    }

    /**
     * @param string $familyname
     */
    public function setFamilyname($familyname)
    {
        $this->_familyname = $familyname;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->_username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->_username = $username;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->_email = $email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->_password = $password;
    }

    /**
     * Setter for passwordraw form field that hashes the password string.
     *
     * @param string $password
     */
    public function setPasswordraw($password)
    {
        $this->_password = Ahs_Utility::hash($password);
    }

    /**
     * Dummy setter for passwordrepeat form field.
     *
     * @param type $password
     */
    public function setPasswordrepeat($password)
    {
        // Do nothing
    }
}