<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */

namespace UserManagement\models;

/**
 *
 * @author adam
 */
interface IDBCredentials {

    /**
     * Returns dsn plus username and password
     */
    public function db_dsn();

    public function get_db_name();
    
    public function get_db_username();
    
    public function get_db_password();
    
    public function get_ro_username();
    
    
    public function get_ro_password();
}
