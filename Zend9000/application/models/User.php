<?php

class Application_Model_User
{
    /**
     * User name
     *
     * @var string
     */
    protected $_username;

    /**
     * Password
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
    public function getPassword()
    {
        return $this->_password;
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