<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/9/15
 * Time: 5:28 PM
 */

namespace App\classes\UserManagement\service;


class TestingSecrets extends SecretsParent
{

    public function loadCredentials($userid = false)
    {
        //if testing, credentials should be in env variables
        $this->host = getenv("DB_HOST");
        $this->databasename = getenv("DB_NAME");
        $this->username = getenv("DB_USERNAME");
        $this->password = getenv("DB_PASS");

        $this->makeDsn();
    }

}