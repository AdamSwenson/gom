<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/1/15
 * Time: 4:52 PM
 */

namespace UserManagement\dao;

use classes\MockParent;

class IDatabaseCreationDaoMock extends MockParent implements \UserManagement\dao\IDatabaseCreationDao
{

    /**
     * The main publicly called method which handles all operations for making the user schema
     * @param $user
     * @return bool
     * @throws \Exception
     */
    public function make($user)
    {
        $this->record_call(__FUNCTION__, array($user));
        return $this->response;
    }

    /**
     * Handles creating the new schema and granting the new user access to
     * the schema
     * @return bool
     * @throws \Exception
     */
    public function user_db_operations()
    {
        $this->record_call(__FUNCTION__, array());
        return $this->response;
    }

    public function new_db_operations()
    {
        $this->record_call(__FUNCTION__, array());
        return $this->response;
    }

    public function create_database()
    {
        $this->record_call(__FUNCTION__, array());
        return $this->response;
    }

    public function grant_user_access()
    {
        $this->record_call(__FUNCTION__, array());
        return $this->response;
    }

    /**
     * Reads sql dump files and populates the schema with tables.
     * @return bool
     * @throws \Exception
     */
    public function populate_tables()
    {
        $this->record_call(__FUNCTION__, array());
        return $this->response;
    }

    /**
     * Creates a pdo connection to the newly created database
     * @throws \Exception
     */
    public function createConnectionToNewDb()
    {
        $this->record_call(__FUNCTION__, array());
        return $this->response;
    }
}