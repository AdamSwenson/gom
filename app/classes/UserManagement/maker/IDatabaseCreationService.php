<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace UserManagement\maker;

/**
 *
 * @author adam
 */
interface IDatabaseCreationService {

//    /**
//     * Load the object which interacts with the new user's db
//     * @param \UserManagement\dao\IDatabaseCreationDao $db_management_dao
//     */
//    public function set_dataservice(\UserManagement\dao\IDatabaseCreationDao $db_management_dao);
//
//    /**
//     * Loads the object which interacts with the gradeomaticUSERS table
//     * @param \UserManagement\dao\IUserTableManagementDao $user_table_dao
//     */
//    public function set_user_table_service(\UserManagement\dao\IUserTableManagementDao $user_table_dao);

//    /**
//     * At a certain point in the user creation sequence, the db_creation_dao needs to switch connections
//     * so that it is using the connection to the user's schema (rather than gradematicUSERS). This function does that
//     */
//    public function update_dao_connection(\Interfaces\IDataAccessObject $dao);

//    /**
//     * This creates the database schema. Should be run upon activation of the account.
//     *
//     * @param \UserManagement\models\ISettableUser $user MUST HAVE db_name SET ALREADY
//     */
//    public function create_database(\UserManagement\models\ISettableUser $user);

//    /**
//     * This adds two procedures to the newly created database which will be used to call the procedures that build the databases.
//     *
//     * @param  \UserManagement\models\ISettableUser $user
//     * @return boolean
//     * @throws \Exception
//     */
//    public function create_handlers(\UserManagement\models\ISettableUser $user);

//    /**
//     * This uses the handler procedures to populate the database with tables
//     */
//    public function create_tables(\UserManagement\models\ISettableUser $user);

//    /**
//     * This will add the user to mysql with the appropriate privileges. Must run create_database first. Should be run upon activation of the account
//     */
//    public function register_user_schema(\UserManagement\models\ISettableUser $user);

//    /**
//     * This creates the gom stored procedures
//     */
//    public function create_procedures(\UserManagement\models\ISettableUser $user);
}
