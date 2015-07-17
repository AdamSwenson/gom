<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/16/15
 * Time: 4:37 PM
 */

namespace Exceptions;

/**
 * Class CustomException
 *
 * The basis for customized exceptions.
 * Inheriting classes should define the covered exceptions in constants
 * and then add those constants as keys in the $messages array with the desired messages
 * as the values.
 *
 * Then, to throw the exception, you pass in the constant as the first
 * argument to construct.
 *
 * The second argument is a previously caught exception
 *
 * @package Exceptions
 */
class CustomException extends \Exception
{
    //define some constants to use in the messages

    static public $messages = [
        "default" => "Unspecified error occurred",
    ];

    /**
     * @param null $type One of the constants to determine exception type
     * @param null $exception A previously caught exception
     */
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