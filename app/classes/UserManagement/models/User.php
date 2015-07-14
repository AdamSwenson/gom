<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */

namespace App\classes\UserManagement\models;

use App\classes\UserManagement\models\IDBCredentials;
use App\classes\UserManagement\models\IUser;

/**
 * New version of user
 * @author adam
 */
class User implements IUser, IDBCredentials
{
 
    /** @var $userID User User ID passed in from usercake system */
    protected $userID;
    
    /** @var boolean Whether the user is currently logged in. This is the variable which applications check to determine whether to display content. */
    public $logged_in;

    /** @var string The user's displayname */
    public $display_name;

    /** @var test_user boolean Whether the user is a test user. Used to determine whether to use the real or test db */
    protected $test_user;

    /** @var $db_name User String name of the user's gradeomatic database */
    private $db_name;

    /** @var $db_username User String The username of the user's gradeomatic database */
    private $db_username;

    /** @var $db_password User String The password for the user's gradeomatic database */
    private $db_password;
    
    /** @var $ro_username User Read only username*/
    private $ro_username;
    
    /** @var $ro_password User Read only password*/
    private $ro_password;


    public function __construct(\loggedInUser $loggedinuser)
    {
        $this->userID = $loggedinuser->user_id;
        $this->logged_in = true;
        $this->display_name = $loggedinuser->displayname;
    }
    
    public function load_credentials()
    {
        $result = fetchDatabaseCredentials($this->userID);
        $this->db_name = $result['db_name'];
        $this->db_username = $result['db_username'];
        $this->db_password = $result['db_password'];
        $this->ro_username = $result['ro_username'];
        $this->ro_password = $result['ro_password'];
    }

    public function set_db_name($name)
    {
        $this->db_name = $name;
    }

    public function get_db_name()
    {
        return $this->db_name;
    }
        public function set_db_password($password)
    {
        $this->db_password = $password;
    }

    public function get_db_password()
    {
        return $this->db_password;
    }

    public function set_db_username($name)
    {
        $this->db_username = $name;
    }

    public function get_db_username()
    {
        return $this->db_username;
    }

    public function get_ro_password()
    {
        return $this->ro_password;
    }

    public function set_ro_password($password)
    {
        $this->ro_password = $password;
    }

    public function set_ro_username($name)
    {
        $this->ro_username = $name;
    }

    public function get_ro_username()
    {
        return $this->ro_username;
    }
//
//    public function get_db_name()
//    {
//        return $this->db_name;
//    }
//    
//    public function get_db_username()
//    {
//        return $this->db_username;
//    }
//    
//    public function get_db_password() {
//        return $this->db_password;
//    }
//    
//    public function get_ro_username()
//    {
//        return $this->ro_username;
//    }
//    
//    public function get_ro_password() {
//        return $this->ro_password;
//    }

    /**
     * Returns dsn (host and dbname string)
     */
    public function db_dsn()
    {
        return "mysql:host=localhost;dbname=" . $this->db_name;
//        return "mysql:host=localhost;dbname=" . $this->db_name . ", " . $this->db_username . " , " . $this->db_password . "";
    }
    
    
    /**
     * @return int Displays userID to comply with idshower interface
     */
    public function displayID() { return $this->userID; }



    /**
     * @return boolean Returns true if user is an administrator
     * @todo Add is admin function
     */
    public function isAdmin()
    {
        return true;
    }

    /**
     * @return boolean Returns true if user is a teacher
     * @todo Add isteacher function
     */
    public function isTeacher()
    {
        return true;
    }

    /**
     * @return boolean Returns true if user is a student
     * @todo Add is student function
     */
    public function isStudent()
    {
        return false;
    }

    /**
     * @return boolean Returns true if user is a student grader
     */
    public function isStudentGrader()
    {
        return false;
    }

    /**
     * @todo Add isreadonly function
     */
    public function isReadOnly()
    {
        return false;
    }

    /**
     * @return boolean Returns true if the associated db is the test database
     */
    public function isTest()
    {
        return true;
    }


}
