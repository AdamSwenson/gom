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
interface ICredentialGenerator
{
    public function make_username();

    public function make_password();

    /**
     * This makes a standardized name for the user's database
     * @param  int  $databaseID The automatically generated id of the database
     * @return string
     */
    public function make_db_name($databaseID);
}
