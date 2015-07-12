<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace UserManagement\models;

/**
 * Description of SettableUser
 *
 * @author adam
 */
class SettableUser implements \UserManagement\models\IUser, \UserManagement\models\ISettableUser
{
    protected $userID;
    protected $db_name;
    protected $db_password;
    protected $db_username;
    protected $ro_password;
    protected $ro_username;
    static public $db_items = array('db_name', 'db_password', 'db_username', 'ro_password', 'ro_username');

    /**
     * Checks whether all db passwords are set and ready to be used
     * @return TRUE|FALSE Boolean indicating whether all db credentials set
     */
    public function check_loaded()
    {
        foreach (self::$db_items as $item) {
            if (!isset($this->$item)) {
                return FALSE;
            }
        }
        return TRUE;
    }


//     /**
//     * Returns dsn plus username and password
//     */
//    public function db_dsn()
//    {
//        return "mysql:host=localhost;dbname={$this->db_name}, {$this->db_username}, {$this->db_password}";
//    }
//    
//    /**
//     * Returns dsn plus username and password for read only purposes
//     */
//    public function ro_dsn()
//    {
//        return "mysql:host=localhost;dbname={$this->db_name}, {$this->ro_username}, {$this->ro_password}";
//    }
    
    public function set_id($id)
    {
        $this->userID = $id;
    }

    public function backupDB()
    {
        return TRUE;
    }

    public function displayID()
    {
        return $this->userID;
    }

    public function display_db_credentials()
    {
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

    public function isAdmin()
    {
        return FALSE;
    }

    public function isReadOnly()
    {
        return FALSE;
    }

    public function isStudent()
    {
        return FALSE;
    }

    public function isTeacher()
    {
        return FALSE;
    }

    public function isTest()
    {
        return FALSE;
    }

//put your code here
}
