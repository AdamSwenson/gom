<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/3/15
 * Time: 10:55 AM
 */

namespace UserManagement\errors;

class CredentialsException extends \Exception
{

    const INVALID_SOURCE = 100;

    static public $messages = [
        "default" => "Unspecified credential error occurred",
        self::INVALID_SOURCE => "Invalid source for credentials requested"
    ];

    public function __construct($type=null, $exception=null)
    {
        $message = $this->chooseMessage($type);
        parent::__construct($message, null, $exception);
    }

    protected function chooseMessage($type)
    {
        if(array_key_exists($type, self::$messages)){
            return self::$messages[$type];
        }else{
            return self::$messages["default"];
        }
    }
}