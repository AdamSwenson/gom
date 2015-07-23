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
interface IUser
{
    public function get_db_name();

    public function get_db_username();

    public function get_db_password();


    /**
     * @return int Displays userID to comply with idshower interface
     */
    public function displayID();


    /**
     * @return boolean Returns true if user is an administrator
     * @todo Add is admin function
     */
    public function isAdmin();

    /**
     * @return boolean Returns true if user is a teacher
     * @todo Add isteacher function
     */
    public function isTeacher();

    /**
     * @return boolean Returns true if user is a student
     * @todo Add is student function
     */
    public function isStudent();

    /**
     * @todo Add isreadonly function
     */
    public function isReadOnly();

    /**
     * @return boolean Returns true if the associated db is the test database
     */
    public function isTest();
}
