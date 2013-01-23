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

class Backoffice_Model_AdminMapper
{
    protected $_dbTable;

    public function __construct()
    {
        $this->_dbTable = new Backoffice_Model_DbTable_Admins();
    }

    /**
     *
     * @param Backoffice_Model_Admin $admin
     */
    public function save(Backoffice_Model_Admin $admin)
    {
        $data = array(//'adm_id'         => $admin->getId(),
                      'adm_givenname'  => $admin->getGivenname(),
                      'adm_familyname' => $admin->getFamilyname(),
                      'adm_email'      => $admin->getEmail(),
                      'adm_username'   => $admin->getUsername(),
                      'adm_password'   => $admin->getPassword(),
        );

        if (null === $admin->getId()) {
            $this->_dbTable->insert($data);
        } else {
            //$data['adm_id'] = $admin->getId();
            $conditions[] = "adm_id = '" . $admin->getId() ."'";
            //Zend_Debug::dump($data);
            $this->_dbTable->update($data, $conditions);

            
        }
    }

    public function read($id = null)
    {
        $table = $this->_dbTable;

//        'SELECT adm_id AS id FROM Admins'
        $select = $table->select()
                        ->from($table,
                               array(
                                   'id'         => 'adm_id',
                                   'givenname'  => 'adm_givenname',
                                   'familyname' => 'adm_familyname',
                                   'email'      => 'adm_email',
                                   'username'   => 'adm_username',
                               )
                        )
                        ->where('adm_id = :id')
                        ->bind(array(':id' => $id))
       ;
       if ($row = $table->fetchRow($select)) {
           return $row->toArray();
       }

       throw new Exception('Record could not be found');
    }


    /**
     * @return array
     */
    public function fetchAll()
    {
        $rowset = $this->_dbTable->fetchAll();
        $admins = $this->_toObjects($rowset);

        return $admins;
    }

    /**
     * Convert row to object.
     *
     * @param Zend_Db_Table_Row_Abstract $row
     * @return Backoffice_Model_Admin
     */
    protected function _toObject(Zend_Db_Table_Row_Abstract $row = null)
    {
        $values = array();
        if ($row) {
            $values['id'      ] = $row['adm_id'      ];
            $values['username'] = $row['adm_username'];
        }

        return $admin = new Backoffice_Model_Admin($values);
    }

    /**
     * Convert rowset to array of objects.
     *
     * @param Zend_Db_Table_Rowset_Abstract $rowset
     * @return array
     */
    protected function _toObjects(Zend_Db_Table_Rowset_Abstract $rowset = null)
    {
        $objects = array();

        if ($rowset) {
            foreach ($rowset as $row) {
                $objects[] = $this->_toObject($row);
            }
        }

        return $objects;
    }
}