<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/21/15
 * Time: 7:54 AM
 */

namespace App\Exceptions;


class InputTypeException extends CustomException
{
    const STRING = 100;
    const INTEGER = 101;
    const FLOAT = 102;
    const EMAIL = 103;

    static public $messages = [
        "default" => "Unspecified error occurred",
        self::STRING => "Error validating string",
        self::INTEGER => "Error validating integer",
        self::EMAIL => "Error validating email"
    ];

}