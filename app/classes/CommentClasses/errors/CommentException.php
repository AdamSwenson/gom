<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/3/15
 * Time: 2:57 PM
 */

namespace App\classes\CommentClasses\errors;


class CommentException extends \Exception
{

    const INVALID_VALENCE = 100;
    const INVALID_TYPE  = 101;

    public static $messages = [
        "default" => "Unspecified error with comment tasks",
        self::INVALID_VALENCE => "Operation tried to use invalid value for valence ",
        self::INVALID_TYPE => "Operation tried to use invalid value for type "
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