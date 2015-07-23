<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace App\classes\UserManagement\models;

/**
 *
 * @author adam
 */
interface ISettableUser
{
    public function set_id($id);

    public function displayID();

    /**
     * Checks whether all db passwords are set and ready to be used.
     * @return TRUE|FALSE Boolean indicating whether all db credentials set
     */
    public function check_loaded();

    public function set_db_name($name);

    public function get_db_name();

    public function set_db_password($password);

    public function get_db_password();

    public function set_db_username($name);

    public function get_db_username();

    public function set_ro_password($password);

    public function get_ro_password();

    public function set_ro_username($name);

    public function get_ro_username();
}
