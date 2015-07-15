<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace App\classes\UserManagement\maker;

/**
 *
 * @author adam
 */
interface IUserMaker
{
        /**
     * Loads the object which interacts with the gradeomaticUSERS table
     * @param \UserManagement\dao\IUserTableManagementDao $user_table_dao
     */
    public function set_user_table_service(\UserManagement\dao\IUserTableManagementDao $user_table_dao);

    /**
     * Loads the object which will create credentials for the new user
     * @param \UserManagement\maker\ICredentialGenerator $credential_generator
     */
    public function set_credential_generator(\UserManagement\maker\ICredentialGenerator $credential_generator);

    public function set_logger($logger);

        /**
     * This does the creating and inserting of the individual users' database credentials into gradeomaticUSERS. This should be separately run from the
     * db creation stuff and then the credentials retrieved for those processes.
     * @param  \UserManagement\models\ISettableUser $user This will normally be $this->user. IT MUST HAVE userID ALREADY SET!
     * @return \UserManagement\models\ISettableUser The user object with the credentials set
     * @throws \Exception
     */
    public function create_credentials(\UserManagement\models\ISettableUser $user);

    /**
     * Retrieves the database login credentials for use in other processess on the basis of userid.
     *
     * @param  \UserManagement\models\ISettableUser $user
     * @return \UserManagement\models\ISettableUser
     * @throws \Exception
     */
    public function retrieve_credentials(\UserManagement\models\ISettableUser $user);

    /**
     * Convenience method which calls make_user and retrieve_credentials
     * @todo load_user was originally created to avoid exposing loaded user to outside. But then changed to just return user. Should decide whether want that.
     * @param type $token
     * @returns \UserManagement\models\SettableUser object with all credential properties set
     */
    public function load_user($token);

    /**
     * This retrieves the userID for the newly activated account from the activation token. It loads the user id for use in the next steps.
     * @param string $token The activation token sent via email
     * @returns  \UserManagement\models\SettableUser object with userid set
     */
    public function make_user($token);

    public function set_user_access($user);
}
