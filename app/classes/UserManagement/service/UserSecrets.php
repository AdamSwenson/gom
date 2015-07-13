<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/9/15
 * Time: 8:54 PM
 */

namespace UserManagement\service;

use App\classes\SecurityClasses\environ\EnvironVarHolder;
use UserManagement\errors\CredentialsException;

/**
 * Class UserSecrets
 * Gets and holds the credentials for accessing the user database
 *
 * @package UserManagement\service
 */
class UserSecrets extends SecretsParent
{
    const SOURCE_ENV = 100;
    const SOURCE_FILE = 101;

    //names of environmental variables
    const VARNAME_HOST = "USERS_DB_HOST";
    const VARNAME_USERNAME = "USERS_READ_USERNAME";
    const VARNAME_PASSWORD = "USERS_READ_PASSWORD";
    const VARNAME_DBNAME = "USERS_DB_NAME";

    private static $credentialsFile = "/secrets/config.xml";

    protected $root;

    public function loadCredentials($userid = false, $source=self::SOURCE_ENV)
    {
        try {
            switch($source)
            {
                case self::SOURCE_ENV:
                    $this->loadCredentialsFromEnvironVars();
                    break;
                case self::SOURCE_FILE:
                    $this->loadCredentialsFromFile();
                    break;
                default:
                    throw new CredentialsException(CredentialsException::INVALID_SOURCE);
            }
            $this->makeDsn();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    protected function loadCredentialsFromEnvironVars()
    {
        $this->host = getenv(self::VARNAME_HOST);
        $this->username = getenv(self::VARNAME_USERNAME);
        $this->password = getenv(self::VARNAME_PASSWORD);
        $this->databasename = getenv(self::VARNAME_DBNAME);
    }

    protected function loadCredentialsFromFile()
    {
        $ex = simplexml_load_file(EnvironVarHolder::getInstance()->getPathToRoot() . self::$credentialsFile);
        $this->host = $ex->gomusers->db_host;
        $this->databasename = $ex->gomusers->db_database;
        $this->username = $ex->gomusers->db_username;
        $this->password = $ex->gomusers->db_pass;
    }


}