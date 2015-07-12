<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/1/15
 * Time: 4:49 PM
 */

namespace UserManagement\dao;


interface IDatabaseCreationDao 
{

    /**
     * The main publicly called method which handles all operations for making the user schema
     * @param $user
     * @return bool
     * @throws \Exception
     */
    public function make($user);

    /**
     * Handles creating the new schema and granting the new user access to
     * the schema
     * @return bool
     * @throws \Exception
     */
    public function user_db_operations();

    public function new_db_operations();

    public function create_database();

    public function grant_user_access();

    /**
     * Reads sql dump files and populates the schema with tables.
     * @return bool
     * @throws \Exception
     */
    public function populate_tables();

    /**
     * Creates a pdo connection to the newly created database
     * @throws \Exception
     */
    public function createConnectionToNewDb();

}