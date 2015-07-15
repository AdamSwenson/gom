<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/1/15
 * Time: 1:32 PM
 */

namespace App\classes\UserManagement\errors;


class NewDbSetupException extends \Exception
{
    const CONNECTION_FAIL_NEW_DB = 100;

    const CONNECTION_FAIL_GOM_USERS = 101;

    const OPERATIONS_FAIL_USERDB = 200;

    const OPERATIONS_FAIL_NEWDB = 201;

    const OPERATIONS_FAIL_CREATE = 202;

    const OPERATIONS_FAIL_GRANT = 203;

    const OPERATIONS_FAIL_POPULATE = 204;

    const OPERATIONS_SAVE_CREDENTIALS = 205;

    const OPERATIONS_FAIL_MAKE = 206;

    const TOKEN_RETRIEVAL = 300;

    const USER_CREDENTIALS_SET = 301;


    public $myType;

    public $message;

    public function __construct($type = null, \Exception $exception = null)
    {
        $this->myType = $type;
        $this->chooseMessage($type);
        if(!empty($exception))
        {
            parent::__construct($this->message, $exception->getCode(), $exception->getPrevious());
        }else{
            parent::__construct($this->message);
        }

    }

    public function chooseMessage($type)
    {
        switch ($type) {
            case self::CONNECTION_FAIL_NEW_DB:
                $this->message = "Failed to create connection to the newly created database ";
                break;
            case self::CONNECTION_FAIL_GOM_USERS:
                $this->message = "Failed to connect to gom_users database  ";
                break;
            case self::OPERATIONS_FAIL_USERDB:
                $this->message = "Failure during operations on gom_users ";
                break;
            case self::OPERATIONS_FAIL_NEWDB:
                $this->message = "Failure during operations on new schema ";
                break;
            case self::OPERATIONS_FAIL_CREATE:
                $this->message = "Failure creating new schema ";
                break;
            case self::OPERATIONS_FAIL_GRANT:
                $this->message = "Failure granting user permissions ";
                break;
            case self::OPERATIONS_FAIL_POPULATE:
                $this->message = "Failure populating new tables ";
                break;
            case self::OPERATIONS_SAVE_CREDENTIALS:
                $this->message = "Error inserting credentials into gradeomaticUsers ";
                break;
            case self::OPERATIONS_FAIL_MAKE:
                $this->message = "Error with making db ";
                break;
            case self::TOKEN_RETRIEVAL:
                $this->message = "Error retreiving userid based on token ";
                break;
            case self::USER_CREDENTIALS_SET:
                $this->message = "Error setting credentials for user into user object ";
                break;

            default:
                $this->message = null;
        }
    }

}